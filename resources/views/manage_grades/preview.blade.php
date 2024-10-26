@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Preview Data Import - File: {{ $import['file_name'] }}</h3>
        <p><strong>Kelas:</strong> {{ $import['class'] }}</p>
        <p><strong>Tahun Ajaran:</strong> {{ $import['yearRange'] }}</p>
        <p><strong>Semester:</strong> {{ $import['semester'] }}</p>
        <p><strong>Total Siswa:</strong> {{ count($import['data']) }}</p>

        <h5>Data Siswa</h5>
       <div style="max-height: 400px; overflow-y: auto;">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <!-- Add dynamic subject headers -->
                @if (count($import['data']) > 0)
                    @foreach ($import['data'][0]['scores'] as $score)
                        <th>{{ $score['subject'] }}</th>
                    @endforeach
                @endif
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
                    <!-- Loop through scores to populate the values -->
                    @foreach ($data['scores'] as $score)
                        <td>{{ $score['score'] }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



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
