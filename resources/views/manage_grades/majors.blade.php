@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $entryYear->name }}</h1>
        <div class="row">
            @foreach ($entryYear->majors as $major)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <a href="{{ route('export.major-students.grades', ['majorId' => $major->id, 'entryYearId' => $entryYear->id]) }}" 
                                class="btn btn-success btn-lg">
                                 <i class="fas fa-download"></i> Unduh Nilai Siswa
                             </a>
                            <h5 class="card-title">{{ $major->name }}</h5>
                            <a href="{{ route('manage-grades.school-classes',$entryYear->uniqid) }}"
                                class="btn btn-primary">Lihat Daftar Kelas</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
