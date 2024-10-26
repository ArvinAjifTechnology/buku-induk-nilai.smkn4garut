@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-file-alt me-2"></i> Preview Data Import - File: {{ $import['file_name'] }}</h5>
            </div>
            <div class="card-body">
                <p><strong><i class="fas fa-users-class me-2"></i> Kelas:</strong> {{ $import['class'] }}</p>
                <p><strong><i class="fas fa-calendar-alt me-2"></i> Tahun Ajaran:</strong> {{ $import['yearRange'] }}</p>
                <p><strong><i class="fas fa-calendar-check me-2"></i> Semester:</strong>
                    {{ $import['semester_in_e_raport'].'/'.$import['semester'] }}
                </p>
                <p><strong><i class="fas fa-user-friends me-2"></i> Total Siswa:</strong> {{ count($import['data']) }}</p>

                <h5><i class="fas fa-users me-2"></i> Data Siswa</h5>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> No</th>
                                <th><i class="fas fa-user"></i> Nama Siswa</th>
                                <th><i class="fas fa-id-card"></i> NISN</th>
                                <th><i class="fas fa-school"></i> Kelas</th>
                                <th><i class="fas fa-graduation-cap"></i> Jurusan</th>
                                @if (count($import['data']) > 0)
                                    @foreach ($import['data'][0]['scores'] as $score)
                                        <th><i class="fas fa-book-open"></i> {{ $score['subject'] }}</th>
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
                                    @foreach ($data['scores'] as $score)
                                        <td>{{ $score['score'] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <form action="{{ route('students-grades-e-raport-confirm-import') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle me-1"></i> Konfirmasi dan Lanjutkan
                </button>
            </form>

            <form action="{{ route('students-grades-e-raport-cancel-import') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times-circle me-1"></i> Batalkan dan Lanjutkan
                </button>
            </form>
        </div>
    </div>
@endsection
