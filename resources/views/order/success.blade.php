@extends('layouts.app2')

@section('content')
    <div class="container mt-5">
        <h1>Pembayaran Anda Akan di Verikasi Admin</h1>
        <p>Terima kasih, pesanan Anda telah berhasil dilakukan.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Kembali ke Toko</a>
    </div>
@endsection
