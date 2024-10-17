@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detail Jurusan</div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama Jurusan</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $major->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">Singkatan</label>
                        <input type="text" name="short" class="form-control" id="name" value="{{ $major->short }}" readonly>
                    </div>
                    <a href="{{ route('majors.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
