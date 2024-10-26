@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Preview Data Import</h3>

        @foreach (session('import_data') as $import)
            <h4>File: {{ $import['file_name'] }}</h4>
            <p><strong>Kelas:</strong> {{ $import['class'] }}</p>
            <p><strong>Tahun Ajaran:</strong> {{ $import['yearRange'] }}</p>
            <p><strong>Semester:</strong> {{ $import['semester'] }}</p>
            <p><strong>Total Siswa:</strong> {{ count($import['data']) }}</p>

            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>Jurusan</th>
                        <th>Kelas</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($import['data'] as $row)
                        <tr>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['nisn'] }}</td>
                            <td>{{ $row['major'] }}</td>
                            <td>{{ $row['entryYear'] . '/' . $row['schoolClass'] }}</td>
                            <td>
                                <ul>
                                    @foreach ($row['scores'] as $scoreData)
                                        <li>{{ $scoreData['subject'] }}: {{ $scoreData['score'] }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach

        <form action="{{ route('students-grades-e-raport-confirmImport') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Konfirmasi dan Simpan</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
