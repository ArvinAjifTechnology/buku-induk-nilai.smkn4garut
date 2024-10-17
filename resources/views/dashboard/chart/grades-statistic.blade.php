<!-- Dropdowns for Entry Year and Major -->
<div class="col-md-4 mb-3">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Filter</h5>
        </div>
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('home') }}">
                <div class="mb-3">
                    <label for="entry_year" class="form-label">Tahun Masuk</label>
                    <select id="entry_year" name="entry_year" class="form-select">
                        <option value="" selected>-</option>
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
                        <option value="" selected>-</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}" {{ $major->id == $selectedMajor ? 'selected' : '' }}>
                                {{ $major->name }}
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

<!-- Chart -->
<div class="col-md-8 mb-3">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Statistik Nilai per Mata Pelajaran</h5>
        </div>
        <div class="card-body chart-container">
            {!! $statisticGradeChart->container() !!}
        </div>
    </div>
</div>
