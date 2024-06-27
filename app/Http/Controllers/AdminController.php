<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Product;

class AdminController extends Controller
{
    //
    public function index()
    {
        return view('admin.home');
    }

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // Menampilkan daftar pesanan yang belum dikonfirmasi
    public function orders()
    {
        $orders = Order::where('is_paid', false)->get();
        return view('admin.orders', compact('orders'));
    }

    // Mengonfirmasi pesanan
    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->is_paid = true;
        $order->save();

        return redirect()->route('admin.orders')->with('success', 'Order berhasil dikonfirmasi.');
    }

    // public function cancelOrder($id)
    // {
    //     $order = Order::findOrFail($id);

    //     // Mengembalikan jumlah stock product yang terkait
    //     foreach ($order->details as $detail) {
    //         $variant = Variant::where('id', $detail->variant_id)->first();
    //         if ($variant) {
    //             $variant->stock += $detail->amount;
    //             $variant->save();
    //         }
    //     }

    //     // Menghapus order dan detail order
    //     $order->details()->delete();
    //     $order->delete();

    //     return redirect()->route('admin.orders')->with('success', 'Order berhasil dibatalkan.');
    // }
}
