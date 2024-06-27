@extends('layouts.app2')

@section('content')
    <div>
        <img src="{{ asset('assets/banner2.jpg') }}" style="width: 100%" alt="Banner Image">
    </div>
    <div class="container">
        @can('admin')
            <br>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
            </div>
        @endcan
        <br>
        <form action="{{ route('products.filter') }}" method="GET" class="input-group mb-4">
            <select name="category" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button type="submit" class="btn btn-outline-primary">Filter</button>
            </div>
        </form>

        <div class="row">
            <h1 class="h3 text-center">Produk Terbaju
            </h1>
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="card mb-4">
                        <img class="card-img-top" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                            style="height: auto; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p>Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Lihat
                                    Produk</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <h1 class="h3 text-center">Produk</h1>
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="card mb-4">
                        <img class="card-img-top" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                            style="height: auto; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p>Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Lihat
                                    Produk</a>
                                @can('admin')
                                    <div>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-secondary mr-2">Update</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Delete</button>
                                        </form>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <style>
        .h3.text-center {
            font-family: 'Arial', sans-serif;
            /* Ganti dengan font pilihan Anda */
            text-align: center;
            position: relative;
        }

        .h3.text-center::after {
            content: '';
            display: block;
            width: 12%;
            /* Sesuaikan lebar garis bawah */
            height: 5px;
            /* Sesuaikan ketebalan garis bawah */
            background-color: #AA6F39;
            /* Warna garis yang mirip dengan gambar */
            margin-top: .5rem;
            margin-left: auto;
            margin-right: auto;
            border-radius: 5px;
        }
    </style>
@endsection
