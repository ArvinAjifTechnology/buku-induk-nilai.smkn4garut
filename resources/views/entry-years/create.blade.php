@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tambahkan Data Tahun Masuk</div>
                <div class="card-body">
                    <form action="{{ route('entry-years.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="year">Tahun Masuk</label>
                            <input type="text" name="year" id="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year') }}">
                            @error('year')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group text-right mt-4">
                            <a href="{{ route('entry-years.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
