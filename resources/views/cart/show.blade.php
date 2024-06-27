@extends('layouts.app2')

@section('content')
    <div class="container">
        <h1 class="shadow-sm p-3 mb-4 mt-2 bg-body rounded"><b>Mozaiq Colletion</b> | Keranjang Belanja</h1>

        @if ($cartItems->isEmpty())
            <p>Keranjang belanja Anda kosong.</p>
        @else
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <table class="table table-borderless align-middle">
                <thead>
                    <tr>
                        <th style="background-color: #84563c; color:white;">Produk</th>
                        <th style="background-color: #84563c; color:white;">Kuantitas</th>
                        <th style="background-color: #84563c; color:white;">Sub Total</th>
                        <th class="text-center" style="background-color: #84563c; color:white;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ Storage::url($item->variant->product->image) }}"
                                        alt="{{ $item->variant->product->name }}"
                                        style="height: auto; width: 100px; margin-right: 10px;">
                                    <div>
                                        <h6 class="mb-2">{{ $item->variant->product->name }}</h6>
                                        <p class="mb-2">Rp{{ number_format($item->variant->product->price, 0, ',', '.') }}
                                        </p>
                                        <p class="mb-0">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <select name="size_id" class="form-control">
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}"
                                                        {{ $item->variant->size_id == $size->id ? 'selected' : '' }}>
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="number" name="amount" class="form-control" style="width: 64px;"
                                    value="{{ $item->amount }}" min="1">
                            </td>
                            <td class="text-start">
                                Rp{{ number_format($item->variant->product->price * $item->amount, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <div class="text-center">
                <h5>Total:
                    Rp{{ number_format($cartItems->sum(fn($item) => $item->variant->product->price * $item->amount), 0, ',', '.') }}
                </h5>
            </div>
            <div class="text-center m-4 d-flex gap-3 justify-content-center">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Lanjutkan Belanja</a>
                <a href="{{ route('order.checkout') }}" class="btn btn-primary">Checkout</a>
            </div>
        @endif

    </div>

@endsection
