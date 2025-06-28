@extends('layouts.app')

@section('title', 'Tambah Pemasok')
@section('page-title', 'Tambah Pemasok')

@section('content')
<form method="POST" action="{{ route('suppliers.store') }}">
    @csrf
    <div class="mb-3">
        <label for="nama_supplier" class="form-label">Nama Supplier</label>
        <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea name="alamat" id="alamat" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label for="no_telepon" class="form-label">No Telepon</label>
        <input type="text" name="no_telepon" id="no_telepon" class="form-control">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
</form>
@endsection
