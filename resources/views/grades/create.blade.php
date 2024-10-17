@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Nilai</div>

                <div class="card-body">
                    <form action="{{ route('grades.store') }}" method="POST">
                        @csrf
                        <div id="grades-container">
                            <div class="grade-group">
                                <div class="form-group">
                                    <label for="student_id">Siswa</label>
                                    <select name="grades[0][student_id]" class="form-control" id="student_id" required>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="subject_id">Mata Pelajaran</label>
                                    <select name="grades[0][subject_id]" class="form-control" id="subject_id" required>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="semester_id">Semester</label>
                                    <select name="grades[0][semester_id]" class="form-control" id="semester_id" required>
                                        @foreach ($semesters as $semester)
                                            <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="score">Nilai</label>
                                    <input type="number" name="grades[0][score]" class="form-control" value="{{ old('score') }}" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary mt-3" id="add-grade">Tambah Nilai</button>
                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    
                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
document.getElementById('student_id').addEventListener('change', function() {
    const studentId = this.value;

    // Fetch subjects and semesters for this student
    fetch(`/api/grades/${studentId}/options`)
        .then(response => response.json())
        .then(data => {
            const subjectSelect = document.getElementById('subject_id');
            const semesterSelect = document.getElementById('semester_id');

            // Clear existing options
            subjectSelect.innerHTML = '';
            semesterSelect.innerHTML = '';

            data.subjects.forEach(subject => {
                const option = document.createElement('option');
                option.value = subject.id;
                option.textContent = subject.name;
                subjectSelect.appendChild(option);
            });

            data.semesters.forEach(semester => {
                const option = document.createElement('option');
                option.value = semester.id;
                option.textContent = semester.name;
                semesterSelect.appendChild(option);
            });
        });
});

</script>
@endpush
