<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Transaction;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    //

    public function index(){
        $orders = Order::with('items')->paginate(5);
        return view('orders.index', compact('orders'));
    }

    public function getData(Request $request)
    {
        $orders = Order::select('orders.*');

        return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('action', function ($order) {
                return '
                    <div class="d-flex">
                        <a href="' . route('orders.detail', $order->id) . '" class="btn btn-sm btn-dark mr-2"><i class="fa fa-eye"></i></a>
                        <form onsubmit="return confirm(\'Apakah Anda Yakin ?\');" action="' . route('orders.destroy', $order->id) . '" method="POST">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $orders = Order::all();
        
        return view('orders.create', compact('orders'));
    }

    public function detail($id)
    {
        // $orders = Order::find($id);
        $orders = Order::with('items')->findOrFail($id);
        // $order_item = Order::with('orderItems')->findOrFail($id);

        return view('orders.detail', compact('orders'));
    }
    // public function checkout(Request $request)
    // {
    //     $validated = $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //     ]);

    //     // Ambil item keranjang pengguna
    //     $cartItems = Cart::where('user_id', $validated['user_id'])->get();

    //     if ($cartItems->isEmpty()) {
    //         return response()->json(['message' => 'Cart is empty!'], 400);
    //     }

    //     // Hitung total harga
    //     $totalPrice = $cartItems->sum(function ($cartItem) {
    //         return $cartItem->quantity * $cartItem->product->price; // Pastikan `price` ada di model Product
    //     });

    //     DB::beginTransaction();
    //     try {
    //         // Buat order
    //         $order = Order::create([
    //             'user_id' => $validated['user_id'],
    //             'status' => 'pending',
    //             'total_price' => $totalPrice,
    //             'price' => $cartItems->first()->product->price, // Harga pertama
    //         ]);

    //         // Tambahkan item ke order_items
    //         foreach ($cartItems as $cartItem) {
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $cartItem->product_id,
    //                 'quantity' => $cartItem->quantity,
    //                 'price' => $cartItem->product->price,
    //             ]);
    //         }

    //         // Kosongkan keranjang
    //         Cart::where('user_id', $validated['user_id'])->delete();

    //         DB::commit();
            

    //         return response()->json(['message' => 'Checkout successful!', 'order' => $order], 201);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['message' => 'Checkout failed!', 'error' => $e->getMessage()], 500);
    //     }
    // }
    
        public function listOrders(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id', // Validasi user_id
        ]);

        $orders = Order::where('user_id', $validated['user_id'])
            ->with('items.product') 
            ->orderBy('created_at', 'desc') 
            ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'message' => 'No orders found for this user.',
                'orders' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Orders retrieved successfully.',
            'orders' => $orders
        ], 200);
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        $order->delete();

        return back()->with('success', 'order deleted successfully');
    }

    public function __construct()
    {
        Config::$serverKey = config('MidtransService.server_key');
        Config::$isProduction = config('MidtransService.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function updateOrderStatus(Request $request)
    {
        $orderId = $request->input('order_id');

        if (!$orderId) {
            return response()->json(['error' => 'Order ID is required'], 400);
        }

        try {

            $orderId = '1';

            $transactionStatus = Transaction::status($orderId);

            $status = $transactionStatus;

            if ($status == 'settlement') {
                
                $order = Order::where('order_id', $orderId)->first();
                if ($order) {
                    $order->status = 'paid';
                    $order->save();
                }
            } elseif ($status == 'pending') {
                // Update status order ke "Pending Payment"
                $order = Order::where('order_id', $orderId)->first();
                if ($order) {
                    $order->status = 'pending';
                    $order->save();
                }
            } elseif ($status == 'cancel') {
                // Update status order ke "Canceled"
                $order = Order::where('order_id', $orderId)->first();
                if ($order) {
                    $order->status = 'canceled';
                    $order->save();
                }
            }
            return response()->json([
                'success' => true,
                'status' => $status,
                'message' => 'Order status updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch transaction status.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


}
