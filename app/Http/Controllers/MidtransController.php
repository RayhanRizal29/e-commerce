<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    //

    public function __construct()
    {
        Config::$serverKey = config('MidtransService.server_key');
        Config::$isProduction = config('MidtransService.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function handleWebhook(Request $request)
    {
        try {

            Log::info('Midtrans Webhook Payload:', $request->all());
            // Mendapatkan notifikasi dari Midtrans
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;

            // Lakukan sesuatu berdasarkan status transaksi
            $order = Order::where('order_id', $orderId)->first();

            if ($order) {
                switch ($transactionStatus) {
                    case 'capture':
                        $order->status = 'paid';
                        break;
                    case 'settlement':
                        $order->status = 'paid';
                        break;
                    case 'pending':
                        $order->status = 'pending';
                        break;
                    case 'deny':
                        $order->status = 'failed';
                        break;
                    case 'cancel':
                        $order->status = 'canceled';
                        break;
                    case 'expire':
                        $order->status = 'expired';
                        break;
                    case 'refund':
                        $order->status = 'refunded';
                        break;
                }
                $order->save();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to process notification',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
