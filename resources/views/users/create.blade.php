@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New User</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection