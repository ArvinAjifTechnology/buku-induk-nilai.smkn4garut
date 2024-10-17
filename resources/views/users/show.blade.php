@extends('layouts.app')

@section('content')
    <div class="container">
        <h1> Detail Staff {{ $user->name }}</h1>

        <p>Email: {{ $user->email }}</p>

        {{-- Menampilkan Role dengan Badge --}}
        <p>Peran:
            @if ($user->role == 'admin')
                <span class="badge bg-primary">Admin</span>
            @elseif ($user->role == 'student_affairs_staff')
                <span class="badge bg-success">Staff TU Kesiswaan</span>
            @else
                <span class="badge bg-secondary">{{ $user->role }}</span>
            @endif
        </p>

        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali Ke Staff</a>
    </div>
@endsection
