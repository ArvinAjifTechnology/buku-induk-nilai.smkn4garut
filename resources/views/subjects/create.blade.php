@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($subject) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ isset($subject) ? route('subjects.update', $subject->id) : route('subjects.store') }}"
            method="POST">
            @csrf
            @if (isset($subject))
                @method('PUT')
            @endif
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ isset($subject) ? $subject->name : '' }}">
            </div>
            <div class="form-group">
                <label for="short">Singkatan</label>
                <input type="text" name="short" class="form-control" id="short" value="{{ old('short') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="subject_type_id" class="form-label">Jenis Mata Pelajaran</label>
                <select class="form-control select2" id="subject_type_id" name="subject_type_id">
                    <option value="">Pilih Jenis Mata Pelajaran</option>
                    @foreach ($subjectTypes as $subjectType)
                        <option value="{{ $subjectType->id }}"
                            {{ isset($subject) && $subject->subject_type_id == $subjectType->id ? 'selected' : '' }}>
                            {{ $subjectType->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description">{{ isset($subject) ? $subject->description : '' }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($subject) ? 'Update' : 'Tambah' }}</button>
        </form>
    </div>
@endsection
