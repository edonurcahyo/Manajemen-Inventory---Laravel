@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Informasi Akun</h5>
        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="fas fa-edit me-1"></i> Edit Profil
        </button>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Nama</div>
            <div class="col-sm-9">{{ $user->nama }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Email</div>
            <div class="col-sm-9">{{ $user->email }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Role</div>
            <div class="col-sm-9 text-capitalize">{{ $user->role }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">No. Telepon</div>
            <div class="col-sm-9">{{ $user->no_telepon ?? '-' }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3 fw-bold">Alamat</div>
            <div class="col-sm-9">{{ $user->alamat ?? '-' }}</div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ $user->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" name="no_telepon" id="no_telepon" value="{{ $user->no_telepon }}">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" rows="2">{{ $user->alamat }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi Baru (opsional)</label>
                        <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengganti">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
