@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!-- Judul dan Tombol -->
                <h1 class="mb-4"><i class="fa-solid fa-book-open"></i> Mata Pelajaran</h1>

                <!-- Tombol Download Template -->
                <a href="{{ route('subjects-template-download') }}" class="btn btn-success mb-3">
                    <i class="fas fa-download"></i> Download Template
                </a>

                <!-- Form Import -->
                <form action="{{ route('subjects.import') }}" method="POST" enctype="multipart/form-data" class="mb-3">
                    @csrf
                    <div class="form-group">
                        <label for="file">Pilih File Excel</label>
                        <input type="file" class="form-control form-control-file mb-3" id="file" name="file"
                            accept=".xls,.xlsx" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">
                        <i class="fas fa-upload"></i> Import
                    </button>
                    <a href="{{ route('subjects.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus"></i> Tambah Mata Pelajaran
                    </a>
                </form>

                <!-- Tabel Subjects -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="Table">
                        <thead class="thead-light">
                            <tr>
                                <th><i class="fas fa-list-ol"></i> No</th>
                                <th><i class="fas fa-book"></i> Nama</th>
                                <th><i class="fas fa-tags"></i> Jenis Mata Pelajaran</th>
                                {{-- <th><i class="fas fa-calendar-alt"></i> Tanggal Dibuat</th> --}}
                                <th><i class="fas fa-tools"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $index => $subject)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->subjectType->name ?? 'N/A' }}</td>
                                    {{-- <td>{{ $subject->created_at->format('d M Y') }}</td> --}}
                                    <td>
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- Tombol Hapus dengan SweetAlert -->
                                        <form id="delete-form-{{ $subject->id }}"
                                            action="{{ route('subjects.destroy', $subject) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete('{{ $subject->id }}', '{{ $subject->name }}')">
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
@endsection


@push('js')
    <!-- SweetAlert Konfirmasi Penghapusan -->
    <script>
        function confirmDelete(subjectId, subjectName) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Mata pelajaran " + subjectName + " akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + subjectId).submit();
                }
            })
        }
    </script>

    <!-- Error Handling menggunakan SweetAlert -->
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            });
        </script>
    @endif

    <!-- Success Handling menggunakan SweetAlert -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
            });
        </script>
    @endif
@endpush
