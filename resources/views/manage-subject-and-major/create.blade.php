@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Entry</h1>

    <form action="{{ route('manage-subject-and-major.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="entry_year_id">Entry Year</label>
            <select name="entry_year_id" id="entry_year_id" class="form-control" required>
                <option value="">Select Entry Year</option>
                @foreach($entryYears as $entryYear)
                    <option value="{{ $entryYear->id }}">{{ $entryYear->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="major_id">Major</label>
            <select name="major_id" id="major_id" class="form-control" required>
                <option value="">Select Major</option>
                @foreach($majors as $major)
                    <option value="{{ $major->id }}">{{ $major->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="subject_id">Subject</label>
            <select name="subject_id" id="subject_id" class="form-control" required>
                <option value="">Select Subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Entry</button>
    </form>
</div>
@endsection
