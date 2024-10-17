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
                </div>
                <div class="mb-3">
                    <label for="semester">Semester:</label>
                    <select name="semester" id="semester"  class="form-select">
                        <option value="">Pilih Semester</option>
                        @foreach ($semesters as $semester)
                             <option value="{{ $semester->id }}"
                                {{ $semester->id == $selectedSemester ? 'selected' : '' }}>
                                {{ $semester->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3">
                    <label for="subject" class="form-label">Mata Pelajaran</label>
                    <select id="subject" name="subject" class="form-select">
                        <option value="">-</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}"
                                {{ $subject->id == $selectedSubject ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-sm mt-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('home') }}" class="btn btn-secondary btn-sm mt-2 ms-2">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </form>
        </div>
    </div>
</div>
<div class="col-md-8 mb-3">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Distribusi Nilai Siswa per Range 10</h5>
        </div>
        <div class="card-body  chart-container">
            {!! $gradeRangeChart->container() !!}
        </div>
    </div>
</div>

