@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1 class="mb-4">Daftar Nilai Siswa
                {{ $entryYear->year }}{{ isset($schoolClass) ? ' / ' . $schoolClass->name : '' }}{{ isset($major) ? ' / ' . $major->name : '' }}
            </h1>


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

            <!-- Button Group for Input and Download Student Grades -->
            <div class="row mb-4">
                <div class="col-md-12 d-flex justify-content-start">
                    @if (isset($schoolClass) && isset($entryYear))
                        <!-- Tombol Import -->
                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="fas fa-upload"></i> <i class="fas fa-file-excel"></i> Import Nilai
                        </button>

                        <!-- Modal Import -->
                        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="importModalLabel"> <i class="fas fa-file-excel"></i>
                                            Import Nilai Siswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="file-import-tab" data-bs-toggle="tab"
                                                    data-bs-target="#file-import" type="button" role="tab"
                                                    aria-controls="file-import" aria-selected="true"><i
                                                        class="fas fa-file-excel"></i> Import dari
                                                    File Excel</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="eraport-import-tab" data-bs-toggle="tab"
                                                    data-bs-target="#eraport-import" type="button" role="tab"
                                                    aria-controls="eraport-import" aria-selected="false"><i
                                                        class="fas fa-file-excel"></i> Import dari
                                                    E-Raport</button>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content mt-3">
                                            <!-- File Import Tab -->
                                            <div class="tab-pane fade show active" id="file-import" role="tabpanel"
                                                aria-labelledby="file-import-tab">
                                                <form action="{{ route('students-grades-import') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="file" class="form-label">Pilih File Excel untuk
                                                            Diimpor:</label>
                                                        <small>Sebelum Import Silahkan Unduh Nilai Dan isi Nilai</small>
                                                        <input type="file" name="file" id="file"
                                                            class="form-control form-control-file" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-3">
                                                        <i class="fas fa-upload"></i> Import
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- E-Raport Import Tab -->
                                            <div class="tab-pane fade" id="eraport-import" role="tabpanel"
                                                aria-labelledby="eraport-import-tab">
                                                <form action="{{ route('students-grades-e-raport-preview-import') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="files" class="form-label">Upload File Excel (Banyak
                                                            File)</label>
                                                        <input type="file" name="files[]" class="form-control" required
                                                            multiple accept=".xlsx, .xls">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-3">
                                                        <i class="fas fa-upload"></i> Preview
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <a href="{{ route('manage-grades.form', [$schoolClass->uniqid ?? '', $entryYear->uniqid, $students->first()->major->uniqid]) }}"
                            class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Input Nilai Siswa Perkelas
                        </a> --}}
                    @else
                        {{-- <a href="{{ route('manage-grades.form-by-major', ['majorUniqid' => $major->uniqid, 'entryYearUniqid' => $entryYear->uniqid]) }}"
                            class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Input Nilai Siswa Perjurusan
                        </a> --}}
                    @endif
                </div>

                @if (isset($schoolClass) && isset($entryYear))
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('export.students.grades', ['schoolClassId' => $schoolClass->id, 'entryYearId' => $entryYear->id]) }}"
                            class="btn btn-success me-2 mt-2">
                            <i class="fas fa-download"></i> Unduh Nilai Siswa Perkelas
                        </a>
                    </div>
                @else
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('export.major-students.grades', ['majorId' => $major->id, 'entryYearId' => $entryYear->id]) }}"
                            class="btn btn-success me-2">
                            <i class="fas fa-download"></i> Unduh Nilai Siswa Perjurusan
                        </a>
                    </div>
                    <!-- Import Form -->
                    <div class="card shadow-sm mb-4 mt-3">
                        <div class="card-header text-white">
                            <h4 class="mb-0"><i class="fas fa-upload"></i> Import Nilai Siswa</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('students-grades-import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="file" class="form-label">Pilih File Excel untuk Diimpor:</label>
                                    <input type="file" name="file" id="file"
                                        class="form-control form-control-file" required>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fas fa-upload"></i> Import
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Subjects Table -->
            <div class="table-responsive mt-5">
                <table class="table table-bordered table-striped" id="Table">
                    <thead class="table-success">
                        <tr>
                            <th rowspan="2" class="text-center align-middle">No</th>
                            <th rowspan="2" class="text-center align-middle">NIS</th>
                            <th rowspan="2" class="text-center align-middle">NISN</th>
                            <th rowspan="2" class="text-center align-middle">Kelas</th>
                            <th rowspan="2" class="text-center align-middle">Nama</th>
                            @foreach ($allSubjects as $subject)
                                <th colspan="{{ $semesters->count() }}" class="text-center align-middle">
                                    {{ $subject->name }}
                                </th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach ($allSubjects as $subject)
                                @foreach ($semesters as $semester)
                                    <th class="text-center">{{ $semester->id }}</th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $student->nis }}</td>
                                <td>
                                    <a href="{{ route('students.show', $student->uniqid) }}"
                                        class="text-decoration-none">
                                        {{ $student->nisn }}
                                    </a>
                                </td>
                                <td>{{ $student->entryYear->year . '/' . $student->schoolClass->name }}</td>
                                <td>{{ $student->full_name }}</td>
                                @foreach ($allSubjects as $subject)
                                    @foreach ($semesters as $semester)
                                        @php
                                            $grade = $student->grades
                                                ->where('subject_id', $subject->id)
                                                ->where('semester_id', $semester->id)
                                                ->first();
                                        @endphp
                                        <td class="text-center">{{ $grade ? $grade->score : '-' }}</td>
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


{{-- <table class="table table-bordered">
    <thead class="thead-dark">
        <tr>
            <th rowspan="2" class="text-center align-middle">No</th>
            <th rowspan="2" class="text-center align-middle">NIS</th>
            <th rowspan="2" class="text-center align-middle">NISN</th>
            <th rowspan="2" class="text-center align-middle">Kelas</th>
            <th rowspan="2" class="text-center align-middle">Jurusan</th>
            <th rowspan="2" class="text-center align-middle">Nama</th>
            <th colspan="6" class="text-center align-middle">Pendidikan Agama Islam dan Budi Pekerti</th>
            <th colspan="6" class="text-center align-middle">Pendidikan Pancasila</th>
        </tr>
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>2106100</td>
            <td>988789998</td>
            <td>APHP-1</td>
            <td>Agribisnis Pengolahan Hasil Pertanian</td>
            <td>Arvin Muhammad Ajif</td>
            <td>88</td>
            <td>90</td>
            <td>99</td>
            <td>98</td>
            <td>78</td>
            <td>87</td>
            <td>89</td>
            <td>99</td>
            <td>88</td>
            <td>98</td>
            <td>99</td>
            <td>100</td>
        </tr>
    </tbody>
</table> --}}
