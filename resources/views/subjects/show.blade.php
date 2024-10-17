@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Mata Pelajaran</h1>
    <div class="card">
        <div class="card-header">
            Mata Pelajaran #{{ $subject->name }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Nama: {{ $subject->name }}</h5>
            <p class="card-text">ID Jenis Mata Pelajaran: {{ $subject->subject_type_id }}</p>
            <p class="card-text">Deskripsi: {{ $subject->description }}</p>
            <a href="{{ route('subjects.index') }}" class="btn btn-primary">Kembali</a>
            <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
