@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Hubungkan Mata Pelajaran dengan Jurusan dan Tahun Masuk</h1>
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

        <form action="{{ route('manage-subject-and-major.store-add-existing-subjects') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="entry_year_uniqid">Tahun Masuk</label>
                <select name="entry_year_uniqid" id="entry_year_id" class="form-control" required>
                    <option value="{{ $entryYear->uniqid }}">{{ $entryYear->year }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="major_uniqid">Jurusan</label>
                <select name="major_uniqid" id="major_id" class="form-control" required>
                    <option value="{{ $major->uniqid }}">{{ $major->name }}</option>
                    <!-- Jurusan akan dimuat secara dinamis berdasarkan Tahun Masuk -->
                </select>
            </div>

            <div class="form-group">
                <label for="subjects">Pilih Mata Pelajaran</label>
                <div class="form-check">
                    <input type="checkbox" id="select_all" class="form-check-input">
                    <label for="select_all" class="form-check-label">Pilih Semua Mata Pelajaran</label>
                </div>

                <!-- Search input for filtering subjects -->
                <div class="form-group">
                    <input type="text" id="search_subjects" class="form-control" placeholder="Cari Mata Pelajaran">
                </div>

                <!-- Subject checkboxes -->
                <div id="subjects_list">
                    @foreach ($subjects as $subject)
                        <div class="form-check">
                            <input type="checkbox" name="subject_ids[]" id="subject_{{ $subject->id }}"
                                value="{{ $subject->id }}" class="form-check-input"
                                @if (in_array($subject->id, $attachedSubjectIds)) checked @endif>
                            <label for="subject_{{ $subject->id }}" class="form-check-label">{{ $subject->name }}</label>
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
        document.addEventListener("DOMContentLoaded", () => {
            const searchInput = document.getElementById("search_subjects");
            const subjectList = document.getElementById("subjects_list");
            const checkboxes = subjectList.querySelectorAll(".form-check");

            searchInput.addEventListener("input", () => {
                const searchValue = searchInput.value.toLowerCase();

                checkboxes.forEach((checkbox) => {
                    const label = checkbox.querySelector(".form-check-label");
                    const text = label.textContent.toLowerCase();
                    checkbox.style.display = text.includes(searchValue) ? "block" : "none";
                });
            });

            document.getElementById("select_all").addEventListener("change", function() {
                checkboxes.forEach((checkbox) => {
                    checkbox.querySelector("input[type=checkbox]").checked = this.checked;
                });
            });
        });
    </script>
    <script>
        document.getElementById('entry_year_id').onchange = function() {
            const entryYearId = this.value;
            const majorSelect = document.getElementById('major_id');

            // Hapus pilihan yang ada
            majorSelect.innerHTML = '<option value="">Pilih Jurusan</option>';

            // Ambil daftar jurusan berdasarkan tahun masuk
            if (entryYearId) {
                fetch(`/manage-subject-and-major/get-majors/${entryYearId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(major => {
                            const option = document.createElement('option');
                            option.value = major.id;
                            option.text = major.name;
                            majorSelect.appendChild(option);
                        });
                    });
            }
        }

        document.getElementById('select_all').onclick = function() {
            const checkboxes = document.getElementsByName('subject_ids[]');
            for (const checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        };

        // Event listener untuk setiap checkbox individual
        const checkboxes = document.getElementsByName('subject_ids[]');
        for (const checkbox of checkboxes) {
            checkbox.onclick = function() {
                const allChecked = Array.from(checkboxes).every(chk => chk.checked);
                document.getElementById('select_all').checked = allChecked;
            };
        }
    </script>
@endpush
