@extends('layouts.app')

@section('title', 'Daftar Pemasok')
@section('page-title', 'Daftar Pemasok')

@section('content')
<a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">Tambah Pemasok</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->nama_supplier }}</td>
                <td>{{ $supplier->alamat }}</td>
                <td>{{ $supplier->no_telepon }}</td>
                <td>{{ $supplier->email }}</td>
                <td>
                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pemasok ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada pemasok.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
