@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detail Tipe Mata Pelajaran</div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama Tipe Mata Pelajaran</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $subjectType->name }}" readonly>
                    </div>
                    <a href="{{ route('subject_types.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
