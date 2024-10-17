@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mb-0">
                            <i class="fa-solid fa-chalkboard-teacher"></i> Daftar Kelas Sekolah
                        </h1>
                    </div>

                    <div class="card-body">
                        <!-- Download Template Button -->
                        <a href="{{ route('school-classes-template-download') }}" class="btn btn-success">
                            <i class="fa-solid fa-download"></i> Download Template
                        </a>

                        <!-- Import Form -->
                        <form action="{{ route('school_classes.import') }}" method="POST" enctype="multipart/form-data"
                            class="mt-4 mb-3">
                            @csrf
                            <div class="form-group">
                                <label for="file">Pilih File Excel</label>
                                <input type="file" class="form-control form-control-file mb-2" id="file"
                                    name="file" accept=".xls,.xlsx" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">
                                <i class="fa-solid fa-upload"></i> Import
                            </button>
                            <a href="{{ route('school_classes.create') }}" class="btn btn-primary mt-2">
                                <i class="fa-solid fa-plus"></i> Tambah Kelas Sekolah
                            </a>
                        </form>

                        <!-- Major Table -->
                        <table class="table table-bordered" id="Table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schoolClasses as $schoolClass)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $schoolClass->name }}</td>
                                        <td>{{ $schoolClass->major->name ?? 'N/A' }}</td>
                                        <td>
                                            <!-- View Button -->
                                            <a href="{{ route('school_classes.show', $schoolClass) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('school_classes.edit', $schoolClass) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa-solid fa-pencil-alt"></i>
                                            </a>

                                            <!-- Delete Button dengan SweetAlert -->
                                            <form id="delete-form-{{ $schoolClass->id }}"
                                                action="{{ route('school_classes.destroy', $schoolClass) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('{{ $schoolClass->id }}', '{{ $schoolClass->name }}')">
                                                    <i class="fa-solid fa-trash"></i>
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
    </div>
@endsection


@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


{{-- Alert Error menggunakan SweetAlert --}}
@if ($errors->any())
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `<ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>`,
        });
    </script>
@endif

{{-- Alert Bulk Errors menggunakan SweetAlert --}}
@if (session('bulk_errors'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Ups, Ada Error!',
            html: `<ul>
                            @foreach (session('bulk_errors') as $error)
                                <li>Baris: {{ $error['index'] }}</li>
                                <ul>
                                    @foreach ($error['errors'] as $errorMessage)
                                        <li>{{ $errorMessage }}</li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </ul>`,
        });
    </script>
@endif

{{-- Alert Success menggunakan SweetAlert --}}
@if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
        });
    </script>
@endif
<script>
    function confirmDelete(schoolClassId, schoolClassName) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data " + schoolClassName + " akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + schoolClassId).submit();
            }
        })
    }
</script>
@endpush
