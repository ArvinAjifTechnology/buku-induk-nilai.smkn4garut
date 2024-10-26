@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Preview Data Import</h3>

        @foreach (session('import_data') as $import)
            <div>
                <p><strong>File:</strong> {{ $import['file_name'] }}</p>
                <p><strong>Kelas:</strong> {{ $import['class'] }}</p>
                <p><strong>Tahun Ajaran:</strong> {{ $import['yearRange'] }}</p>
                <p><strong>Semester:</strong> {{ $import['semester'] }}</p>

                <!-- Menambahkan jumlah total siswa -->
                <p><strong>Total Siswa yang Akan Diimpor:</strong> {{ count($import['data']) }}</p>

                <!-- Menambahkan detail jumlah mata pelajaran -->
                @php
                    $firstStudentData = $import['data'][0]['scores'] ?? []; // Ambil data nilai pertama untuk referensi
                @endphp
                <p><strong>Total Mata Pelajaran:</strong> {{ count($firstStudentData) }}</p>

                <br>
                <h4>Data Siswa</h4>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>NISN</th>
                            <th>Jurusan</th>
                            <th>Kelas</th>
                            <th>Nilai Mata Pelajaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($import['data'] as $data)
                            <tr>
                                <td>{{ $data['name'] }}</td>
                                <td>{{ $data['nisn'] }}</td>
                                <td>{{ $data['major'] }}</td>
                                <td>{{ $data['entryYear'] . '/' . $data['schoolClass'] }}</td>
                                <td>
                                    <ul>
                                        @foreach ($data['scores'] as $scoreData)
                                            <li>{{ $scoreData['subject'] }}: {{ $scoreData['score'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <hr>
        @endforeach

        <form action="{{ route('students-grades-e-raport-confirmImport') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Konfirmasi dan Simpan</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
