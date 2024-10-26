@extends('layouts.app')

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <style>
        a {
            color: inherit;
            /* Inherit color from parent element */
            text-decoration: none;
            /* Remove underline */
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h1>Filter Siswa</h1>
        <div class="card grid-margin stretch-card">
            <div class="card-body">
                <form action="{{ route('students.exports') }}" id="filterForm" method="get">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="student_id">Siswa</label>
                                <select name="student_id" id="student_id" class="form-control select2">
                                    <option value="">Semua</option>
                                    @foreach ($studentsForm ?? [] as $student)
                                        <option value="{{ $student->id }}"
                                            {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="school_class_id">Kelas</label>
                                <select name="school_class_id" id="school_class_id" class="form-control select2">
                                    <option value="">Semua</option>
                                    @foreach ($schoolClasses as $schoolClass)
                                        <option value="{{ $schoolClass->id }}"
                                            {{ request('school_class_id') == $schoolClass->id ? 'selected' : '' }}>
                                            {{ $schoolClass->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="major_id">Jurusan</label>
                                <select name="major_id" id="major_id" class="form-control select2">
                                    <option value="">Semua</option>
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}"
                                            {{ request('major_id') == $major->id ? 'selected' : '' }}>
                                            {{ $major->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="entry_year_id">Tahun Masuk</label>
                                <select name="entry_year_id" id="entry_year_id" class="form-control select2">
                                    <option value="">Semua</option>
                                    @foreach ($entryYears as $entryYear)
                                        <option value="{{ $entryYear->id }}"
                                            {{ request('entry_year_id') == $entryYear->id ? 'selected' : '' }}>
                                            {{ $entryYear->year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mt-2">
                            <div class="form-group">
                                <label class="form-label" for="student_statuses">Status Siswa</label>
                                <select name="student_statuses" id="student_statuses" class="form-control select2">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('student_statuses') == 'active' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="graduated"
                                        {{ request('student_statuses') == 'graduated' ? 'selected' : '' }}>Lulus</option>
                                    <option value="dropped_out"
                                        {{ request('student_statuses') == 'dropped_out' ? 'selected' : '' }}>Keluar
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-9 align-self-end d-flex gap-2 mb-4 mt-3">
                            <button type="submit" class="btn btn-warning form-control p-2">
                                <i class="fas fa-search"></i> Terapkan Filter
                            </button>

                            <a href="{{ route('students-export-word', request()->query()) }}"
                                class="btn btn-primary form-control p-2 {{ empty(request()->query()) ? 'disabled' : '' }}">
                                <i class="fas fa-file-word"></i> Export Word
                            </a>

                            <a href="{{ route('students-export-excel', request()->query()) }}"
                                class="btn btn-success form-control p-2 {{ empty(request()->query()) ? 'disabled' : '' }}">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </a>

                </form>
                {{-- <button type="button" class="btn btn-danger form-control p-2" data-bs-toggle="modal"
                    data-bs-target="#modalCenter">
                    <i class="fas fa-file-pdf"></i> Buat Buku Induk Nilai
                </button> --}}

                <!-- Modal -->
                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form -->
                                <form action="{{ route('merge-word-pdf') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="documents">Pilih Dokumen Word</label>
                                        <input type="file" name="documents[]" class="form-control" multiple>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">Merge to PDF</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($students->isNotEmpty())
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Tahun Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="{{ route('students.show', $student) }}">
                                    {{ $student->full_name }}
                                </a></td>
                            <td>{{ $student->schoolClass->name }}</td>
                            <td>{{ $student->major->name }}</td>
                            <td>{{ $student->entryYear->year }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $students->links() }}
        @else
            <p class="mt-3">Tidak ada data siswa yang sesuai dengan filter.</p>
        @endif
    </div>
    </div>
    </div>

    @include('students_exports.merge-word-pdf-javascript')
@endsection

@push('js')
    <script>
        document.getElementById('filterForm').addEventListener('change', function() {
            this.submit();
        });
    </script>
@endpush
