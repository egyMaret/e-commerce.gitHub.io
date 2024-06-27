@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Daftar Ukuran</h1>
            <a href="{{ route('sizes.create') }}" class="btn btn-primary">Tambah Ukuran</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Nama Ukuran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sizes as $size)
                    <tr>
                        <td>{{ $size->name }}</td>
                        <td>
                            <a href="{{ route('sizes.edit', $size->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('sizes.destroy', $size->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus ukuran ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Kembali</a>
    </div>
@endsection
