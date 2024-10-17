@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detail Kelas Sekolah</div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama Kelas Sekolah</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $schoolClass->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="major_id">Jurusan</label>
                        <input type="text" name="major_id" class="form-control" id="major_id" value="{{ $schoolClass->major->name }}" readonly>
                    </div>
                    <a href="{{ route('school_classes.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Data Siswa</h3>
                        <div class="d-flex">
                            <a href="{{ route('students.create') }}" class="btn btn-primary me-2">Tambah Siswa</a>
                            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data"
                                class="me-2">
                                @csrf
                                <div class="input-group">
                                    <input type="file" name="file" id="file" class="form-control" required>
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </div>
                            </form>
                            <a href="{{ route('student-template-download') }}" class="btn btn-info">Download
                                Template</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NISN</th>
                                    <th>Nama Lengkap</th>
                                    <th>Kelas</th>
                                    <th>Jurusan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schoolClass->students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->nisn }}</td>
                                        <td>{{ $student->full_name }}</td>
                                        <td>{{ $student->schoolClass->name }}</td>
                                        <td>{{ $student->major->name ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('students.show', $student) }}"
                                                class="btn btn-info btn-sm">Detail</a>
                                            <a href="{{ route('students.edit', $student) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('students.destroy', $student) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection
