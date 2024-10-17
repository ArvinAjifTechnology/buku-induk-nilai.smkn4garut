 <!-- Table -->
 <div class="table-responsive">
    <table class="table table-striped" id="Table">
        <thead>
            <tr>
                <th>No</th>
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
                    <td>
                        @if ($student->photo)
                            {{-- <img src="{{ public_path('storage/' . $student->photo) }}" class="img-thumbnail mb-3"
                                alt="Foto Siswa" style="width: 2cm; height: 3cm; object-fit: cover;"> --}}
                            {{-- <p>
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> Tersedia
                                </span>
                            </p> --}}
                        @else
                            <div class="placeholder-photo"
                                style="width: 150px; height: 150px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user fa-3x text-muted"></i>
                            </div>
                            <p>
                                <span class="badge bg-danger">
                                    <i class="fas fa-times"></i> Tidak Tersedia
                                </span>
                            </p>
                        @endif
                    </td>
                    <td>
                        {{ $student->entryYear->year }}
                    </td>
                    <td>
                        {{ $student->major->name ?? '-' }}
                    </td>
                    <td>
                        {{ $student->entryYear->year . '/' . $student->schoolClass->name }}
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
