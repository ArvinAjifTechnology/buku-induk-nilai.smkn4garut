@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $major->name }}</h1>
    <a href="{{ route('manage-subject-and-major.add-existing-subjects',['entryYear' => $entryYearUniqid, 'major_id' => $major->uniqid]) }}" class="btn btn-primary mb-3">Tambah Mata Pelajaran yang Ada</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Mata Pelajaran</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($major->subjects as $subjects)
                <tr>
                    <td>{{ $subjects->name }}</td>
                    <td>{{ $subjects->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
