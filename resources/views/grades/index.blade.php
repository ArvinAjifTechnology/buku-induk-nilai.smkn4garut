@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Daftar Nilai</div>

                <div class="card-body">
                    <a href="{{ route('grades.create') }}" class="btn btn-primary mb-3">Tambah Nilai</a>
                    <div class="row">
                        @foreach ($schoolClasses as $schoolClass)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Kelas: {{ $schoolClass->name }}</h5>
                                    <a href="{{ route('grades.show', $schoolClass) }}" class="btn btn-info btn-sm">Lihat</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
