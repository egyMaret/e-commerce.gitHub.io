@extends('layouts.app2')

@section('content')
    <div class="container my-4">
        <div class="row">
            <a href="{{ route('products.index') }}" style="text-decoration: none; color:black; font-size: 24px;"><ion-icon
                    name="arrow-back-outline"></ion-icon>  Kembali</a>
            <div class="col-md-6">
                <img src="{{ Storage::url($product->image) }}" class="img-fluid" alt="{{ $product->name }}"
                    style="width: 512px;">
                    <h3><br>Description</h3>
                    <p>{{ $product->description }}</p>
            </div>
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <h2>Harga: Rp{{ number_format($product->price, 0, ',', '.') }},-</h2>
                <p>Stok: {{ $product->stock }}</p>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif

                <!-- Form for Product Size Selection -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="size">Pilih Ukuran</label>
                        <select name="size_id" id="size" class="form-control" style="width: 256px">
                            <option value="">Pilih ukuran</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Jumlah</label>
                        <input type="number" name="amount" id="amount" style="width: 256px" class="form-control"
                            value="{{ old('amount', 1) }}" min="1">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Tambah ke Keranjang</button>
                </form>

                <!-- Links for 'Kembali' and 'Tambah ukuran' -->
                @can('admin')
                    <a href="{{ route('sizes.index') }}" class="btn btn-primary mt-3">Tambah ukuran</a>
                @endcan
            </div>
        </div>
        <div class="row">
            <h1 class="h3"><br><br>Produk Lainnya
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
        </div>
    </div>
@endsection
