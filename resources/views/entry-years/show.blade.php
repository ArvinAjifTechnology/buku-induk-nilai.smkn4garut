@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tahun Masuk Details</div>
                <div class="card-body">
                    {{-- <p><strong>ID:</strong> {{ $entryYear->id }}</p> --}}
                    <p><strong>Tahun</strong> {{ $entryYear->year }}</p>
                    <a href="{{ route('entry-years.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
