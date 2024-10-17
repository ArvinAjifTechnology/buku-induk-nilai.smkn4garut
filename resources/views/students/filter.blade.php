@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Import and Export Buttons -->
        <!-- Buttons to trigger modal -->
        <!-- Buttons to trigger export and import -->

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <ul>
                    @foreach ($errors->getMessages() as $rowErrors)
                        @foreach ($rowErrors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @endforeach
                </ul>
            </div>
        @endif


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1><i class="fas fa-filter"></i> Filter Data Siswa</h1>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-file-export"></i> Export Data Siswa
            </div>
            <div class="card-body">
                <a href="{{ route('students.export', request()->query()) }}" class="btn btn-success">
                    <i class="fas fa-download"></i> Export
                </a>
            </div>
        </div>

        <!-- Import Form -->
        <div class="mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-file-import"></i> Import Data Siswa
                </div>
                <div class="card-body">
                    <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Choose file to import</label>
                            <input type="file" class="form-control form-control-file mb-3" id="file" name="file"
                                accept=".xls,.xlsx" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Import
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-filter"></i> Filter Data Siswa
            </div>
            <div class="card-body">
                <form action="{{ route('students.filter') }}" method="GET" class="p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="entry_year">Tahun Masuk</label>
                                <select name="entry_year" id="entry_year" class="form-control select2">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($entryYears as $year)
                                        <option value="{{ $year->year }}"
                                            {{ request('entry_year') == $year->year ? 'selected' : '' }}>
                                            {{ $year->year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="major_id">Jurusan</label>
                                <select name="major_id" id="major_id" class="form-control select2">
                                    <option value="">Semua Jurusan</option>
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}"
                                            {{ request('major_id') == $major->id ? 'selected' : '' }}>
                                            {{ $major->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="school_class_id">Kelas</label>
                                <select name="school_class_id" id="school_class_id" class="form-control select2">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($schoolClasses as $class)
                                        <option value="{{ $class->id }}"
                                            {{ request('school_class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label for="student_statuses">Status Siswa</label>
                                <select name="student_statuses" id="student_statuses" class="form-control select2">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('student_statuses') == 'active' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="graduated"
                                        {{ request('student_statuses') == 'graduated' ? 'selected' : '' }}>Lulus</option>
                                    <option value="dropped_out"
                                        {{ request('student_statuses') == 'dropped_out' ? 'selected' : '' }}>Keluar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>



        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-striped" id="Table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aksi</th>
                        <th>Photo</th>
                        <th>Tahun Masuk</th>
                        <th>Jurusan</th>
                        <th>Kelas</th>
                        <th>NISN</th>
                        <th>NIK</th>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Gender</th>
                        <th>Tanggal Lahir</th>
                        <th>Tempat Lahir</th>
                        <th>Jurusan</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Agama</th>
                        <th>Kewarganegaraan</th>
                        <th>Kebutuhan Khusus</th>
                        <th>Alamat</th>
                        <th>RT/RW</th>
                        <th>Desa/Kelurahan</th>
                        <th>Kecamatan</th>
                        <th>Kode Pos</th>
                        <th>Jenis Tempat Tinggal</th>
                        <th>Tinggi Badan</th>
                        <th>Berat Badan</th>
                        <th>Jumlah Saudara</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Nama Ayah</th>
                        <th>Tahun Lahir Ayah</th>
                        <th>Pendidikan Ayah</th>
                        <th>Pekerjaan Ayah</th>
                        <th>NIK Ayah</th>
                        <th>Kebutuhan Khusus Ayah</th>
                        <th>Nama Ibu</th>
                        <th>Tahun Lahir Ibu</th>
                        <th>Pendidikan Ibu</th>
                        <th>Pekerjaan Ibu</th>
                        <th>NIK Ibu</th>
                        <th>Kebutuhan Khusus Ibu</th>
                        <th>Nama Wali</th>
                        <th>Tahun Lahir Wali</th>
                        <th>Pendidikan Wali</th>
                        <th>Pekerjaan Wali</th>
                        <th>No Ujian</th>
                        <th>No Ijazah SMP</th>
                        <th>No SKHUN SMP</th>
                        <th>Asal Sekolah</th>
                        <th>Tanggal Masuk</th>
                        <th>No Ijazah SMK</th>
                        <th>No SKHUN SMK</th>
                        <th>Tanggal Keluar</th>
                        <th>Tahun Lulus</th>
                        <th>Alasan Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="text-center">
                                <a href="{{ route('students.show', $student->uniqid) }}"
                                    class="btn btn-info btn-sm d-inline-block" title="Detail">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{ route('students.edit', $student->uniqid) }}"
                                    class="btn btn-warning btn-sm d-inline-block ml-2" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('students.destroy', $student->uniqid) }}" method="POST"
                                    class="d-inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                                        onclick="return confirm('Yakin ingin menghapus data {{ $student->full_name }}?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>

                            <td>
                                @if ($student->photo)
                                    <!-- Modal untuk menampilkan foto -->
                                    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="photoModalLabel">Foto Siswa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img id="modalPhoto" src="" class="img-fluid"
                                                        alt="Foto Siswa">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <span class="badge bg-success lihat-foto" style="cursor: pointer;"
                                        data-photo="{{ asset('storage/' . $student->photo) }}">
                                        <i class="fas fa-check"></i> Lihat
                                    </span>
                                @else
                                    {{-- <div class="placeholder-photo"
                                        style="width: 150px; height: 150px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user fa-3x text-muted"></i>
                                    </div> --}}
                                    <p>
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times"></i> Tidak Tersedia
                                        </span>
                                    </p>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('students.filter', ['entry_year' => $student->entryYear->year]) }}">
                                    {{ $student->entryYear->year }}
                                </a>
                            </td>
                            <td>
                                <a
                                    href="{{ route('students.filter', ['major_id' => $student->major->id, 'entry_year' => $student->entryYear->year]) }}">
                                    {{ $student->major->name ?? '-' }}
                                </a>
                            </td>
                            <td>
                                <a
                                    href="{{ route('students.filter', ['entry_year' => $student->entryYear->year, 'major' => $student->major->id, 'school_class_id' => $student->schoolClass->id]) }}">
                                    {{ $student->entryYear->year . '/' . $student->schoolClass->name }}
                                </a>
                            </td>
                            <td>{{ $student->nisn }}</td>
                            <td>{{ $student->nik }}</td>
                            <td>{{ $student->nis }}</td>
                            <td>{{ $student->full_name }}</td>
                            <td>{{ $student->gender == 'male' ? 'Laki-Laki' : 'Perempuan' }}</td>
                            <td>{{ \Carbon\Carbon::parse($student->birth_date)->format('d-m-Y') }}</td>
                            <td>{{ $student->birth_place }}</td>
                            <td>{{ $student->major->name ?? '-' }}</td>
                            <td>{{ $student->schoolClass->name ?? '-' }}</td>
                            <td>{{ ucfirst($student->student_statuses) }}</td>
                            <td>{{ $student->religion }}</td>
                            <td>{{ $student->nationality }}</td>
                            <td>{{ $student->special_needs }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ $student->rt ?? '-' }}/{{ $student->rw ?? '-' }}</td>
                            <td>{{ $student->village }}</td>
                            <td>{{ $student->district }}</td>
                            <td>{{ $student->postal_code ?? '-' }}</td>
                            <td>{{ $student->residence }}</td>
                            <td>{{ $student->height ?? '-' }} cm</td>
                            <td>{{ $student->weight ?? '-' }} kg</td>
                            <td>{{ $student->siblings ?? '-' }}</td>
                            <td>{{ $student->phone ?? '-' }}</td>
                            <td>{{ $student->email ?? '-' }}</td>
                            <td>{{ $student->father_name ?? '-' }}</td>
                            <td>{{ $student->father_birth_year ?? '-' }}</td>
                            <td>{{ $student->father_education ?? '-' }}</td>
                            <td>{{ $student->father_job ?? '-' }}</td>
                            <td>{{ $student->father_nik ?? '-' }}</td>
                            <td>{{ $student->father_special_needs ? 'Ya' : 'Tidak' }}</td>
                            <td>{{ $student->mother_name ?? '-' }}</td>
                            <td>{{ $student->mother_birth_year ?? '-' }}</td>
                            <td>{{ $student->mother_education ?? '-' }}</td>
                            <td>{{ $student->mother_job ?? '-' }}</td>
                            <td>{{ $student->mother_nik ?? '-' }}</td>
                            <td>{{ $student->mother_special_needs ? 'Ya' : 'Tidak' }}</td>
                            <td>{{ $student->guardian_name ?? '-' }}</td>
                            <td>{{ $student->guardian_birth_year ?? '-' }}</td>
                            <td>{{ $student->guardian_education ?? '-' }}</td>
                            <td>{{ $student->guardian_job ?? '-' }}</td>
                            <td>{{ $student->exam_number ?? '-' }}</td>
                            <td>{{ $student->smp_certificate_number ?? '-' }}</td>
                            <td>{{ $student->smp_skhun_number ?? '-' }}</td>
                            <td>{{ $student->school_origin ?? '-' }}</td>
                            <td>{{ $student->entry_date ? \Carbon\Carbon::parse($student->entry_date)->format('d-m-Y') : '-' }}
                            </td>
                            <td>{{ $student->smk_certificate_number ?? '-' }}</td>
                            <td>{{ $student->smk_skhun_number ?? '-' }}</td>
                            <td>{{ $student->exit_date ? \Carbon\Carbon::parse($student->exit_date)->format('d-m-Y') : '-' }}
                            </td>
                            <td>{{ $student->graduationYear->year ?? '-' }}</td>
                            <td>{{ $student->exit_reason ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links (if needed) -->
        {{-- {{ $students->links() }} --}}
    </div>
@endsection

@push('js')
    <script>
        // Event listener untuk tombol 'Lihat'
        document.querySelectorAll('.lihat-foto').forEach(button => {
            button.addEventListener('click', function() {
                const photoSrc = this.getAttribute('data-photo');
                document.getElementById('modalPhoto').setAttribute('src', photoSrc);
                const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
                photoModal.show();
            });
        });
    </script>
@endpush
