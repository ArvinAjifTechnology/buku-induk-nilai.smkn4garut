@extends('layouts.app')

@section('content')
<form action="{{ route('grades.store') }}" method="POST">
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
                        <td colspan="{{ count($semesters) + 2 }}" class="fw-bold bg-light">
                            {{ $subjectType->name }}
                        </td>
                    </tr>
                    @foreach ($subjectType->subjects as $subject)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $subject->name }}</td>
                            @foreach ($semesters as $semester)
                                @php
                                    // Fetch the previous grade if it exists
                                    $grade = $subject->grades
                                        ->where('semester_id', $semester->id)
                                        ->where('student_id', $student->id)
                                        ->first();
                                    // Set the score value (if grade exists), otherwise set it to an empty value
                                    $score = $grade ? $grade->score : '';
                                @endphp
                                <td class="text-center">
                                    <input type="number" name="grades[{{ $subject->id }}][{{ $semester->id }}]"
                                           class="form-control text-center" value="{{ $score }}" min="0" max="100">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="{{ count($semesters) + 2 }}" class="fw-bold bg-light"></td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
    </div>
</form>

@endsection

