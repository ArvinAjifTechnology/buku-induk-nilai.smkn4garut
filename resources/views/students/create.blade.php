@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Tambah Data Siswa</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Kelas dan Jurusan -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="school_class_id">Kelas</label>
                                        <select name="school_class_id" id="school_class_id"
                                            class="form-control  @error('school_class_id') is-invalid @enderror">
                                            <option value="">Pilih Kelas</option>
                                            @foreach ($schoolClasses as $schoolClass)
                                                <option value="{{ $schoolClass->id }}"
                                                    {{ old('school_class_id') == $schoolClass->id ? 'selected' : '' }}>
                                                    {{ $schoolClass->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('school_class_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="major_id">Jurusan</label>
                                        <input type="text" name="major_name" id="major_name"
                                            class="form-control @error('major_name') is-invalid @enderror" readonly>
                                        <input type="hidden" name="major_id" id="major_id" value="{{ old('major_id') }}">
                                        @error('major_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div> --}}

                                    <!-- Status Siswa Dan Photo -->
                                    <div class="form-group">
                                        <label for="student_statuses">Student Status</label>
                                        <select name="student_statuses" id="student_statuses"
                                            class="form-control  @error('student_statuses') is-invalid @enderror">
                                            <option value="active"
                                                {{ old('student_statuses') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="graduated"
                                                {{ old('student_statuses') == 'graduated' ? 'selected' : '' }}>Graduated
                                            </option>
                                            <option value="dropped_out"
                                                {{ old('student_statuses') == 'dropped_out' ? 'selected' : '' }}>Dropped
                                                Out</option>
                                        </select>
                                        @error('student_statuses')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <input type="file" name="photo" id="photo"
                                            class="form-control @error('photo') is-invalid @enderror">
                                        @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nama dan Gender -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name">Nama Lengkap</label>
                                        <input type="text" name="full_name" id="full_name"
                                            class="form-control @error('full_name') is-invalid @enderror"
                                            value="{{ old('full_name') }}">
                                        @error('full_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Jenis Kelamin</label>
                                        <select name="gender" id="gender"
                                            class="form-control @error('gender') is-invalid @enderror">
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- NISN dan NIK -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nisn">NISN</label>
                                        <input type="text" name="nisn" id="nisn"
                                            class="form-control @error('nisn') is-invalid @enderror"
                                            value="{{ old('nisn') }}">
                                        @error('nisn')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nis">NIS</label>
                                        <input type="text" name="nis" id="nis"
                                            class="form-control @error('nis') is-invalid @enderror"
                                            value="{{ old('nis') }}">
                                        @error('nis')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nik">NIK</label>
                                        <input type="text" name="nik" id="nik"
                                            class="form-control @error('nik') is-invalid @enderror"
                                            value="{{ old('nik') }}">
                                        @error('nik')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tanggal Lahir dan Tempat Lahir -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="birth_date">Tanggal Lahir</label>
                                        <input type="date" name="birth_date" id="birth_date"
                                            class="form-control @error('birth_date') is-invalid @enderror"
                                            value="{{ old('birth_date') }}">
                                        @error('birth_date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="birth_place">Tempat Lahir</label>
                                        <input type="text" name="birth_place" id="birth_place"
                                            class="form-control @error('birth_place') is-invalid @enderror"
                                            value="{{ old('birth_place') }}">
                                        @error('birth_place')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tahun Masuk dan Agama -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="entry_year_id">Tahun Masuk</label>
                                        <select name="entry_year_id" id="entry_year_id"
                                            class="form-control  @error('entry_year_id') is-invalid @enderror">
                                            <option value="">Pilih Tahun Masuk</option>
                                            @foreach ($entryYears as $year)
                                                <option value="{{ $year->id }}"
                                                    {{ old('entry_year_id') == $year->id ? 'selected' : '' }}>
                                                    {{ $year->year }}</option>
                                            @endforeach
                                        </select>
                                        @error('entry_year_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="religion">Agama</label>
                                        <input type="text" name="religion" id="religion"
                                            class="form-control @error('religion') is-invalid @enderror"
                                            value="{{ old('religion') }}">
                                        @error('religion')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kewarganegaraan dan Kebutuhan Khusus -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nationality">Kewarganegaraan</label>
                                        <input type="text" name="nationality" id="nationality"
                                            class="form-control @error('nationality') is-invalid @enderror"
                                            value="{{ old('nationality') }}">
                                        @error('nationality')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="special_needs">Kebutuhan Khusus</label>
                                        <input type="checkbox" name="special_needs" id="special_needs" value="1"
                                            {{ old('special_needs') ? 'checked' : '' }}>
                                        @error('special_needs')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Alamat Lengkap -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Alamat</label>
                                        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address') }}</textarea>
                                        @error('address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- RT, RW, Desa, Kecamatan, dan Kode Pos -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="text" name="rt" id="rt"
                                            class="form-control @error('rt') is-invalid @enderror"
                                            value="{{ old('rt') }}">
                                        @error('rt')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <input type="text" name="rw" id="rw"
                                            class="form-control @error('rw') is-invalid @enderror"
                                            value="{{ old('rw') }}">
                                        @error('rw')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="village">Desa</label>
                                        <input type="text" name="village" id="village"
                                            class="form-control @error('village') is-invalid @enderror"
                                            value="{{ old('village') }}">
                                        @error('village')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="district">Kecamatan</label>
                                        <input type="text" name="district" id="district"
                                            class="form-control @error('district') is-invalid @enderror"
                                            value="{{ old('district') }}">
                                        @error('district')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="postal_code">Kode Pos</label>
                                        <input type="text" name="postal_code" id="postal_code"
                                            class="form-control @error('postal_code') is-invalid @enderror"
                                            value="{{ old('postal_code') }}">
                                        @error('postal_code')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tempat Tinggal, Tinggi, Berat Badan -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="residence">Tempat Tinggal</label>
                                        <input type="text" name="residence" id="residence"
                                            class="form-control @error('residence') is-invalid @enderror"
                                            value="{{ old('residence') }}">
                                        @error('residence')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="height">Tinggi Badan (cm)</label>
                                        <input type="number" name="height" id="height"
                                            class="form-control @error('height') is-invalid @enderror"
                                            value="{{ old('height') }}">
                                        @error('height')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="weight">Berat Badan (kg)</label>
                                        <input type="number" name="weight" id="weight"
                                            class="form-control @error('weight') is-invalid @enderror"
                                            value="{{ old('weight') }}">
                                        @error('weight')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="siblings">Jumlah Saudara</label>
                                        <input type="number" name="siblings" id="siblings"
                                            class="form-control @error('siblings') is-invalid @enderror"
                                            value="{{ old('siblings') }}">
                                        @error('siblings')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kontak dan Data Orang Tua -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Telepon</label>
                                        <input type="text" name="phone" id="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="father_name">Nama Ayah</label>
                                        <input type="text" name="father_name" id="father_name"
                                            class="form-control @error('father_name') is-invalid @enderror"
                                            value="{{ old('father_name') }}">
                                        @error('father_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="father_birth_year">Tahun Kelahiran Ayah</label>
                                        <input type="number" name="father_birth_year" id="father_birth_year"
                                            class="form-control @error('father_birth_year') is-invalid @enderror"
                                            value="{{ old('father_birth_year') }}">
                                        @error('father_birth_year')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="father_education">Pendidikan Ayah</label>
                                        <input type="text" name="father_education" id="father_education"
                                            class="form-control @error('father_education') is-invalid @enderror"
                                            value="{{ old('father_education') }}">
                                        @error('father_education')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="father_job">Pekerjaan Ayah</label>
                                        <input type="text" name="father_job" id="father_job"
                                            class="form-control @error('father_job') is-invalid @enderror"
                                            value="{{ old('father_job') }}">
                                        @error('father_job')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="father_nik">NIK Ayah</label>
                                        <input type="text" name="father_nik" id="father_nik"
                                            class="form-control @error('father_nik') is-invalid @enderror"
                                            value="{{ old('father_nik') }}">
                                        @error('father_nik')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="father_special_needs">Kebutuhan Khusus Ayah</label>
                                        <input type="checkbox" name="father_special_needs" id="father_special_needs"
                                            value="1" {{ old('father_special_needs') ? 'checked' : '' }}>
                                        @error('father_special_needs')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="mother_name">Nama Ibu</label>
                                        <input type="text" name="mother_name" id="mother_name"
                                            class="form-control @error('mother_name') is-invalid @enderror"
                                            value="{{ old('mother_name') }}">
                                        @error('mother_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="mother_birth_year">Tahun Kelahiran Ibu</label>
                                        <input type="number" name="mother_birth_year" id="mother_birth_year"
                                            class="form-control @error('mother_birth_year') is-invalid @enderror"
                                            value="{{ old('mother_birth_year') }}">
                                        @error('mother_birth_year')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="mother_education">Pendidikan Ibu</label>
                                        <input type="text" name="mother_education" id="mother_education"
                                            class="form-control @error('mother_education') is-invalid @enderror"
                                            value="{{ old('mother_education') }}">
                                        @error('mother_education')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="mother_job">Pekerjaan Ibu</label>
                                        <input type="text" name="mother_job" id="mother_job"
                                            class="form-control @error('mother_job') is-invalid @enderror"
                                            value="{{ old('mother_job') }}">
                                        @error('mother_job')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="mother_nik">NIK Ibu</label>
                                        <input type="text" name="mother_nik" id="mother_nik"
                                            class="form-control @error('mother_nik') is-invalid @enderror"
                                            value="{{ old('mother_nik') }}">
                                        @error('mother_nik')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="mother_special_needs">Kebutuhan Khusus Ibu</label>
                                        <input type="checkbox" name="mother_special_needs" id="mother_special_needs"
                                            value="1" {{ old('mother_special_needs') ? 'checked' : '' }}>
                                        @error('mother_special_needs')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Data Wali dan Dokumen -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="guardian_name">Nama Wali</label>
                                        <input type="text" name="guardian_name" id="guardian_name"
                                            class="form-control @error('guardian_name') is-invalid @enderror"
                                            value="{{ old('guardian_name') }}">
                                        @error('guardian_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="guardian_birth_year">Tahun Kelahiran Wali</label>
                                        <input type="number" name="guardian_birth_year" id="guardian_birth_year"
                                            class="form-control @error('guardian_birth_year') is-invalid @enderror"
                                            value="{{ old('guardian_birth_year') }}">
                                        @error('guardian_birth_year')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="guardian_education">Pendidikan Wali</label>
                                        <input type="text" name="guardian_education" id="guardian_education"
                                            class="form-control @error('guardian_education') is-invalid @enderror"
                                            value="{{ old('guardian_education') }}">
                                        @error('guardian_education')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="guardian_job">Pekerjaan Wali</label>
                                        <input type="text" name="guardian_job" id="guardian_job"
                                            class="form-control @error('guardian_job') is-invalid @enderror"
                                            value="{{ old('guardian_job') }}">
                                        @error('guardian_job')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exam_number">Nomor Ujian</label>
                                        <input type="text" name="exam_number" id="exam_number"
                                            class="form-control @error('exam_number') is-invalid @enderror"
                                            value="{{ old('exam_number') }}">
                                        @error('exam_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="smp_certificate_number">Nomor Sertifikat SMP</label>
                                        <input type="text" name="smp_certificate_number" id="smp_certificate_number"
                                            class="form-control @error('smp_certificate_number') is-invalid @enderror"
                                            value="{{ old('smp_certificate_number') }}">
                                        @error('smp_certificate_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="smp_skhun_number">Nomor SKHUN SMP</label>
                                        <input type="text" name="smp_skhun_number" id="smp_skhun_number"
                                            class="form-control @error('smp_skhun_number') is-invalid @enderror"
                                            value="{{ old('smp_skhun_number') }}">
                                        @error('smp_skhun_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="school_origin">Sekolah Asal</label>
                                        <input type="text" name="school_origin" id="school_origin"
                                            class="form-control @error('school_origin') is-invalid @enderror"
                                            value="{{ old('school_origin') }}">
                                        @error('school_origin')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="entry_date">Tanggal Masuk</label>
                                        <input type="date" name="entry_date" id="entry_date"
                                            class="form-control @error('entry_date') is-invalid @enderror"
                                            value="{{ old('entry_date') }}">
                                        @error('entry_date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="smk_certificate_number">Nomor Sertifikat SMK</label>
                                        <input type="text" name="smk_certificate_number" id="smk_certificate_number"
                                            class="form-control @error('smk_certificate_number') is-invalid @enderror"
                                            value="{{ old('smk_certificate_number') }}">
                                        @error('smk_certificate_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="smk_skhun_number">Nomor SKHUN SMK</label>
                                        <input type="text" name="smk_skhun_number" id="smk_skhun_number"
                                            class="form-control @error('smk_skhun_number') is-invalid @enderror"
                                            value="{{ old('smk_skhun_number') }}">
                                        @error('smk_skhun_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exit_date">Tanggal Keluar</label>
                                        <input type="date" name="exit_date" id="exit_date"
                                            class="form-control @error('exit_date') is-invalid @enderror"
                                            value="{{ old('exit_date') }}">
                                        @error('exit_date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exit_reason">Alasan Keluar</label>
                                        <input type="text" name="exit_reason" id="exit_reason"
                                            class="form-control @error('exit_reason') is-invalid @enderror"
                                            value="{{ old('exit_reason') }}">
                                        @error('exit_reason')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="graduation_year_id">Tahun Lulus</label>
                                        <select name="graduation_year_id" id="graduation_year_id"
                                            class="form-control  @error('graduation_year_id') is-invalid @enderror">
                                            <option value="">Pilih Tahun Lulus</option>
                                            @foreach ($graduationYears as $year)
                                                <option value="{{ $year->id }}"
                                                    {{ old('graduation_year_id') == $year->id ? 'selected' : '' }}>
                                                    {{ $year->year }}</option>
                                            @endforeach
                                        </select>
                                        @error('graduation_year_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="form-group text-right">
                                <a href="{{ route('students.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const schoolClassSelect = document.getElementById('school_class_id');
            const majorNameInput = document.getElementById('major_name');
            const majorIdInput = document.getElementById('major_id');

            schoolClassSelect.addEventListener('change', function() {
                const selectedSchoolClassId = this.value;

                // Clear previous major name and id
                majorNameInput.value = '';
                majorIdInput.value = '';

                if (selectedSchoolClassId) {
                    console.log('Selected School Class ID:', selectedSchoolClassId); // Debugging purpose

                    // Fetch the major related to the selected school class
                    fetch(`/api/get-major-by-class/${selectedSchoolClassId}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Data:', data); // Debugging purpose

                            if (data.success && data.major) {
                                console.log('Major ID:', data.major.id); // Check fetched major ID
                                console.log('Major Name:', data.major.name); // Check fetched major name
                                majorNameInput.value = data.major.name; // Display the major name
                                majorIdInput.value = data.major.id
                            } else {
                                majorNameInput.value = 'Jurusan tidak ditemukan';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching major:', error);
                            majorNameInput.value = 'Error fetching jurusan';
                        });
                }
            });


        });
    </script>
@endpush
