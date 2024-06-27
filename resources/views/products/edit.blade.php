@extends('layouts.app2')

@section('content')
    @can('admin')
        <div class="container">
            <h1>Edit Produk</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Produk</label>
                    <input type="text" name="name" class="form-control" id="name"
                        value="{{ old('name', $product->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" id="description" rows="3" required>{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="category">Kategori</label>
                    <input type="text" name="category" class="form-control" id="category"
                        value="{{ old('category', $product->category) }}" required>
                </div>
                <div class="form-group">
                    <label for="price">Harga</label>
                    <input type="number" name="price" class="form-control" id="price"
                        value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stok</label>
                    <input type="number" name="stock" class="form-control" id="stock"
                        value="{{ old('stock', $product->stock) }}" required>
                </div>
                <div class="form-group">
                    <label for="image">Gambar Produk</label>
                    <input type="file" name="image" class="form-control-file" id="image">
                    @if ($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                            style="max-width: 200px; margin-top: 10px;">
                    @endif
                </div>
                <button type="submit" class="btn btn-primary" style="margin: 24px;">Update</button>
            </form>
        </div>
    @endcan
@endsection
