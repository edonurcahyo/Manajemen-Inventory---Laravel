@extends('layouts.app')

@section('title', 'Tambah Produk - CV. Agung')
@section('page-title', 'Tambah Produk Baru')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Form Tambah Produk</h5>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('products.store') }}">
            @csrf

            <div class="row">
                {{-- Kode Produk --}}
                <div class="col-md-6 mb-3">
                    <label for="kode_produk" class="form-label">Kode Produk</label>
                    <input type="text" 
                           name="kode_produk" 
                           id="kode_produk" 
                           class="form-control @error('kode_produk') is-invalid @enderror" 
                           value="{{ old('kode_produk') }}" 
                           readonly>
                    <small class="text-muted">Kode produk akan digenerate otomatis</small>
                    @error('kode_produk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Produk --}}
                <div class="col-md-6 mb-3">
                    <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('nama_produk') is-invalid @enderror" 
                           id="nama_produk" 
                           name="nama_produk" 
                           value="{{ old('nama_produk') }}" 
                           required>
                    @error('nama_produk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                {{-- Kategori --}}
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select class="form-select @error('category_id') is-invalid @enderror" 
                            id="category_id" 
                            name="category_id" 
                            required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Satuan --}}
                <div class="col-md-6 mb-3">
                    <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('satuan') is-invalid @enderror" 
                           id="satuan" 
                           name="satuan" 
                           value="{{ old('satuan') }}" 
                           required>
                    @error('satuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                {{-- Harga Beli --}}
                <div class="col-md-6 mb-3">
                    <label for="harga_beli" class="form-label">Harga Beli <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" 
                               class="form-control @error('harga_beli') is-invalid @enderror" 
                               id="harga_beli" 
                               name="harga_beli" 
                               value="{{ old('harga_beli') }}" 
                               required>
                        @error('harga_beli')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Harga Jual --}}
                <div class="col-md-6 mb-3">
                    <label for="harga_jual" class="form-label">Harga Jual <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" 
                               class="form-control @error('harga_jual') is-invalid @enderror" 
                               id="harga_jual" 
                               name="harga_jual" 
                               value="{{ old('harga_jual') }}" 
                               required>
                        @error('harga_jual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Stok --}}
            <div class="mb-3">
                <label for="stok" class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                <input type="number" 
                       class="form-control @error('stok') is-invalid @enderror" 
                       id="stok" 
                       name="stok" 
                       value="{{ old('stok') }}" 
                       required>
                @error('stok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- {{-- Deskripsi --}}
            <div class="mb-4">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" 
                          name="deskripsi" 
                          rows="3">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> -->

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection