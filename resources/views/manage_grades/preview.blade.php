@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Preview Import Data</h3>

    <p><strong>File:</strong> {{ session('file_name') }}</p>
    <p><strong>Kelas:</strong> {{ session('class') }}</p>
    <p><strong>Tahun Ajaran:</strong> {{ session('yearRange') }}</p>
    <p><strong>Semester:</strong> {{ session('semester') }}</p>

    <h4>Data Siswa:</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NISN</th>
                <th>Matapelajaran dan Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach (session('import_data') as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row[1] }}</td> <!-- Nama -->
                    <td>{{ $row[2] }}</td> <!-- NISN -->
                    <td>
                        <ul>
                            @for ($i = 3; $i < count($row); $i++)
                                <li>Subject {{ $i - 2 }}: {{ $row[$i] }}</li>
                            @endfor
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('students-grades-e-raport-confirmImport') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Konfirmasi dan Simpan</button>
    </form>
</div>
@endsection
