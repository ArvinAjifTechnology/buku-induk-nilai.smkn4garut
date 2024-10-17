@extends('layouts.app')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush


@section('content')
<div class="container">
    <h2>Mengelola Mata Pelajaran untuk Tahun Masuk: {{ $entryYear->year }}</h2>

    @foreach($majors as $major)
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $major->name }}</h5>
            <form action="{{ route('manage-subject-and-major.update', ['entryYear' => $entryYear->id, 'major' => $major->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="subjects">Pilih Mata Pelajaran:</label>
                    <select name="subjects[]" id="subjects_{{ $loop->index }}" class="form-control js-example-basic-multiple" multiple>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}"
                            @if(in_array($subject->id, $major->subjects()->wherePivot('entry_year_id', $entryYear->id)->pluck('subject_id')->toArray()))
                                selected
                            @endif>
                            {{ $subject->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('select.js-example-basic-multiple').each(function() {
        $(this).select2();
    });
});
</script>
@endpush
