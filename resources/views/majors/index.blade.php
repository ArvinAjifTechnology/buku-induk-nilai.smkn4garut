@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1><i class="fas fa-graduation-cap"></i> Daftar Jurusan</h1>
                    </div>

                    <div class="card-body">
                        <!-- Download Template Button -->
                        <a href="{{ route('majors-template-download') }}" class="btn btn-success rounded-full mb-4">
                            <i class="fas fa-download"></i> Download Template
                        </a>

                        <!-- Import Form -->
                        <form action="{{ route('majors.import') }}" method="POST" enctype="multipart/form-data"
                            class="mb-3">
                            @csrf
                            <div class="form-group">
                                <label for="file">
                                    <i class="fas fa-file-upload"></i> Pilih File Excel
                                </label>
                                <input type="file" class="form-control form-control-file mb-3" id="file"
                                    name="file" accept=".xls,.xlsx" required>

                                <button type="submit" class="btn btn-primary rounded-full">
                                    <i class="fas fa-upload"></i> Import
                                </button>
                                <!-- Add Major Button -->
                                <a href="{{ route('majors.create') }}" class="btn btn-primary rounded-full">
                                    <i class="fas fa-plus"></i> Tambah Jurusan
                                </a>
                            </div>
                        </form>

                        <!-- Major Table -->
                        <table class="table table-bordered mt-4" id="Table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($majors as $major)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $major->name }}</td>
                                        <td>
                                            <!-- View Button -->
                                            <a href="{{ route('majors.show', $major) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('majors.edit', $major) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form id="delete-form-{{ $major->id }}"
                                                action="{{ route('majors.destroy', $major) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete('{{ $major->id }}', '{{ $major->name }}')">
                                                    <i class="fas fa-trash"></i>
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
    <script>
        function confirmDelete(majorId, majorName) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data " + majorName + " akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + majorId).submit();
                }
            })
        }
    </script>

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

    {{-- Alert Bulk Errors --}}
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
@endpush
