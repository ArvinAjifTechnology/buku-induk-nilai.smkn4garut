<div class="col-12 col-md-8 mb-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Status Nilai Mata Pelajaran per Kelas</h5>
        </div>
        <div class="card-body chart-container">
            {!! $subjectCompletionChart->container() !!}
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="col-md-4 mb-3">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Filter</h5>
        </div>
        <div class="card-body">
            <form id="filterForm2" method="GET" action="{{ route('home') }}">
                <div class="mb-3">
                    <label for="entry_year" class="form-label">Tahun Masuk</label>
                    <select id="entry_year" name="entry_year" class="form-select">
                        <option value="">-</option>
                        @foreach ($entryYears as $entryYear)
                            <option value="{{ $entryYear->id }}"
                                {{ $entryYear->id == $selectedEntryYear ? 'selected' : '' }}>
                                {{ $entryYear->year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="major" class="form-label">Jurusan</label>
                    <select id="major" name="major" class="form-select">
                        <option value="">-</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}" {{ $major->id == $selectedMajor ? 'selected' : '' }}>
                                {{ $major->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select id="semester" name="semester" class="form-select">
                        <option value="">-</option>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester->id }}"
                                {{ $semester->id == $selectedSemester ? 'selected' : '' }}>
                                {{ $semester->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="school_class" class="form-label">Kelas</label>
                    <select id="school_class" name="school_class" class="form-select">
                        <option value="">-</option>
                        @foreach ($schoolClasses as $schoolClass)
                            <option value="{{ $schoolClass->id }}"
                                {{ $schoolClass->id == $selectedSchoolClass ? 'selected' : '' }}>
                                {{ $schoolClass->name }}
                            </option>
                        @endforeach
                    </select>
                    <!-- Tombol Simpan -->
                    <button type="submit" class="btn btn-primary btn-sm mt-2">
                        <i class="fas fa-save"></i> Simpan
                    </button>

                    <!-- Tombol Reset -->
                    <a href="{{ route('home') }}" class="btn btn-secondary btn-sm mt-2 ms-2">
                        <i class="fas fa-sync-alt"></i> Reset
                    </a>

                </div>
            </form>
        </div>
    </div>
</div>
