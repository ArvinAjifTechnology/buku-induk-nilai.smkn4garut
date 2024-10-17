@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Hubungkan Jurusan dengan Tahun Masuk</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('manage-subject-and-major.store-assign-majors') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="entry_year_uniqid">Tahun Masuk</label>
                <select name="entry_year_uniqid" id="entry_year_uniqid" class="form-control" required>
                    <option value="">Pilih Tahun Masuk</option>
                    @foreach ($entryYears as $entryYear)
                        <option value="{{ $entryYear->uniqid }}">{{ $entryYear->year }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="majors">Pilih Jurusan</label>
                <!-- Search input for filtering majors -->
                <div class="form-group">
                    <input type="text" id="search_majors" class="form-control" placeholder="Cari Jurusan">
                </div>

                <div class="form-check">
                    <input type="checkbox" id="select_all" class="form-check-input">
                    <label for="select_all" class="form-check-label">Pilih Semua Jurusan</label>
                </div>

                <div id="majors_list">
                    @foreach ($majors as $major)
                        <div class="form-check">
                            <input type="checkbox" name="major_ids[]" id="major_{{ $major->id }}" value="{{ $major->id }}"
                                class="form-check-input">
                            <label for="major_{{ $major->id }}" class="form-check-label">{{ $major->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Handle search functionality
            const searchInput = document.getElementById('search_majors');
            const majorsList = document.getElementById('majors_list');
            const checkboxes = majorsList.querySelectorAll('.form-check');

            searchInput.addEventListener('input', () => {
                const searchValue = searchInput.value.toLowerCase();

                checkboxes.forEach((checkbox) => {
                    const label = checkbox.querySelector('.form-check-label');
                    const text = label.textContent.toLowerCase();
                    checkbox.style.display = text.includes(searchValue) ? 'block' : 'none';
                });
            });

            // Handle select all functionality
            document.getElementById('select_all').addEventListener('change', function() {
                const checkboxes = document.getElementsByName('major_ids[]');
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = this.checked;
                });
            });
        });
    </script>
@endpush
