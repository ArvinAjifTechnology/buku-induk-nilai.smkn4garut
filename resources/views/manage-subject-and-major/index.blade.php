@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach($entryYears as $entryYear)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-calendar-alt"></i> {{ $entryYear->year }}</h5>
                        <a href="{{ route('manage-subject-and-major.majors', $entryYear->uniqid) }}" class="btn btn-primary">
                            <i class="fas fa-book-open"></i> Lihat Jurusan
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
