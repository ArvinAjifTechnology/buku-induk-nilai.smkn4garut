@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Staff</h1>
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
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-4"><i class="fas fa-plus"></i> Tambah Staff</a>
        <table class="table" id="Table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->role == 'admin')
                                <span class="badge bg-primary">Admin</span>
                            @elseif ($user->role == 'student_affairs_staff')
                                <span class="badge bg-success">Staff TU Kesiswaan</span>
                            @else
                                <span class="badge bg-secondary">{{ $user->role }}</span> <!-- Untuk role yang tidak dikenal, tampilkan role aslinya -->
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form class="reset-password-form" action="{{ route('users.reset-password', $user) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="button" class="btn btn-danger btn-sm reset-password-button" title="Reset Password">
                                    <i class="fas fa-redo-alt"></i> Reset Password
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


@push('js')
<script>
    // Pilih semua tombol dengan class `reset-password-button`
    document.querySelectorAll('.reset-password-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah form submit secara default

            // SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Password staff akan direset ke kata sandi baru yang telah ditentukan. Proses ini tidak dapat dibatalkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Reset Password',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Akses form terdekat dari tombol yang diklik
                    this.closest('.reset-password-form').submit();
                }
            });
        });
    });
</script>
@endpush
