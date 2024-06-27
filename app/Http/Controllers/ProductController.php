<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'required|image|max:2048'
        ]);

        // Simpan gambar
        $imagePath = $request->file('image')->store('product_images', 'public');

        // Simpan produk
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->category = $validatedData['category'];
        $product->price = $validatedData['price'];
        $product->stock = $validatedData['stock'];
        $product->image = $imagePath;
        $product->save();

        return redirect()->route('products.show', $product->id);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $sizes = Size::all();

        $products = Product::where('id', '!=', $id)->latest()->take(4)->get();

        return view('products.show', compact('product', 'sizes', 'products'));
    }

    public function index()
    {
        $products = Product::all();
        $categories = Product::select('category')->distinct()->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($product->image);

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('product_images', 'public');
            $product->image = $imagePath;
        }

        // Update produk
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->category = $validatedData['category'];
        $product->price = $validatedData['price'];
        $product->stock = $validatedData['stock'];
        $product->save();

        return redirect()->route('products.show', $product->id);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar dari storage
        Storage::disk('public')->delete($product->image);

        // Hapus produk dari database
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $products = Product::where('name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('description', 'LIKE', "%{$searchTerm}%")
            ->get();
        $categories = Product::select('category')->distinct()->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function filter(Request $request)
    {
        $category = $request->input('category');
        if ($category) {
            $products = Product::where('category', $category)->get();
        } else {
            $products = Product::all();
        }
        $categories = Product::select('category')->distinct()->get();

        return view('products.index', compact('products', 'categories'));
    }
}
