@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Nilai</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('grades.update', $grade) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="student_id">Siswa</label>
                            <select name="student_id" class="form-control" id="student_id" required>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}" {{ $student->id == $grade->student_id ? 'selected' : '' }}>{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject_id">Mata Pelajaran</label>
                            <select name="subject_id" class="form-control" id="subject_id" required>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $subject->id == $grade->subject_id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="score">Nilai</label>
                            <input type="number" name="score" class="form-control" id="score" value="{{ $grade->score }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
