@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach($entryYears as $entryYear)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <!-- Card Title with Icon -->
                        <h5 class="card-title">
                            <i class="fas fa-calendar-alt"></i> {{ $entryYear->year }}
                        </h5>
                        <!-- Button with Icon -->
                        <a href="{{ route('manage-grades.school-classes', $entryYear->uniqid) }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i> Lihat Daftar Kelas
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
