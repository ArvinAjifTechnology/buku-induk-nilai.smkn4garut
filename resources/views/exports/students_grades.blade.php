<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<table class="table table-bordered">
    <thead class="thead-dark">
        <tr>
            <th rowspan="2" class="text-center align-middle">No</th>
            <th rowspan="2" class="text-center align-middle">NIS</th>
            <th rowspan="2" class="text-center align-middle">NISN</th>
            <th rowspan="2" class="text-center align-middle">Kelas</th>
            <th rowspan="2" class="text-center align-middle">Jurusan</th>
            <th rowspan="2" class="text-center align-middle">Nama</th>
            @foreach ($subjects as $subject)
                <th colspan="{{ $semesters->count() }}" class="text-center align-middle">{{ $subject->name }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach ($subjects as $subject)
                @foreach ($semesters as $semester)
                    <th class="text-center">{{ $semester->id }}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $index => $student)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->nis }}</td>
                <td>{{ $student->nisn }}</td>
                <td>{{ $student->entryYear->year.'/'.$student->schoolClass->name }}</td>
                <td>{{ $student->major->short }}</td>
                <td>{{ $student->full_name }}</td>
                @foreach ($subjects as $subject)
                    @foreach ($semesters as $semester)
                        @php
                            // Fetch the grade for the current student, subject, and semester
                            $grade = $student->grades
                                ->where('subject_id', $subject->id)
                                ->where('semester_id', $semester->id)
                                ->first();
                        @endphp
                        <td class="text-center">{{ $grade ? $grade->score : '' }}</td>
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
