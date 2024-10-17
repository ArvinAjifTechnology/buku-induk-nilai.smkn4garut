@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Tahun Masuk</div>
                <div class="card-body">
                    <form action="{{ route('graduation-years.update', $graduationYear) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="year">Tahun</label>
                            <input type="text" name="year" id="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', $graduationYear->year) }}">
                            @error('year')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group text-right mt-4">
                            <a href="{{ route('graduation-years.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
