<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Cart;
use Carbon\Carbon;

class OrderController extends Controller
{
    //
    public function checkout()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('variant.product', 'variant.size')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->withErrors(['cart' => 'Keranjang Anda kosong.']);
        }

        return view('order.checkout', compact('cartItems'));
    }

    public function placeOrder(Request $request)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Validasi input
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
            'no_phone' => 'required|string|max:15',
            'payment_receipt' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan bukti pembayaran
        $paymentReceipt = $request->file('payment_receipt');
        $paymentReceiptPath = $paymentReceipt->store('public/payment_receipts');

        // Buat order baru
        $order = new Order();
        $order->user_id = $user->id;
        $order->order_date = Carbon::now();
        $order->address = $validatedData['address'];
        $order->no_phone = $validatedData['no_phone'];
        $order->payment_receipt = $paymentReceiptPath;
        $order->is_paid = false;
        $order->save();

        // Simpan detail order
        $cartItems = Cart::where('user_id', $user->id)->with('variant.product', 'variant.size')->get();

        foreach ($cartItems as $item) {
            DetailOrder::create([
                'order_id' => $order->id,
                'variant_id' => $item->variant_id,
                'amount' => $item->amount,
            ]);

            // Kurangi stok produk
            $item->variant->product->stock -= $item->amount;
            $item->variant->product->save();
        }

        // Hapus semua item di keranjang
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('order.success')->with('success', 'Pesanan Anda berhasil dilakukan. Bukti pembayaran akan dikonfirmasi oleh admin.');
    }

    public function success()
    {
        return view('order.success');
    }
}
