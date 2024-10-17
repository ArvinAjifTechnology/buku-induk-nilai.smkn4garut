<!-- resources/views/entry/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Entry Details</h1>

    <div class="card">
        <div class="card-header">
            Entry Information
        </div>
        <div class="card-body">
            <h3>Major: {{ $major->name }}</h3>
            <p><strong>Entry Years:</strong></p>
            @foreach($yearsGrouped as $year => $subjects)
                <h4>{{ $year }}</h4>
                <ul>
                    @foreach($subjects as $subject)
                        <li>{{ $subject['subject_name'] }}</li>
                    @endforeach
                </ul>
            @endforeach
        </div>

    </div>

    <a href="{{ route('manage-subject-and-major.create') }}" class="btn btn-primary mt-3">Add New Entry</a>
</div>
@endsection
