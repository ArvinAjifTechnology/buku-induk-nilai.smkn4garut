@extends('layouts.app')

@push('css')
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .table {
                width: 100%;
                page-break-inside: avoid;
            }

            .table-bordered {
                border-collapse: collapse;
            }

            .table-bordered td,
            .table-bordered th {
                border: 1px solid #000 !important;
                padding: 8px !important;
                font-size: 12px !important;
            }

            .table thead th {
                background-color: #000 !important;
                color: #fff !important;
            }

            .table th,
            .table td {
                font-size: 10px !important;
            }

            .table tr {
                page-break-inside: avoid !important;
            }

            @page {
                size: A4 portrait;
                margin: 20mm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1><i class="fa-solid fa-user-graduate"></i> Data Siswa {{ $student->full_name }}</h1>
                    </div>
                    <div class="card-body">
                        <!-- Nav Tabs -->
                        <ul class="nav nav-tabs" id="studentTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="identitas-siswa-tab" data-bs-toggle="tab"
                                    href="#identitas-siswa" role="tab" aria-controls="identitas-siswa"
                                    aria-selected="true">Identitas Siswa</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="informasi-keluarga-tab" data-bs-toggle="tab"
                                    href="#informasi-keluarga" role="tab" aria-controls="informasi-keluarga"
                                    aria-selected="false">Informasi Keluarga</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="data-dokumen-tab" data-bs-toggle="tab" href="#data-dokumen"
                                    role="tab" aria-controls="data-dokumen" aria-selected="false">Data Dokumen</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="status-foto-tab" data-bs-toggle="tab" href="#status-foto"
                                    role="tab" aria-controls="status-foto" aria-selected="false">Status dan Foto</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="data-lainnya-tab" data-bs-toggle="tab" href="#data-lainnya"
                                    role="tab" aria-controls="data-lainnya" aria-selected="false">Data Lainnya</a>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="studentTabsContent">
                            <!-- Identitas Siswa Tab -->
                            <div class="tab-pane fade show active" id="identitas-siswa" role="tabpanel"
                                aria-labelledby="identitas-siswa-tab">
                                <!-- Konten tab Identitas Siswa -->
                                <h5><strong>1. Identitas Siswa</strong></h5>
                                <p>Nama Lengkap: {{ $student->full_name }}</p>
                                <p>Jenis Kelamin: {{ $student->gender }}</p>
                                <p>Tahun Masuk/Kelas: {{ $student->entryYear->year . '/' . $student->schoolClass->name }}</p>
                                <p>NISN: {{ $student->nisn }}</p>
                                <p>NIK: {{ $student->nik }}</p>
                                <p>NIS: {{ $student->nis }}</p>
                                <p>Tanggal Lahir: {{ $student->birth_date }}</p>
                                <p>Tempat Lahir: {{ $student->birth_place }}</p>
                                <p>Agama: {{ $student->religion }}</p>
                                <p>Kewarganegaraan: {{ $student->nationality }}</p>
                                <p>Kebutuhan Khusus: {{ $student->special_needs ? 'Ya' : 'Tidak' }}</p>
                                <p>Tinggi Badan: {{ $student->height }} cm</p>
                                <p>Berat Badan: {{ $student->weight }} kg</p>
                                <p>Jumlah Saudara: {{ $student->siblings }}</p>
                                <p>Alamat: {{ $student->address }} RT {{ $student->rt }} RW {{ $student->rw }},
                                    {{ $student->village }}, {{ $student->district }}, {{ $student->postal_code }}</p>
                                <p>Tempat Tinggal: {{ $student->residence }}</p>
                                <p>Telepon: {{ $student->phone }}</p>
                                <p>Email: {{ $student->email }}</p>
                                @if ($student->photo)
                                    <img src="{{ asset('storage/' . $student->photo) }}" alt="Foto Siswa"
                                        class="img-fluid">
                                @else
                                    <p>Tidak ada foto yang tersedia.</p>
                                @endif
                            </div>

                            <!-- Informasi Keluarga Tab -->
                            <div class="tab-pane fade" id="informasi-keluarga" role="tabpanel"
                                aria-labelledby="informasi-keluarga-tab">
                                <!-- Konten tab Informasi Keluarga -->
                                <h5><strong>1. Ayah</strong></h5>
                                <p>Nama Ayah: {{ $student->father_name }}</p>
                                <p>Tahun Lahir Ayah: {{ $student->father_birth_year }}</p>
                                <p>Pendidikan Ayah: {{ $student->father_education }}</p>
                                <p>Pekerjaan Ayah: {{ $student->father_job }}</p>
                                <p>NIK Ayah: {{ $student->father_nik }}</p>
                                <p>Kebutuhan Khusus Ayah: {{ $student->father_special_needs ? 'Ya' : 'Tidak' }}</p>

                                <h5><strong>2. Ibu</strong></h5>
                                <p>Nama Ibu: {{ $student->mother_name }}</p>
                                <p>Tahun Lahir Ibu: {{ $student->mother_birth_year }}</p>
                                <p>Pendidikan Ibu: {{ $student->mother_education }}</p>
                                <p>Pekerjaan Ibu: {{ $student->mother_job }}</p>
                                <p>NIK Ibu: {{ $student->mother_nik }}</p>
                                <p>Kebutuhan Khusus Ibu: {{ $student->mother_special_needs ? 'Ya' : 'Tidak' }}</p>

                                <h5><strong>3. Wali</strong></h5>
                                <p>Nama Wali: {{ $student->guardian_name }}</p>
                                <p>Tahun Lahir Wali: {{ $student->guardian_birth_year }}</p>
                                <p>Pendidikan Wali: {{ $student->guardian_education }}</p>
                                <p>Pekerjaan Wali: {{ $student->guardian_job }}</p>
                            </div>


                            <!-- Data Dokumen Tab -->
                            <div class="tab-pane fade" id="data-dokumen" role="tabpanel" aria-labelledby="data-dokumen-tab">
                                <!-- Konten tab Data Dokumen -->
                                <h5><strong>1. Data Dokumen</strong></h5>
                                <p>Nomor Ujian: {{ $student->exam_number }}</p>
                                <p>Nomor Sertifikat SMP: {{ $student->smp_certificate_number }}</p>
                                <p>Nomor SKHUN SMP: {{ $student->smp_skhun_number }}</p>
                                <p>Asal Sekolah: {{ $student->school_origin }}</p>
                                <p>Nomor Sertifikat SMK: {{ $student->smk_certificate_number }}</p>
                                <p>Nomor SKHUN SMK: {{ $student->smk_skhun_number }}</p>
                            </div>
                            <!-- Status dan Foto Tab -->
                            <div class="tab-pane fade" id="status-foto" role="tabpanel" aria-labelledby="status-foto-tab">
                                <!-- Konten tab Status dan Foto -->

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5><strong>1. Status dan Foto</strong></h5>
                                        <p>
                                            <i class="fas fa-info-circle"></i> Status Siswa:
                                            @if ($student->student_statuses === 'active')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-user-check"></i>
                                                    {{ ucfirst($student->student_statuses) }}
                                                </span>
                                            @elseif($student->student_statuses === 'graduated')
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    {{ ucfirst($student->student_statuses) }}
                                                </span>
                                            @elseif($student->student_statuses === 'dropped out')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-user-times"></i>
                                                    {{ ucfirst($student->student_statuses) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-question-circle"></i> Unknown
                                                </span>
                                            @endif
                                        </p>
                                        <h5><i class="fas fa-image"></i> Foto Siswa</h5>
                                        @if ($student->photo)
                                            <img src="{{ asset('storage/' . $student->photo) }}" class="img-thumbnail mb-3"
                                                alt="Foto Siswa" style="width: 150px; height: 150px; object-fit: cover;">
                                            <p>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check"></i> Tersedia
                                                </span>
                                            </p>
                                        @else
                                            <div class="placeholder-photo"
                                                style="width: 150px; height: 150px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-user fa-3x text-muted"></i>
                                            </div>
                                            <p>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times"></i> Tidak Tersedia
                                                </span>
                                            </p>
                                        @endif
                                    </div>
                                </div>


                            </div>

                            <!-- Relasi dan Referensi Tab -->
                            <div class="tab-pane fade" id="data-lainnya" role="tabpanel"
                                aria-labelledby="data-lainnya-tab">
                                <!-- Konten tab Relasi dan Referensi -->
                                <h5><strong>Data Lainnya</strong></h5>
                                <p>Tahun Masuk: {{ $student->entryYear->year }}</p>
                                <p>Tahun Lulus: {{ $student->graduationYear->year ?? '' }}</p>
                                <p>Tanggal Keluar: {{ $student->exit_date }}</p>
                                <p>Alasan Keluar: {{ $student->exit_reason }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Unggah Template Nilai -->
            <div class="col-md-12 mt-5">

                <!-- Download Template Nilai -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5><i class="fas fa-download"></i> Export Nilai {{ $student->full_name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <!-- Button Export Nilai -->
                            <a href="{{ route('student-grades-template-download', $student->uniqid) }}"
                                class="btn btn-success d-flex align-items-center"><i class="fas fa-file-excel"></i> Export
                                Nilai</a>

                            <!-- Button Export Word -->
                            <form action="{{ route('students-export-word') }}" method="get">
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <a href="{{ route('students-export-word', ['student_id' => $student->id]) }}"
                                    class="btn btn-primary d-flex align-items-center justify-content-center">
                                    <i class="fas fa-file-word"></i> Export Word
                                </a>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h5><i class="fas fa-upload"></i> Unggah Data Nilai</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('students.import-grades', $student->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Unggah Data Nilai</label>
                                <input type="file" name="file" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Import Nilai
                            </button>
                        </form>
                    </div>
                </div>


                <!-- Daftar Mata Pelajaran dan Nilai -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-table"></i> Daftar Mata Pelajaran dan Nilai</h5>
                    </div>
                    <div class="card-body">
                        <!-- Tabs navigation -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="daftar-nilai-tab" data-bs-toggle="tab"
                                    href="#daftar-nilai" role="tab" aria-controls="daftar-nilai"
                                    aria-selected="true">
                                    <i class="fas fa-list"></i> Daftar Nilai
                                </a>
                            </li>
                            {{-- <li class="nav-item" role="presentation">
                                <a class="nav-link" id="form-nilai-tab" data-bs-toggle="tab" href="#form-nilai" role="tab" aria-controls="form-nilai" aria-selected="false">
                                    <i class="fas fa-edit"></i> Form Input Nilai
                                </a>
                            </li> --}}
                        </ul>


                        <!-- Tab content -->
                        <div class="tab-content" id="myTabContent">
                            <!-- Daftar Nilai Tab -->
                            <div class="tab-pane fade show active" id="daftar-nilai" role="tabpanel"
                                aria-labelledby="daftar-nilai-tab">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-success">
                                        <tr>
                                            <th rowspan="2" class="text-center align-middle">No</th>
                                            <th rowspan="2" class="text-center align-middle">Mata Pelajaran</th>
                                            <th colspan="{{ count($semesters) }}" class="text-center">Semester</th>
                                        </tr>
                                        <tr>
                                            @foreach ($semesters as $semester)
                                                <th class="text-center">{{ $loop->iteration }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $subjectTotalScores = [];
                                            $subjectCounts = [];
                                            $semesterCount = count($semesters);
                                            $semesterRanges = [
                                                [1, 2], // Semesters 1 and 2
                                                [3, 4], // Semesters 3 and 4
                                                [5, 6], // Semesters 5 and 6
                                            ];
                                            $status = [
                                                'first_range' => '',
                                                'second_range' => '',
                                                'final' => '',
                                            ];
                                        @endphp
                                        @foreach ($subjectTypes as $subjectType)
                                            @if ($subjectType->subjects->isNotEmpty())
                                                <tr>
                                                    <td colspan="{{ $semesterCount + 2 }}" class="fw-bold bg-light">
                                                        {{ $subjectType->name }}</td>
                                                </tr>
                                                @foreach ($subjectType->subjects as $subject)
                                                    @php
                                                        $subjectScores = [];
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $subject->name }}</td>
                                                        @foreach ($semesters as $semester)
                                                            @php
                                                                $grade = $subject->grades
                                                                    ->where('semester_id', $semester->id)
                                                                    ->where('student_id', $student->id)
                                                                    ->first();
                                                                $score = $grade ? $grade->score : 0;
                                                                if ($score > 0) {
                                                                    // Only include subjects with a score
                                                                    $subjectScores[] = $score;
                                                                }
                                                            @endphp
                                                            <td class="text-center">{{ $score > 0 ? $score : '0' }}</td>
                                                        @endforeach
                                                    </tr>
                                                    @php
                                                        if (!empty($subjectScores)) {
                                                            $subjectTotalScores[] = array_sum($subjectScores);
                                                            $subjectCounts[] = count($subjectScores);
                                                        }
                                                    @endphp
                                                @endforeach
                                                <tr>
                                                    <td colspan="{{ $semesterCount + 2 }}" class="fw-bold bg-light"></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td colspan="2" class="text-center">Jumlah Nilai</td>
                                            @for ($i = 0; $i < $semesterCount; $i++)
                                                @php
                                                    $totalScoresForSemester = 0;
                                                    $subjectCount = 0;
                                                    foreach ($subjectTypes as $subjectType) {
                                                        foreach ($subjectType->subjects as $subject) {
                                                            $grade = $subject->grades
                                                                ->where('semester_id', $semesters[$i]->id)
                                                                ->where('student_id', $student->id)
                                                                ->first();
                                                            if ($grade && $grade->score > 0) {
                                                                $totalScoresForSemester += $grade->score;
                                                                $subjectCount++;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <td class="text-center">
                                                    {{ $subjectCount > 0 ? $totalScoresForSemester : '0' }}
                                                </td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-center">Rata-Rata</td>
                                            @for ($i = 0; $i < $semesterCount; $i++)
                                                @php
                                                    $totalScoresForSemester = 0;
                                                    $subjectCount = 0;
                                                    foreach ($subjectTypes as $subjectType) {
                                                        foreach ($subjectType->subjects as $subject) {
                                                            $grade = $subject->grades
                                                                ->where('semester_id', $semesters[$i]->id)
                                                                ->where('student_id', $student->id)
                                                                ->first();
                                                            if ($grade && $grade->score > 0) {
                                                                $totalScoresForSemester += $grade->score;
                                                                $subjectCount++;
                                                            }
                                                        }
                                                    }
                                                    $averageScoreForSemester = $subjectCount
                                                        ? $totalScoresForSemester / $subjectCount
                                                        : 0;
                                                @endphp
                                                <td class="text-center">
                                                    {{ $subjectCount > 0 ? number_format($averageScoreForSemester, 2) : '0' }}
                                                </td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-center">Kelulusan</td>
                                            @php
                                                function checkPass($scores, $threshold = 75)
                                                {
                                                    return array_reduce(
                                                        $scores,
                                                        function ($carry, $score) use ($threshold) {
                                                            return $carry && $score >= $threshold;
                                                        },
                                                        true,
                                                    );
                                                }

                                                $firstRangeScores = [];
                                                $secondRangeScores = [];
                                                $finalRangeScores = [];

                                                foreach ($semesters as $index => $semester) {
                                                    $scoreForSemester = 0;
                                                    $subjectCount = 0;

                                                    foreach ($subjectTypes as $subjectType) {
                                                        foreach ($subjectType->subjects as $subject) {
                                                            $grade = $subject->grades
                                                                ->where('semester_id', $semester->id)
                                                                ->where('student_id', $student->id)
                                                                ->first();
                                                            if ($grade && $grade->score > 0) {
                                                                $scoreForSemester += $grade->score;
                                                                $subjectCount++;
                                                            }
                                                        }
                                                    }

                                                    if ($subjectCount > 0) {
                                                        $averageForSemester = $scoreForSemester / $subjectCount;
                                                    } else {
                                                        $averageForSemester = 0;
                                                    }

                                                    if ($index < 2) {
                                                        $firstRangeScores[] = $averageForSemester;
                                                    } elseif ($index < 4) {
                                                        $secondRangeScores[] = $averageForSemester;
                                                    } else {
                                                        $finalRangeScores[] = $averageForSemester;
                                                    }
                                                }

                                                $status['first_range'] = checkPass($firstRangeScores)
                                                    ? 'Tercapai'
                                                    : 'Tidak Tercapai';
                                                $status['second_range'] = checkPass($secondRangeScores)
                                                    ? 'Tercapai'
                                                    : 'Tidak Tercapai';
                                                $status['final'] = checkPass($finalRangeScores)
                                                    ? 'Lulus'
                                                    : 'Tidak Lulus';
                                            @endphp
                                            <td colspan="2" class="text-center">{{ $status['first_range'] }}</td>
                                            <td colspan="2" class="text-center">{{ $status['second_range'] }}</td>
                                            <td colspan="2" class="text-center">{{ $status['final'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Form Input Nilai Tab -->
                            <div class="tab-pane fade" id="form-nilai" role="tabpanel" aria-labelledby="form-nilai-tab">
                                <form action="{{ route('students.grades.submit') }}" method="POST" class="mt-3">
                                    @csrf

                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-success">
                                            <tr>
                                                <th rowspan="2" class="text-center align-middle">No</th>
                                                <th rowspan="2" class="text-center align-middle">Mata Pelajaran</th>
                                                <th colspan="{{ count($semesters) }}" class="text-center">Semester</th>
                                            </tr>
                                            <tr>
                                                @foreach ($semesters as $semester)
                                                    <th class="text-center">{{ $loop->iteration }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subjectTypes as $subjectType)
                                                @if ($subjectType->subjects->isNotEmpty())
                                                    <tr>
                                                        <td colspan="{{ count($semesters) + 2 }}"
                                                            class="fw-bold bg-light">{{ $subjectType->name }}</td>
                                                    </tr>
                                                    @foreach ($subjectType->subjects as $subject)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $subject->name }}</td>
                                                            @foreach ($semesters as $semester)
                                                                @php
                                                                    $grade = $subject->grades
                                                                        ->where('semester_id', $semester->id)
                                                                        ->where('student_id', $student->id)
                                                                        ->first();
                                                                    $score = $grade ? $grade->score : '';
                                                                @endphp
                                                                <td class="text-center">
                                                                    <input type="number"
                                                                        name="grades[{{ $subject->id }}][{{ $semester->id }}]"
                                                                        class="form-control text-center"
                                                                        value="{{ $score }}" min="0"
                                                                        max="100">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.getElementById('filterForm').addEventListener('change', function() {
            this.submit();
        });
    </script>
@endpush



{{-- <table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th rowspan="2" class="text-center align-middle">No</th>
            <th rowspan="2" class="text-center align-middle">Mata Pelajaran</th>
            <th colspan="6" class="text-center">Semester</th>
        </tr>
        <tr>
            <th class="text-center">1</th>
            <th class="text-center">2</th>
            <th class="text-center">3</th>
            <th class="text-center">4</th>
            <th class="text-center">5</th>
            <th class="text-center">6</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subjectTypes as $subjectType)
        <tr>
            <td colspan="8" class="fw-bold bg-light">{{ $subjectType->name }}</td>
        </tr>
        @foreach ($subjectType->subjects as $subject)
            @php
                // Find the grade for the current subject and student
                $grade = $subject->grades->firstWhere('student_id', $student->id);
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $subject->name }}</td>
                <td>{{ $grade ? $grade->score : '' }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    @endforeach
        <tr>
            <td colspan="8" class="fw-bold bg-light">B. Muatan Kewilayahan</td>
        </tr>
        <tr>
            <td>7</td>
            <td>Seni Budaya</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="8" class="fw-bold bg-light">C. Muatan Peminatan Kejuruan</td>
        </tr>
        <tr>
            <td colspan="8" class="fw-bold bg-light">C1. Dasar Bidang Keahlian</td>
        </tr>
        <tr>
            <td>9</td>
            <td>Informatika</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="8" class="fw-bold bg-light">C2. Dasar Program Keahlian</td>
        </tr>
        <tr>
            <td>13</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="8" class="fw-bold bg-light">Muatan Lokal</td>
        </tr>
        <tr>
            <td>17</td>
            <td>Muatan Lokal Bahasa Daerah</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="8" class="fw-bold bg-light">C3. Kompetensi Keahlian</td>
        </tr>
        <tr>
            <td>18</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="8" class="fw-bold bg-light"> </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center"><strong>Sakit:</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" class="text-center"><strong>Izin:</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" class="text-center"><strong>Alpha:</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" class="text-center"><strong>Keterangan KeTercapaian:</strong></td>
            <td colspan="2" class="text-center"><strong>Tercapai / Tidak Tercapai:</strong></td>
            <td colspan="2" class="text-center"><strong>Tercapai / Tidak Tercapai:</strong></td>
            <td colspan="2" class="text-center"><strong>Lulus / Tidak Lulus:</strong></td>
        </tr>
        <tr>
        </tr>
    </tbody>
</table> --}}
