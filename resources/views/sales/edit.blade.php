@extends('layouts.app')

@section('title', 'Edit Penjualan - CV. Agung')
@section('page-title', 'Edit Penjualan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Edit Data Penjualan</h5>
            </div>
            
            <div class="card-body">
                <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Basic Information Section -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Informasi Dasar</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="kode_penjualan" class="form-label">Kode Penjualan</label>
                                        <input type="text" class="form-control bg-light" value="{{ $sale->kode_penjualan }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal Penjualan <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $sale->tanggal }}" required>
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
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-select" required>
                                            <option value="pending" {{ $sale->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="completed" {{ $sale->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                            <option value="cancelled" {{ $sale->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information Section (Readonly) -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Informasi Keuangan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Subtotal</label>
                                        <input type="text" class="form-control bg-light" value="Rp {{ number_format($sale->subtotal_amount, 0, ',', '.') }}" readonly>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Pajak (%)</label>
                                                <input type="text" class="form-control bg-light" value="{{ $sale->tax_percentage }}%" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Jumlah Pajak</label>
                                                <input type="text" class="form-control bg-light" value="Rp {{ number_format($sale->tax_amount, 0, ',', '.') }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Diskon</label>
                                        <input type="text" class="form-control bg-light" value="Rp {{ number_format($sale->discount_amount, 0, ',', '.') }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Total Harga</label>
                                        <input type="text" class="form-control bg-light fw-bold" value="Rp {{ number_format($sale->total_harga, 0, ',', '.') }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sale Details Section (Readonly) -->
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Detail Produk</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="40%">Produk</th>
                                                    <th width="15%">Jumlah</th>
                                                    <th width="20%">Harga Unit</th>
                                                    <th width="20%">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sale->saleDetails as $detail)
                                                <tr>
                                                    <td>{{ $detail->product->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                                                    <td>{{ $detail->jumlah }}</td>
                                                    <td>Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Section -->
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Catatan</h6>
                                </div>
                                <div class="card-body">
                                    <textarea name="notes" class="form-control" rows="3">{{ $sale->notes }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="col-12 text-end">
                            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection