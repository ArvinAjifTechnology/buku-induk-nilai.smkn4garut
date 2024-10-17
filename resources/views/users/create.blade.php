@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($user) ? 'Edit Staff' : 'Tambah Staff' }}</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST">
            @csrf
            @if (isset($user))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}"
                    required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}"
                    required>
            </div>
            <div class="form-group">
                <label for="role">Peran (Role)</label>
                <select name="role" class="form-control" required>
                    <option value="">Pilih Peran</option>
                    <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="student_affairs_staff" {{ old('role', $user->role ?? '') == 'student_affairs_staff' ? 'selected' : '' }}>Staff TU Kesiswaan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group mb-4">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Ubah Staff '.$user->name : 'Tambah Staff' }}</button>
        </form>
    </div>
@endsection
