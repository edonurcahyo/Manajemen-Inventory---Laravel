@extends('layouts.app')

@section('title', 'Detail Produk - CV. Agung')
@section('page-title', 'Detail Produk')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Informasi Produk</h5>
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Nama Produk:</div>
            <div class="col-md-8">{{ $product->nama_produk }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Kategori:</div>
            <div class="col-md-8">{{ $product->category->nama_kategori ?? '-' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Harga Jual:</div>
            <div class="col-md-8">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Stok Saat Ini:</div>
            <div class="col-md-8">
                <span class="badge {{ $product->stok <= $product->minimum_stock ? 'bg-danger' : 'bg-success' }}">
                    {{ $product->stok }}
                </span>
            </div>
        </div>

        <!-- <div class="row mb-3">
            <div class="col-md-4 fw-bold">Stok Minimum:</div>
            <div class="col-md-8">{{ $product->minimum_stock }}</div>
        </div> -->

        <!-- <div class="row mb-3">
            <div class="col-md-4 fw-bold">Deskripsi:</div>
            <div class="col-md-8">{{ $product->deskripsi ?? '-' }}</div>
        </div> -->
    </div>
</div>
@endsection
