@extends('layouts.app')

@section('title', 'Edit Penjualan - CV. Agung')
@section('page-title', 'Edit Penjualan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h5>Edit Data Penjualan</h5></div>
            <div class="card-body">
                <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="kode_penjualan" class="form-label">Kode Penjualan</label>
                        <input type="text" name="kode_penjualan" id="kode_penjualan" class="form-control" value="{{ $sale->kode_penjualan }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Penjualan</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $sale->tanggal }}">
                    </div>

                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Pelanggan</label>
                        <select name="customer_id" id="customer_id" class="form-select">
                            <option value="">Pelanggan Langsung</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="total_harga" class="form-label">Total Harga</label>
                        <input type="text" class="form-control" value="Rp {{ number_format($sale->total_harga, 0, ',', '.') }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" {{ $sale->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="completed" {{ $sale->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $sale->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
