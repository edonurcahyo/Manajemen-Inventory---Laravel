@extends('layouts.app')

@section('title', 'Detail Penjualan')
@section('page-title', 'Detail Penjualan')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">Detail Penjualan #{{ $sale->kode_penjualan }}</div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <p><strong>Kode Penjualan:</strong> {{ $sale->kode_penjualan }}</p>
                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($sale->tanggal)->format('d M Y') }}</p>
                        <p><strong>Pelanggan:</strong> {{ $sale->customer->name ?? 'Pelanggan Langsung' }}</p>
                        <p><strong>Status:</strong> 
                            @switch($sale->status)
                                @case('pending') <span class="badge bg-warning">Menunggu</span> @break
                                @case('completed') <span class="badge bg-success">Selesai</span> @break
                                @case('cancelled') <span class="badge bg-danger">Dibatalkan</span> @break
                                @default <span class="badge bg-secondary">{{ $sale->status }}</span>
                            @endswitch
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Subtotal:</strong> Rp {{ number_format($sale->subtotal_amount, 0, ',', '.') }}</p>
                        <p><strong>Pajak (%):</strong> {{ $sale->tax_percentage }}%</p>
                        <p><strong>Jumlah Pajak:</strong> Rp {{ number_format($sale->tax_amount, 0, ',', '.') }}</p>
                        <p><strong>Diskon:</strong> Rp {{ number_format($sale->discount_amount, 0, ',', '.') }}</p>
                        <p><strong>Total Harga:</strong> Rp {{ number_format($sale->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                @if($sale->notes)
                <div class="mb-3">
                    <strong>Catatan:</strong>
                    <div class="border rounded p-2 bg-light">{{ $sale->notes }}</div>
                </div>
                @endif
                <hr>
                <h5>Detail Item</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Jual</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->saleDetails as $detail)
                        <tr>
                            <td>{{ $detail->product->nama_produk ?? '-' }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
