@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Input Nilai Siswa - Kelas {{ $schoolClass->name?? '' }} Tahun Masuk {{ $entryYear->year }}</h1>
        <h3>Jurusan: {{ $major->name }}</h3>
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-triangle"></i> Error!</strong> Terdapat beberapa masalah dengan input
                Anda:
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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

            <script>
                window.onload = function() {
                    setTimeout(function() {
                        window.history.go(-2);
                    }, 500); // Menunggu 500ms untuk memastikan data tersimpan
                };
            </script>

        @endif
        <form action="{{ route('manage-grades.store') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center align-middle">Nama Siswa</th>
                            <th rowspan="2" class="text-center align-middle">Kelas</th>
                            <!-- Loop pertama: Mata Pelajaran -->
                            @foreach ($allSubjects as $subject)
                                <th colspan="{{ $semesters->count() }}" class="text-center align-middle">{{ $subject->name }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <!-- Loop kedua: Semester -->
                            @foreach ($allSubjects as $subject)
                                @foreach ($semesters as $semester)
                                    <th class="text-center">{{ $semester->name }}</th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->entryYear->year .'/'.$student->schoolClass->name }}</td>
                                @foreach ($allSubjects as $subject)
                                    @foreach ($semesters as $semester)
                                        @php
                                            // Ambil nilai jika sudah ada
                                            $existingGrade = $student->grades
                                                ->where('subject_id', $subject->id)
                                                ->where('semester_id', $semester->id)
                                                ->first();
                                        @endphp
                                        <td>
                                            <input type="hidden"
                                                name="grades[{{ $student->id }}][{{ $subject->id }}][{{ $semester->id }}][id]"
                                                value="{{ $existingGrade->id ?? '' }}">
                                            <input type="number"
                                                name="grades[{{ $student->id }}][{{ $subject->id }}][{{ $semester->id }}][score]"
                                                value="{{ $existingGrade->score ?? '' }}" class="form-control"
                                                placeholder="Nilai" min="0" max="100">
                                        </td>
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
@endsection
