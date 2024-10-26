@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Preview Data Import - File: {{ $import['file_name'] }}</h3>
        <p><strong>Kelas:</strong> {{ $import['class'] }}</p>
        <p><strong>Tahun Ajaran:</strong> {{ $import['yearRange'] }}</p>
        <p><strong>Semester:</strong> {{ $import['semester'] }}</p>
        <p><strong>Total Siswa:</strong> {{ count($import['data']) }}</p>

        <h5>Data Siswa</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>NISN</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($import['data'] as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data['name'] }}</td>
                        <td>{{ $data['nisn'] }}</td>
                        <td>{{ $data['schoolClass'] }}</td>
                        <td>{{ $data['major'] }}</td>
                        <td>
                            <ul>
                                @foreach ($data['scores'] as $score)
                                    <li>{{ $score['subject'] }}: {{ $score['score'] }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('students-grades-e-raport-confirm-import') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-success">Konfirmasi dan Lanjutkan</button>
        </form>

        <form action="{{ route('students-grades-e-raport-cancel-import') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Batalkan</button>
        </form>
    </div>
@endsection
