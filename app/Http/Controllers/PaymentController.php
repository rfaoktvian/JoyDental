<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
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
        $order->load([
            'appointment.doctor',
            'appointment.user',
            'appointment.clinic'
        ]);

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
            Log::info('Payment Process Started', [
                'order_id'   => $order->id,
                'order_code' => $order->order_code,
                'amount'     => $order->amount
            ]);

            if ($order->snap_token && $order->isPending()) {
                return response()->json(['snap_token' => $order->snap_token]);
            }

            $order->load('appointment.user');
            $user = $order->appointment?->user;

            if (!$user) {
                return response()->json(['error' => 'User tidak ditemukan'], 404);
            }

            $amount = (int) $order->amount;
            if ($amount <= 0) {
                return response()->json(['error' => 'Amount tidak valid'], 400);
            }

            // Generate Midtrans Order ID (UNIQUE)
            $midtransOrderId = $order->order_code . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id' => $midtransOrderId,
                    'gross_amount' => $amount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => [[
                    'id' => 'BOOKING-FEE',
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Biaya Booking Konsultasi',
                ]],
                'callbacks' => [
                    'finish' => route('payment.finish', $order)
                ]
            ];

            $snapToken = Snap::getSnapToken($params);

            $order->update([
                'snap_token' => $snapToken,
                'midtrans_order_id' => $midtransOrderId,
                'status' => 'pending'
            ]);

            Log::info('Snap Token Generated', [
                'order_id' => $order->id,
                'midtrans_order_id' => $midtransOrderId
            ]);

            return response()->json(['snap_token' => $snapToken]);

        } catch (\Exception $e) {
            Log::error('Payment Process Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Gagal memproses pembayaran: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Callback setelah pembayaran selesai (dari Midtrans Snap)
     */
    public function finish(Order $order)
    {
        sleep(2);
        
        $order = Order::with('payment')->find($order->id);
        
        Log::info('Payment Finish Callback', [
            'order_id' => $order->id,
            'status' => $order->status,
            'payment_status' => $order->payment?->payment_status
        ]);

        if ($order->isPaid()) {
            return redirect()->route('tiket-antrian', ['payment' => 'success'])
                ->with('success', 'Pembayaran berhasil! Tiket Anda sudah aktif.');
        } elseif ($order->isPending()) {
            return redirect()->route('tiket-antrian', ['payment' => 'pending'])
                ->with('info', 'Pembayaran sedang diproses. Mohon tunggu konfirmasi.');
        } else {
            return redirect()->route('tiket-antrian', ['payment' => 'failed'])
                ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
        }
    }
    public function webhook(Request $request)
    {
        $logFile = storage_path('logs/midtrans-webhook.log');
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - WEBHOOK RECEIVED\n", FILE_APPEND);
        file_put_contents($logFile, json_encode($request->all(), JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);
        
        try {
            Log::info('=== MIDTRANS WEBHOOK RECEIVED ===', [
                'all_data' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            // Validasi signature
            $signatureKey = hash(
                'sha512',
                $request->order_id .
                $request->status_code .
                $request->gross_amount .
                config('midtrans.server_key')
            );

            if ($signatureKey !== $request->signature_key) {
                Log::warning('Invalid Midtrans Signature', [
                    'expected' => $signatureKey,
                    'received' => $request->signature_key
                ]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Cari order berdasarkan midtrans_order_id
            $order = Order::where('midtrans_order_id', $request->order_id)->first();

            if (!$order) {
                Log::error('Order not found in webhook', [
                    'midtrans_order_id' => $request->order_id,
                    'all_orders' => Order::pluck('midtrans_order_id', 'id')
                ]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            $transactionStatus = $request->transaction_status;
            $fraudStatus = $request->fraud_status ?? 'accept';
            $paymentType = $request->payment_type;
            $transactionId = $request->transaction_id;

            Log::info('Processing Webhook Status', [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'payment_type' => $paymentType
            ]);

            DB::beginTransaction();
            
            try {
                // Update status order berdasarkan transaction status
                if ($transactionStatus == 'capture') {
                    if ($fraudStatus == 'accept') {
                        $this->setOrderPaid($order, $transactionId, $paymentType, $request->all());
                    }
                } 
                elseif ($transactionStatus == 'settlement') {
                    $this->setOrderPaid($order, $transactionId, $paymentType, $request->all());
                } 
                elseif ($transactionStatus == 'pending') {
                    $order->update(['status' => 'pending']);
                    $this->updateOrCreatePayment($order, $transactionId, $paymentType, 'pending', $request->all());
                } 
                elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                    $order->update(['status' => 'failed']);
                    $this->updateOrCreatePayment($order, $transactionId, $paymentType, 'failed', $request->all());
                }

                DB::commit();

                Log::info('Webhook Processed Successfully', [
                    'order_id' => $order->id,
                    'new_status' => $order->status
                ]);

                return response()->json(['message' => 'OK']);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Webhook Processing Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Server error'], 500);
        }
    }


    private function setOrderPaid($order, $transactionId, $paymentType, $notificationData)
    {
        Log::info('Setting Order as PAID', [
            'order_id' => $order->id,
            'transaction_id' => $transactionId
        ]);
        
        $order->update(['status' => 'paid']);
        
        $this->updateOrCreatePayment($order, $transactionId, $paymentType, 'success', $notificationData);
    }

    private function updateOrCreatePayment($order, $transactionId, $paymentType, $status, $notificationData)
    {
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'transaction_id' => $transactionId,
                'payment_method' => $paymentType,
                'payment_status' => $status,
                'paid_at' => $status === 'success' ? now() : null,
                'payment_response' => json_encode($notificationData),
            ]
        );

        Log::info('Payment Record Updated', [
            'order_id' => $order->id,
            'payment_status' => $status
        ]);
    }
}