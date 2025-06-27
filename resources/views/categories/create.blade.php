@extends('layouts.app')

@section('title', 'New Category - CV. Agung')
@section('page-title', 'Create Category')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori *</label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" 
                               id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection