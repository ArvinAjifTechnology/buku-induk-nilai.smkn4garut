@extends('layouts.app')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container">
    <h1>Edit Entry</h1>

    <form action="{{ route('manage-subject-and-major.update', $major->uniqid) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="entry_year_id">Entry Year</label>
            <select name="entry_year_id[]" id="entry_year_id" class="form-control js-example-basic-multiple" multiple required>
                @foreach($entryYears as $entryYear)
                    <option value="{{ $entryYear->id }}"
                        @if(in_array($entryYear->id, $selectedEntryYears)) selected @endif>
                        {{ $entryYear->year }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="subject_id">Subject</label>
            <select name="subject_id[]" id="subject_id" class="form-control js-example-basic-multiple" multiple required>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}"
                        @if(in_array($subject->id, $selectedSubjects)) selected @endif>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Update Entry</button>
    </form>
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endpush
