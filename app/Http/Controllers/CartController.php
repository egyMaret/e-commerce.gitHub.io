<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Size;
use App\Models\Product;
use App\Models\Variant;

class CartController extends Controller
{
    //
    public function addToCart(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'size_id' => 'required|exists:sizes,id',
            'amount' => 'required|integer|min:1',
        ], [
            'size_id.required' => 'Harap pilih ukuran',
            'size_id.exists' => 'Ukuran tidak valid',
            'amount.required' => 'Harap isi jumlah produk',
            'amount.integer' => 'Jumlah produk harus berupa angka',
            'amount.min' => 'Jumlah produk minimal 1',
        ]);

        $user = Auth::user();
        $sizeId = $request->input('size_id');
        $amount = $request->input('amount');

        $product = Product::findOrFail($productId);

        if ($amount > $product->stock) {
            return redirect()->back()->withErrors(['amount' => 'Stok produk tidak cukup'])->withInput();
        }

        $cartItem = Cart::where('user_id', $user->id)->whereHas('variant', function ($query) use ($productId, $sizeId) {
            $query->where('product_id', $productId)->where('size_id', $sizeId);
        })->first();

        if ($cartItem) {
            $cartItem->amount += $amount;
            $cartItem->save();
        } else {
            $variant = Variant::where('product_id', $productId)->where('size_id', $sizeId)->first();

            if ($variant) {
                Cart::create([
                    'user_id' => $user->id,
                    'variant_id' => $variant->id,
                    'amount' => $amount,
                ]);
            } else {
                $variant = Variant::create([
                    'product_id' => $productId,
                    'size_id' => $sizeId,
                ]);
                Cart::create([
                    'user_id' => $user->id,
                    'variant_id' => $variant->id,
                    'amount' => $amount,
                ]);
            }
        }

        return redirect()->route('cart.show')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }


    public function showCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('variant.product', 'variant.size')->get();
        $sizes = Size::all(); 

        return view('cart.show', compact('cartItems', 'sizes'));
    }

    public function updateCart(Request $request, $cartId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'size_id' => 'required|exists:sizes,id',
            'amount' => 'required|integer|min:1',
        ], [
            'size_id.required' => 'Harap pilih ukuran',
            'size_id.exists' => 'Ukuran tidak valid',
            'amount.required' => 'Harap isi jumlah produk',
            'amount.integer' => 'Jumlah produk harus berupa angka',
            'amount.min' => 'Jumlah produk minimal 1',
        ]);

        $user = Auth::user();
        $sizeId = $request->input('size_id');
        $amount = $request->input('amount');

        $cart = Cart::where('id', $cartId)->where('user_id', $user->id)->firstOrFail();
        $product = $cart->variant->product;

        if ($amount > $product->stock) {
            return redirect()->back()->withErrors(['amount' => 'Stok produk tidak cukup'])->withInput();
        }

        $variant = Variant::where('product_id', $product->id)->where('size_id', $sizeId)->first();

        if ($variant) {
            $cart->variant_id = $variant->id;
            $cart->amount = $amount;
            $cart->save();
        } else {
            
            $variant = Variant::create([
                'product_id' => $product->id,
                'size_id' => $sizeId,
            ]);
            $cart->variant_id = $variant->id;
            $cart->amount = $amount;
            $cart->save();
        }

        return redirect()->route('cart.show')->with('success', 'Keranjang berhasil diperbarui');
    }


    public function removeFromCart($cartId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $cart = Cart::where('id', $cartId)->where('user_id', $user->id)->firstOrFail();
        $variant = $cart->variant;

        $cart->delete();

        if (Cart::where('variant_id', $variant->id)->count() == 0) {
            $variant->delete();
        }

        return redirect()->route('cart.show')->with('success', 'Produk berhasil dihapus dari keranjang');
    }
}
