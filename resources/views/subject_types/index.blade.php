@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Jenis Mata Pelajaran</h1>

                <!-- Tombol Tambah -->
                <a href="{{ route('subject_types.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Tambah Jenis Mata Pelajaran
                </a>

                <!-- Tabel Subject Types -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Jenis</th>
                                <th>Tanggal Dibuat</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjectTypes as $index => $subjectType)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $subjectType->name }}</td>
                                    <td>{{ $subjectType->created_at->format('d M Y') }}</td>
                                    <td>
                                        <!-- Tombol Lihat -->
                                        <a href="{{ route('subject_types.show', $subjectType) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('subject_types.edit', $subjectType) }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <!-- Tombol Hapus dengan SweetAlert -->
                                        <form id="delete-form-{{ $subjectType->id }}" action="{{ route('subject_types.destroy', $subjectType) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ $subjectType->id }}', '{{ $subjectType->name }}')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


@endsection

@push('js')
    <!-- SweetAlert Konfirmasi Penghapusan -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(subjectTypeId, subjectTypeName) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Jenis Mata Pelajaran " + subjectTypeName + " akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + subjectTypeId).submit();
                }
            })
        }
    </script>

    <!-- SweetAlert untuk Notifikasi Sukses/Error -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        </script>
    @endif
@endpush
