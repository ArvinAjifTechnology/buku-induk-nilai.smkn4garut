@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Preview Data Import</h3>

    <p><strong>File:</strong> {{ session('file_name') }}</p>
    <p><strong>Kelas:</strong> {{ session('class') }}</p>
    <p><strong>Tahun Ajaran:</strong> {{ session('yearRange') }}</p>
    <p><strong>Semester:</strong> {{ session('semester') }}</p>

    <!-- Menambahkan jumlah total siswa -->
    <p><strong>Total Siswa yang Akan Diimpor:</strong> {{ count(session('import_data')) }}</p>

    <!-- Menambahkan detail jumlah mata pelajaran -->
    <p><strong>Total Mata Pelajaran:</strong> {{ count(session('import_data')->first()) - 3 }}</p> <!-- -3 untuk mengabaikan kolom No, Nama, NISN -->

    <h4>Data Siswa:</h4>

    <!-- Tabel Preview Data -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NISN</th>
                @for ($i = 3; $i < count(session('import_data')->first()); $i++)
                    <th>Subject {{ $i - 2 }}</th> <!-- Mengisi Header Subject -->
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach (session('import_data') as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row[1] }}</td> <!-- Nama Siswa -->
                    <td>{{ $row[2] }}</td> <!-- NISN -->
                    @for ($i = 3; $i < count($row); $i++)
                        <td>{{ $row[$i] }}</td> <!-- Nilai Mata Pelajaran -->
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tombol Konfirmasi -->
    <form action="{{ route('grades.confirmImport') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Konfirmasi dan Simpan</button>
    </form>

    <!-- Tombol Batalkan -->
    <form action="{{ route('home') }}" method="GET" class="mt-2">
        <button type="submit" class="btn btn-danger">Batalkan</button>
    </form>
</div>
@endsection
