@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, Admin!</p>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Pesanan</h5>
                        <p class="card-text">Lihat dan konfirmasi pesanan pengguna.</p>
                        <a href="{{ route('admin.orders') }}" class="btn btn-primary">Kelola Pesanan</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Produk</h5>
                        <p class="card-text">Tambah, edit, atau hapus produk.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Kelola Produk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection