<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

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
            'appointment.clinic',
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
            // Jika sudah punya snap_token dan masih pending, gunakan yang lama
            if ($order->snap_token && $order->isPending()) {
                return response()->json([
                    'snap_token' => $order->snap_token
                ]);
            }

            $appointment = $order->appointment;
            $user = $appointment->user;

            // Prepare transaction details
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_code,
                    'gross_amount' => (int) $order->amount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '',
                ],
                'item_details' => [
                    [
                        'id' => 'BOOKING-FEE',
                        'price' => (int) $order->amount,
                        'quantity' => 1,
                        'name' => 'Biaya Booking Konsultasi',
                    ],
                ],
                'callbacks' => [
                    'finish' => route('payment.finish', $order),
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            // Simpan snap token
            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'snap_token' => $snapToken
            ]);

        } catch (\Exception $e) {
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
            $notification = new Notification();

            $orderCode = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? null;
            $transactionId = $notification->transaction_id;
            $paymentType = $notification->payment_type;

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
            \Log::error('Midtrans Webhook Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Set order sebagai paid
     */
    private function setOrderPaid($order, $transactionId, $paymentType, $notification)
    {
        $order->update(['status' => 'paid']);
        
        $this->updateOrCreatePayment($order, $transactionId, $paymentType, 'success', $notification);

        // Update appointment status jika perlu
        // $order->appointment->update(['payment_status' => 'paid']);
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