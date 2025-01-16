<?php

namespace App\Http\Controllers;

// use App\Services\MidtransService;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Providers\MidtransServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;


class PaymentController extends Controller
{
    public function checkout(Request $request){
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $cartItems = Cart::where('user_id', $validated['user_id'])->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty!'], 400);
        }

        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price; // Pastikan `price` ada di model Product
        });

        DB::beginTransaction();
        try {
            
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'status' => 'pending',
                'total_price' => $totalPrice,
                'price' => $cartItems->first()->product->price, // Harga pertama
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);
            }
            Cart::where('user_id', $validated['user_id'])->delete();

            DB::commit();

            Config::$serverKey = config('MidtransService.server_key');
            Config::$clientKey = config('MidtransService.client_key');
            Config::$isProduction = config('MidtransService.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $transactionDetails = [
                'order_id' => $order->id,
                'gross_amount' => intval($totalPrice)
            ];

            $CustomerDetails = [
                'email' => $order->user->email ?? 'example@mail.com',
                'first_name' => $order->user->name ?? 'guest',
            ];

            $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $CustomerDetails,
            ];
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'order_id' => $order->order_id,
                'snap_token' => $snapToken,
                'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/348addec-57b5-47d1-bdfd-40e35a41c9a3',
            ]);
        }

            // return response()->json(['message' => 'Checkout successful!', 'order' => $order], 201);
        
            catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Checkout failed!', 'error' => $e->getMessage()], 500);
        }
    }

    public function callback(Request $request){ 
        $serverKey = config('MidtransService.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'capture'){
                $order = Order::find($request->order_id);
                $order->update(['status' => 'Paid']);
            }
        }
    }

    // public function paymentNotification(Request $request)
    // {
    //     // Konfigurasi Midtrans
    //     Config::$serverKey = config('MidtransService.server_key');
    //     Config::$isProduction = config('MidtransService.is_production', false);
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;

    //     // Ambil data notifikasi dari Midtrans
    //     $notification = new Notification();

    //     $transactionStatus = $notification->transaction_status;
    //     $orderId = $notification->order_id;

    //     // Cari pesanan berdasarkan order_id
    //     $order = Order::where('id', $orderId)->first();

    //     if (!$order) {
    //         return response()->json(['message' => 'Order not found!'], 404);
    //     }

    //     // Ubah status berdasarkan status transaksi
    //     if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
    //         $order->status = 'paid'; // Pesanan dibayar
    //     } elseif ($transactionStatus == 'pending') {
    //         $order->status = 'pending'; // Menunggu pembayaran
    //     } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
    //         $order->status = 'failed'; // Gagal atau dibatalkan
    //     }

    //     $order->save();

    //     return response()->json(['message' => 'Payment notification handled successfully!'], 200);
    // }

}
