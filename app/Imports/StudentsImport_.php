<?php

namespace App\Imports;

use Exception;
use App\Models\Major;
use App\Models\Student;
use App\Models\EntryYear;
use App\Models\SchoolClass;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Clean the row keys
            $data = $row->mapWithKeys(function ($value, $key) {
                $key = strtolower(str_replace(' ', '_', $key));

                return [$key => $value];
            });
                // Ambil ID kelas, jurusan, dan tahun masuk dari database
        $schoolClass = SchoolClass::where('name', $data['kelas'])->value('id');
        $major = Major::where('name', $data['jurusan'])->value('id');
        $entryYear = EntryYear::where('year', $data['tahun_masuk'])->value('id');

        // Cek apakah NISN atau NIK sudah ada di database dengan NIS berbeda
        $existingStudent = Student::where(function ($query) use ($data) {
            $query->where('nisn', $data['nisn'])
                  ->orWhere('nik', $data['nik']);
        })->where('nis', '!=', $data['nis'])->first();

        // Jika ditemukan duplikat
        if ($existingStudent) {
            throw new Exception("Siswa dengan NISN {$data['nisn']} atau NIK {$data['nik']} sudah ada di database.");
        }
            // Assuming you have columns like 'nis', 'name', 'kelas', 'tahun_masuk', 'jurusan' in your Excel
             Student::updateOrCreate(
                ['nis' => $row['nis']],
                [
                    'school_class_id' => SchoolClass::where('name', $data['kelas'])->value('id'),
                    'major_id' => Major::where('name', $data['jurusan'])->value('id'),
                    'entry_year_id' => EntryYear::where('year', $data['tahun_masuk'])->value('id'),
                    'full_name' => $data['nama_lengkap'],
                    'gender' => $data['jenis_kelamin'],
                    'nisn' => $data['nisn'],
                    'nik' => $data['nik'],
                    'nis' => $data['nis'],
                    'birth_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['tanggal_lahir'])->format('Y-m-d'),
                    'birth_place' => $data['tempat_lahir'],
                    'entry_year' => $data['tahun_masuk'],
                    'religion' => $data['agama'],
                    'nationality' => $data['kewarganegaraan'],
                    'special_needs' => $data['kebutuhan_khusus'] == 'Ya',
                    'address' => $data['alamat'],
                    'village' => $data['desa'],
                    'district' => $data['kecamatan'],
                    'residence' => $data['tempat_tinggal'],
                    'phone' => $data['telepon'],
                    'email' => $data['email'],
                    'rt' => $data['rt'],
                    'rw' => $data['rw'],
                    'father_name' => $data['nama_ayah'],
                    'father_birth_year' => $data['tahun_kelahiran_ayah'],
                    'father_education' => $data['pendidikan_ayah'],
                    'father_job' => $data['pekerjaan_ayah'],
                    'father_nik' => $data['nik_ayah'],
                    'father_special_needs' => $data['kebutuhan_khusus_ayah'] == 'Ya',
                    'mother_name' => $data['nama_ibu'],
                    'mother_birth_year' => $data['tahun_kelahiran_ibu'],
                    'mother_education' => $data['pendidikan_ibu'],
                    'mother_job' => $data['pekerjaan_ibu'],
                    'mother_nik' => $data['nik_ibu'],
                    'mother_special_needs' => $data['kebutuhan_khusus_ibu'] == 'Ya',
                    'guardian_name' => $data['nama_wali'],
                    'guardian_birth_year' => $data['tahun_kelahiran_wali'],
                    'guardian_education' => $data['pendidikan_wali'],
                    'guardian_job' => $data['pekerjaan_wali'],
                    'exam_number' => $data['nomor_ujian'],
                    'smp_certificate_number' => $data['nomor_sertifikat_smp'],
                    'smp_skhun_number' => $data['nomor_skhun_smp'],
                    'school_origin' => $data['sekolah_asal'],
                    'entry_date' => $data['tanggal_masuk'],
                    'smk_certificate_number' => $data['nomor_sertifikat_smk'],
                    'smk_skhun_number' => $data['nomor_skhun_smk'],
                    'exit_date' => $data['tanggal_keluar'],
                    'exit_reason' => $data['alasan_keluar'],
                ]
            );
        }
    }
}
