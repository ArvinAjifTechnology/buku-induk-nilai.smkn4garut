@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Pesan Success --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Pesan Error --}}
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-times-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Error dari Validasi Form --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1>
        <i class="fas fa-calendar-alt"></i> {{ $entryYear->year }}
    </h1>

    <div class="row">
        <div class="card mb-3">
            <div class="card-header">
                <h5>
                    <i class="fas fa-plus-circle"></i> Tambahkan Jurusan
                </h5>
            </div>
            <div class="card-body">
                <a href="{{ route('manage-subject-and-major.assign-majors') }}" class="btn btn-info">
                    <i class="fas fa-plus"></i> Tambahkan Daftar Jurusan
                </a>
            </div>
        </div>

        {{-- Cek jika tidak ada jurusan --}}
        @if($entryYear->majors->isEmpty())
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <h5>
                        <i class="fas fa-exclamation-triangle"></i> Maaf, Daftar Jurusan Tidak Ditemukan
                    </h5>
                    <p>
                        <i class="fas fa-info-circle"></i> Silahkan Tambah Daftar Jurusan
                    </p>
                </div>
            </div>
        @else
            <div class="row">
                @foreach($entryYear->majors as $major)
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card mb-4 w-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <i class="fas fa-graduation-cap"></i> {{ $major->name }}
                                </h5>
                                <div class="mt-auto">
                                    <a href="{{ route('manage-subject-and-major.subjects',['entryYear' => $entryYear->uniqid, 'major' => $major->uniqid]) }}" class="btn btn-primary">
                                        <i class="fas fa-book"></i> Kelola Mata Pelajaran
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
