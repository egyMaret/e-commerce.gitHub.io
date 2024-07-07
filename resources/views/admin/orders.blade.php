@extends('layouts.app2')

@section('content')
    <div class="container">
        <h1>Daftar Pesanan</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Alamat</th>
                    <th>Nomor Handphone</th>
                    <th>Tanggal Pesan</th>
                    <th>Bukti Pembayaran</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->no_phone }}</td>
                        <td>{{ $order->order_date }}</td>
                        <td>
                            @if ($order->payment_receipt)
                                <a href="{{ Storage::url($order->payment_receipt) }}" target="_blank">Lihat Bukti</a>
                            @else
                                Tidak ada bukti
                            @endif
                        </td>
                        <td>{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            @if ($order->is_paid)
                                <span class="badge badge-success text-success">Dikonfirmasi</span>
                            @else
                                <span class="badge badge-warning text-dark">Belum Dikonfirmasi</span>
                            @endif
                        </td>
                        <td>
                            @if (!$order->is_paid)
                                <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                </form>
                                {{-- <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin membatalkan order ini?')">Cancel</button>
                                </form> --}}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
