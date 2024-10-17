@extends('layouts.app')

@push('css')
    <style>
        a {
            color: gray;
            text-decoration: none;
        }

        a:hover {
            color: gray;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-action {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-action form {
            display: inline;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('bulk_errors'))
                    <div class="alert alert-danger">
                        {{-- @dd(session('bulk_errors')) --}}
                        <h4>Ups Ada Error!</h4>
                        <ul>
                            @foreach (session('bulk_errors') as $error)
                                <li>Baris: {{ $error['index'] }}</li>
                                <ul>
                                    @foreach ($error['errors'] as $errorMessage)
                                        <li>{{ $errorMessage }}</li>
                                    @endforeach
                                </ul>
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

                {{-- Card --}}
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Data Siswa</h3>
                    </div>
                    <div class="container">
                        <!-- Baris untuk Tombol -->
                        <div class="row mb-3">
                            <div class="col-md-12 d-flex gap-2 mb-4">
                                {{-- Tombol Tambah --}}
                                <a href="{{ route('students.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah
                                </a>

                                {{-- Download Template --}}
                                <a href="{{ route('student-template-download') }}" class="btn btn-success">
                                    <i class="fas fa-download"></i> Template
                                </a>
                                <!-- Tombol untuk Menampilkan Form Export -->
                                {{-- <button type="button" class="btn btn-primary" id="toggleExportForm">
                                    <i class="fas fa-download"></i> Export Foto
                                </button> --}}
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#exportModal">
                                    <i class="fas fa-download"></i> Export Foto
                                </button>
                            </div>
                            <!-- Modal Export Foto -->
                            <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exportModalLabel">Export Foto Siswa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('export.photo.process') }}" method="POST">
                                                @csrf

                                                <div class="form-group">
                                                    <label for="school_class_id">Kelas</label>
                                                    <select name="school_class_id" id="school_class_id"
                                                        class="form-control select2">
                                                        <option value="">Semua Kelas</option>
                                                        @foreach ($schoolClasses as $class)
                                                            <option value="{{ $class->id }}"
                                                                {{ request('school_class_id') == $class->id ? 'selected' : '' }}>
                                                                {{ $class->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="major_id">Jurusan</label>
                                                    <select name="major_id" id="major_id" class="form-control select2">
                                                        <option value="">Semua Jurusan</option>
                                                        @foreach ($majors as $major)
                                                            <option value="{{ $major->id }}"
                                                                {{ request('major_id') == $major->id ? 'selected' : '' }}>
                                                                {{ $major->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="entry_year_id">Tahun Masuk</label>
                                                    <select name="entry_year_id" id="entry_year_id"
                                                        class="form-control select2">
                                                        <option value="">Semua Tahun</option>
                                                        @foreach ($entryYears as $year)
                                                            <option value="{{ $year->id }}"
                                                                {{ request('entry_year_id') == $year->year ? 'selected' : '' }}>
                                                                {{ $year->year }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Export Foto</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Baris untuk Form Export Foto -->
                            <div class="row" id="exportForm" style="display: none;">
                                <div class="col-md-12">
                                    <form action="{{ route('export.photo.process') }}" method="POST">
                                        @csrf
                                        {{-- <div class="mb-3">
                                            <label for="school_class_id">Kelas</label>
                                            <select name="school_class_id" id="school_class_id" class="form-control select2">
                                                <option value="">Semua Kelas</option>
                                                @foreach ($schoolClasses as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ request('school_class_id') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> --}}

                                        {{-- <div class="mb-3">
                                            <label for="name" class="form-label">Nama</label>
                                            <select name="student" id="student" class="form-control select2 mb-2">
                                                <option value="">Pilih Nama</option>
                                                @foreach ($students as $students)
                                                    <option value="{{ $students->full_name }}">
                                                        {{ $students->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> --}}

                                        {{-- <label for="school_class_id">Kelas</label>
                                        <select name="school_class_id" id="school_class_id" class="form-control select2">
                                            <option value="">Semua Kelas</option>
                                            @foreach ($schoolClasses as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ request('school_class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                        <div class="form-group">
                                            <label for="major_id">Jurusan</label>
                                            <select name="major_id" id="major_id" class="form-control select2">
                                                <option value="">Semua Jurusan</option>
                                                @foreach ($majors as $major)
                                                    <option value="{{ $major->id }}"
                                                        {{ request('major_id') == $major->id ? 'selected' : '' }}>
                                                        {{ $major->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="entry_year_id">Tahun Masuk</label>
                                            <select name="entry_year_id" id="entry_year_id"
                                                class="form-control select2 mb-3">
                                                <option value="">Semua Tahun</option>
                                                @foreach ($entryYears as $year)
                                                    <option value="{{ $year->id }}"
                                                        {{ request('entry_year_id') == $year->year ? 'selected' : '' }}>
                                                        {{ $year->year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary mb-3">Export Foto</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Baris untuk Form -->
                            <div class="row">
                                <div class="col-md-12 d-flex flex-column gap-3">
                                    {{-- Form Upload Foto --}}
                                    <form action="{{ route('students.upload-photo.submit') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="photos[]" accept="image/*"
                                                multiple required>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-upload"></i> Upload Foto
                                            </button>
                                        </div>
                                    </form>

                                    {{-- Form Import --}}
                                    <form action="{{ route('students.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="file" name="file"
                                                accept=".xls,.xlsx" required>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-file-import"></i> Import Siswa
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Filter Data --}}
                        <form action="{{ route('students.filter') }}" method="GET" class="p-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="entry_year">Tahun Masuk</label>
                                        <select name="entry_year" id="entry_year" class="form-control select2">
                                            <option value="">Semua Tahun</option>
                                            @foreach ($entryYears as $year)
                                                <option value="{{ $year->year }}"
                                                    {{ request('entry_year') == $year->year ? 'selected' : '' }}>
                                                    {{ $year->year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="major_id">Jurusan</label>
                                        <select name="major_id" id="major_id" class="form-control select2">
                                            <option value="">Semua Jurusan</option>
                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}"
                                                    {{ request('major_id') == $major->id ? 'selected' : '' }}>
                                                    {{ $major->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="school_class_id">Kelas</label>
                                        <select name="school_class_id" id="school_class_id" class="form-control select2">
                                            <option value="">Semua Kelas</option>
                                            @foreach ($schoolClasses as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ request('school_class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <div class="form-group">
                                        <label for="student_statuses">Status Siswa</label>
                                        <select name="student_statuses" id="student_statuses"
                                            class="form-control select2">
                                            <option value="">Semua Status</option>
                                            <option value="active"
                                                {{ request('student_statuses') == 'active' ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="graduated"
                                                {{ request('student_statuses') == 'graduated' ? 'selected' : '' }}>Lulus
                                            </option>
                                            <option value="dropped_out"
                                                {{ request('student_statuses') == 'dropped_out' ? 'selected' : '' }}>Keluar
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </form>

                        {{-- Search and Table --}}
                        <div class="card-body">
                            <div class="row justify-content-center mb-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" id="search-input" class="form-control"
                                            placeholder="Search by name, NISN, or NIK">
                                    </div>
                                </div>
                            </div>

                            <table class="table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Masuk</th>
                                        <th>Jurusan</th>
                                        <th>Kelas</th>
                                        <th>NIS</th>
                                        <th>Nama Lengkap</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><a
                                                    href="{{ route('students.filter', ['entry_year' => $student->entryYear->year]) }}">{{ $student->entryYear->year }}</a>
                                            </td>
                                            <td><a
                                                    href="{{ route('students.filter', ['major_id' => $student->major->id, 'entry_year' => $student->entryYear->year]) }}">{{ $student->major->name }}</a>
                                            </td>
                                            <td><a
                                                    href="{{ route('students.filter', ['school_class_id' => $student->schoolClass->id, 'entry_year' => $student->entryYear->year]) }}">{{ $student->entryYear->year . '/' . $student->schoolClass->name }}</a>
                                            </td>
                                            <td>{{ $student->nis }}</td>
                                            <td>{{ $student->full_name }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('students.show', $student->uniqid) }}"
                                                    class="btn btn-info btn-sm" title="Detail">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>
                                                <a href="{{ route('students.edit', $student->uniqid) }}"
                                                    class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>i
                                                <form id="delete-form-{{ $student->uniqid }}"
                                                    action="{{ route('students.destroy', $student->uniqid) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus"
                                                        onclick="confirmDelete('{{ $student->uniqid }}', '{{ $student->full_name }}')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('js')
        <script>
            $(document).ready(function() {
                $('#search-input').on('keyup', function() {
                    var query = $(this).val();
                    if (query.length > 2) {
                        $.ajax({
                            url: '{{ route('students.search') }}',
                            type: 'GET',
                            data: {
                                query: query
                            },
                            success: function(data) {
                                $('#table-body').empty();
                                if (data.length > 0) {
                                    var rowNumber = 1;
                                    $.each(data, function(index, student) {
                                        var row = '<tr>' +
                                            '<td>' + rowNumber + '</td>' +
                                            '<td><a href="/students?entry_year=' + student
                                            .entry_year + '">' + student.entry_year +
                                            '</a></td>' +
                                            '<td><a href="/students?major_id=' + student
                                            .major_id + '&entry_year=' + student
                                            .entry_year + '">' + student.major_name +
                                            '</a></td>' +
                                            '<td><a href="/students?school_class_id=' +
                                            student.school_class_id + '&entry_year=' +
                                            student.entry_year + '">' + student.entry_year +
                                            '/' + student.school_class_name + '</a></td>' +
                                            '<td>' + student.nis + '</td>' +
                                            '<td>' + student.full_name + '</td>' +
                                            '<td class="text-center">' +
                                            '<a href="/students/' + student.uniqid +
                                            '" class="btn btn-info btn-sm" title="Detail"><i class="fas fa-info-circle"></i></a>' +
                                            '<a href="/students/' + student.uniqid +
                                            '/edit" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>' +
                                            // '<form action="/students/' + student.uniqid +
                                            // '" method="POST" onsubmit="return confirm(\'Yakin ingin menghapus data '+student.full_name+ ' ini?\');" style="display: inline-block;">' +
                                            // '@csrf' +
                                            // '@method('DELETE')' +
                                            // '<button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash-alt"></i></button>' +
                                            // '</form>' +
                                            '</td>' +
                                            '</tr>';
                                        $('#table-body').append(row);
                                        rowNumber++;
                                    });
                                } else {
                                    $('#table-body').append(
                                        '<tr><td colspan="7" class="text-center">Data tidak ditemukan</td></tr>'
                                    );
                                }
                            }
                        });
                    }
                });
            });
        </script>
        <!-- JavaScript untuk Mengontrol Visibilitas Form Export -->
        <script>
            document.getElementById('toggleExportForm').addEventListener('click', function() {
                const exportForm = document.getElementById('exportForm');
                exportForm.style.display = exportForm.style.display === 'none' ? 'block' : 'none';
            });
        </script>
        <script>
            function confirmDelete(studentId, studentName) {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data " + studentName + " akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + studentId).submit();
                    }
                })
            }
        </script>
    @endpush
