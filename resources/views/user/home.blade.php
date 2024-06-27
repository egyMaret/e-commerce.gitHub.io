@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dashboard User</h1>
        <p>Selamat datang di halaman utama, {{ Auth::user()->name }}!</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Mulai Berbelanja</a>
    </div>
@endsection