@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="h3 mb-4">Edit Ukuran</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sizes.update', $size->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nama Ukuran</label>
                <input type="text" name="name" id="name" class="form-control" style="width: 256px;" value="{{ $size->name }}">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
@endsection