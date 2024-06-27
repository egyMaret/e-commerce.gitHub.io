<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return view('sizes.index', compact('sizes'));
    }

    public function create()
    {
        return view('sizes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Size::create([
            'name' => $request->name,
        ]);

        return redirect()->route('sizes.index')->with('success', 'Ukuran berhasil ditambahkan.');
    }
    
    public function edit($id)
    {
        $size = Size::findOrFail($id);
        return view('sizes.edit', compact('size'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $size = Size::findOrFail($id);
        $size->update([
            'name' => $request->name,
        ]);

        return redirect()->route('sizes.index')->with('success', 'Ukuran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return redirect()->route('sizes.index')->with('success', 'Ukuran berhasil dihapus.');
    }
}
