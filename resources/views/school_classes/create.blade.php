@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Kelas Sekolah</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('school_classes.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Kelas Sekolah</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="major_id">Jurusan</label>
                            <select name="major_id" class="form-control" id="major_id" required>
                                @foreach ($majors as $major)
                                    <option value="{{ $major->id }}">{{ $major->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
