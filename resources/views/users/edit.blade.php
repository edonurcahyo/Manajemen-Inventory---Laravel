@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label>Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection