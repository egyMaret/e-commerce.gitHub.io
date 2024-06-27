@extends('layouts.app2')

@section('content')
    <div class="container">
        <h1 class="shadow-sm p-3 mb-4 mt-2 bg-body rounded"><b>Mozaiq Colletion</b> | Checkout</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <a href="{{ route('cart.show') }}" style="text-decoration: none; color:black; font-size: 24px;"><ion-icon
                name="arrow-back-outline"></ion-icon> Kembali</a>

        <form action="{{ route('order.place') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- First Grid: Order Information -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <b>Informasi Pemesan</b>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="form-group">
                                <label for="no_phone">Nomor Handphone</label>
                                <input type="text" class="form-control" id="no_phone" name="no_phone" required>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header">
                            <b>Ringkasan Pesanan</b>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Ukuran</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td>
                                                {{ $item->variant->product->name }}
                                            </td>
                                            <td>{{ $item->variant->size->name }}</td>
                                            <td>{{ $item->amount }}</td>
                                            <td>Rp{{ number_format($item->variant->product->price, 0, ',', '.') }}</td>
                                            <td>Rp{{ number_format($item->variant->product->price * $item->amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Second Grid: Order Summary -->
                <div class="col-md-6">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('assets/qris.jpg') }}" style="width: 256px" alt="Banner Image">
                    </div>
                    <div class="form-group">
                        <label for="payment_receipt">Upload Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="payment_receipt" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Lakukan Pembayaran</button>
                </div>
            </div>
        </form>
    </div>
@endsection
