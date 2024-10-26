@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Kelas untuk Tahun Masuk {{ $entryYear->year }}</h1>
        <div class="row">
            <!-- Error Messages -->
            @if (session('errors'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach (session('errors') as $error)
                            <li>
                                <i class="fas fa-exclamation-circle"></i> {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-check-circle"></i> Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @foreach ($entryYear->majors as $major)
                <div class="col-md-4 mb-4">
                    <!-- Major Card -->
                    <div class="card h-100 shadow-sm">
                        <!-- Import Form -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">{{ $major->name }}</h4>
                            <a href="{{ route('export.major-students.grades', ['majorId' => $major->id, 'entryYearId' => $entryYear->id]) }}"
                                class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Unduh Nilai Siswa Perjurusan
                            </a>
                        </div>

                        <div class="card-body">
                            <!-- Tombol Import -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#importModal">
                                Import Nilai dari E-Raport
                            </button>

                            <!-- Modal Import -->
                            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('students-grades-e-raport-previewImport') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="importModalLabel">Import Nilai</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="files" class="form-label">Upload File Excel (Banyak
                                                        File)</label>
                                                    <input type="file" name="files[]" class="form-control" required
                                                        multiple accept=".xlsx, .xls">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Preview</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- <form action="{{ route('students-grades-import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-1">
                                    <label for="file" class="form-label">Pilih File Excel untuk Diimpor:</label>
                                    <input type="file" name="file" id="file"
                                        class="form-control form-control-file" accept=".xls,.xlsx" required>
                                </div>
                                <button type="submit" class="btn btn-primary  btn-sm mt-1 mb-4">
                                    <i class="fas fa-upload"></i> Import
                                </button>
                            </form> --}}
                            {{-- <!-- Input Nilai untuk Major -->
                        <a href="{{ route('manage-grades.form-by-major', ['majorUniqid' => $major->uniqid, 'entryYearUniqid' => $entryYear->uniqid]) }}"
                            class="btn btn-warning btn-sm mt-2">
                             <i class="fas fa-edit"></i> Input Nilai Perjurusan
                         </a> --}}
                            <a href="{{ route('manage-grades.students-by-major', ['entryYear' => $entryYear->uniqid, 'major' => $major->uniqid]) }}"
                                class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-eye"></i> Lihat Siswa Perjurusan
                            </a>
                            @foreach ($major->schoolClasses as $schoolClass)
                                <div class="mb-3 mt-4">
                                    <h5>{{ $schoolClass->name }}</h5>
                                    <p class="text-muted">Tahun Masuk: {{ $entryYear->year }}</p>
                                    <a href="{{ route('manage-grades.students-by-class', ['schoolClass' => $schoolClass->uniqid, 'entryYear' => $entryYear->uniqid, 'major' => $major->uniqid]) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Lihat Siswa
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


@endsection
