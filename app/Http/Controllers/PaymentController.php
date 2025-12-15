<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Halaman konfirmasi pembayaran
     */
    public function show(Order $order)
    {
        // Load semua relasi yang dibutuhkan
        $order->load([
            'appointment.doctor',
            'appointment.user',
            'appointment.schedule.polyclinic'
        ]);

        // Jika sudah dibayar, redirect ke tiket
        if ($order->isPaid()) {
            return redirect()->route('tiket-antrian')
                ->with('success', 'Pembayaran sudah berhasil!');
        }

        return view('payment.confirm', compact('order'));
    }

    /**
     * Proses pembayaran - Generate Snap Token
     */
    public function process(Order $order)
    {
        try {
            // Log untuk debugging
            Log::info('Payment Process Started', [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'amount' => $order->amount
            ]);

            // Jika sudah punya snap_token dan masih pending, gunakan yang lama
            if ($order->snap_token && $order->isPending()) {
                Log::info('Using existing snap token', ['order_id' => $order->id]);
                return response()->json([
                    'snap_token' => $order->snap_token
                ]);
            }

            // Load appointment dengan relasi
            $order->load('appointment.user');
            
            $appointment = $order->appointment;
            
            if (!$appointment) {
                Log::error('Appointment not found', ['order_id' => $order->id]);
                return response()->json([
                    'error' => 'Appointment tidak ditemukan'
                ], 404);
            }

            $user = $appointment->user;
            
            if (!$user) {
                Log::error('User not found', ['order_id' => $order->id]);
                return response()->json([
                    'error' => 'User tidak ditemukan'
                ], 404);
            }

            // Validasi amount
            $amount = (int) $order->amount;
            if ($amount <= 0) {
                Log::error('Invalid amount', ['amount' => $amount]);
                return response()->json([
                    'error' => 'Jumlah pembayaran tidak valid'
                ], 400);
            }

            Log::info('Preparing Midtrans params', [
                'order_code' => $order->order_code,
                'amount' => $amount,
                'user' => $user->name
            ]);

            // Prepare transaction details
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_code . '-' . time(),
                    'gross_amount' => $amount,
                ],

                'enabled_payments' => [
                    'qris', 'gopay', 'shopeepay'
                ],

                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],

                'item_details' => [[
                    'id' => 'BOOKING-FEE',
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Biaya Booking Konsultasi Gigi',
                ]],
            ];



            Log::info('Calling Midtrans Snap API');

            // Get Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            Log::info('Snap token generated', [
                'token' => substr($snapToken, 0, 20) . '...'
            ]);

            // Simpan snap token
            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'snap_token' => $snapToken
            ]);

        } catch (\Exception $e) {
            // Log error lengkap
            Log::error('Payment Process Error', [
                'order_id' => $order->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Gagal memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Callback setelah pembayaran selesai (dari Midtrans Snap)
     */
    public function finish(Order $order)
    {
        return redirect()->route('tiket-antrian')
            ->with('info', 'Menunggu konfirmasi pembayaran...');
    }

    /**
     * Webhook dari Midtrans (notification handler)
     */
    public function webhook(Request $request)
    {
        try {
            Log::info('Midtrans Webhook Received', $request->all());

            $notification = new Notification();

            $orderCode = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? null;
            $transactionId = $notification->transaction_id;
            $paymentType = $notification->payment_type;

            Log::info('Webhook Details', [
                'order_code' => $orderCode,
                'status' => $transactionStatus,
                'payment_type' => $paymentType
            ]);

            $order = Order::where('order_code', $orderCode)->firstOrFail();

            // Handle transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $this->setOrderPaid($order, $transactionId, $paymentType, $notification);
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->setOrderPaid($order, $transactionId, $paymentType, $notification);
            } elseif ($transactionStatus == 'pending') {
                $order->update(['status' => 'pending']);
                $this->updateOrCreatePayment($order, $transactionId, $paymentType, 'pending', $notification);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->update(['status' => 'failed']);
                $this->updateOrCreatePayment($order, $transactionId, $paymentType, 'failed', $notification);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Set order sebagai paid
     */
    private function setOrderPaid($order, $transactionId, $paymentType, $notification)
    {
        Log::info('Setting order as paid', ['order_id' => $order->id]);
        
        $order->update(['status' => 'paid']);
        
        $this->updateOrCreatePayment($order, $transactionId, $paymentType, 'success', $notification);
    }

    /**
     * Update or create payment record
     */
    private function updateOrCreatePayment($order, $transactionId, $paymentType, $status, $notification)
    {
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'transaction_id' => $transactionId,
                'payment_method' => $paymentType,
                'payment_status' => $status,
                'paid_at' => $status === 'success' ? now() : null,
                'payment_response' => json_encode($notification),
            ]
        );
    }
}