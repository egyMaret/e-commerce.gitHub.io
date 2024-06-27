@extends('layouts.app')

@section('content')
        <div class="container">
            <h1 class="h3 mb-4">Tambah Ukuran</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('sizes.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Ukuran</label>
                    <input type="text" name="name" id="name" class="form-control" style="width: 256px;" value="{{ old('name') }}"> <br>
                </div>
                <a href="{{ route('sizes.index') }}" class="btn btn-primary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
@endsection
