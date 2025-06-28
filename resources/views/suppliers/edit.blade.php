@extends('layouts.app')

@section('title', 'Edit Pemasok')
@section('page-title', 'Edit Pemasok')

@section('content')
<form method="POST" action="{{ route('suppliers.update', $supplier->id) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nama Pemasok</label>
        <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
    </div>
    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="address" class="form-control">{{ $supplier->address }}</textarea>
    </div>
    <div class="mb-3">
        <label>Telepon</label>
        <input type="text" name="phone" class="form-control" value="{{ $supplier->phone }}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
