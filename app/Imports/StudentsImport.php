<?php

namespace App\Imports;

use App\Models\Major;
use App\Models\Student;
use App\Models\EntryYear;
use App\Models\SchoolClass;
use App\Models\GraduationYear;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StudentsImport implements ToCollection, WithHeadingRow, WithValidation, WithMultipleSheets
{
    // Aturan validasi untuk import
    public function rules(): array
    {
        return [
            'kelas' => 'nullable|string',
            'jurusan' => 'nullable|string',
            'tahun_masuk' => 'nullable|integer',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:10',
            'nisn' => 'required',
            'nik' => 'required',
            'nis' => 'required',
            'tanggal_lahir' => 'required',
            'tempat_lahir' => 'required|string|max:255',
            'agama' => 'required|string|max:50',
            'kewarganegaraan' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'tempat_tinggal' => 'required|string|max:255',
            // 'kebutuhan_khusus' => 'boolean',
            // 'telepon' => 'nullable|string|max:20',
            // 'email' => 'nullable|string|email|max:255',
            // 'nama_ayah' => 'nullable|string|max:255',
            // 'tahun_kelahiran_ayah' => 'nullable|integer',
            // 'pendidikan_ayah' => 'nullable|string|max:50',
            // 'pekerjaan_ayah' => 'nullable|string|max:100',
            // 'nik_ayah' => 'nullable|string|max:20',
            // 'kebutuhan_khusus_ayah' => 'nullable',
            // 'nama_ibu' => 'nullable|string|max:255',
            // 'tahun_kelahiran_ibu' => 'nullable|integer',
            // 'pendidikan_ibu' => 'nullable|string|max:50',
            // 'pekerjaan_ibu' => 'nullable|string|max:100',
            // 'nik_ibu' => 'nullable|string|max:20',
            // 'kebutuhan_khusus_ibu' => 'nullable',
            // 'nama_wali' => 'nullable|string|max:255',
            // 'tahun_kelahiran_wali' => 'nullable|integer',
            // 'pendidikan_wali' => 'nullable|string|max:50',
            // 'pekerjaan_wali' => 'nullable|string|max:100',
            // 'nomor_ujian' => 'nullable|string|max:50',
            // 'nomor_sertifikat_smp' => 'nullable|string|max:50',
            // 'nomor_skhun_smp' => 'nullable|string|max:50',
            // 'sekolah_asal' => 'nullable|string|max:255',
            // 'tanggal_masuk' => 'nullable',
            // 'nomor_sertifikat_smk' => 'nullable|string|max:50',
            // 'nomor_skhun_smk' => 'nullable|string|max:50',
            // 'tanggal_keluar' => 'nullable',
            // 'tahun_lulus' => 'nullable',
            // 'alasan_keluar' => 'nullable|string|max:255',
        ];
    }

    public function collection(Collection $rows)
    {
        $errors = [];
        foreach ($rows as $row) {
            $data = $row->mapWithKeys(function ($value, $key) {
                $key = strtolower(str_replace(' ', '_', $key));
                return [$key => $value];
            });

            if ($data->filter()->isEmpty()) {
                // Jika seluruh kolom kosong, lewati baris ini
                continue;
            }

            $genderMapping = [
                'Laki-Laki' => 'male',
                'Perempuan' => 'female'
            ];
            $studentStatusMapping = [
                'Aktif' => 'active',
                'Lulus' => 'graduated',
                'Keluar' => 'dropped_out'
            ];

           // Cek apakah data siswa sudah ada berdasarkan NIS
            $existingStudent = Student::where('nis', $data['nis'])->first();

            $studentId = $existingStudent ? $existingStudent->id : null; // Dapatkan ID jika siswa sudah ada

            foreach ($rows as $index => $row) {
                $validator = Validator::make($data->toArray(), [
                    'nisn' => 'required|unique:students,nisn,' . $studentId,
                    'nik' => 'required|unique:students,nik,' . $studentId,
                    'nis' => 'required|unique:students,nis,' . $studentId,
                ]);

                if ($validator->fails()) {
                    // Store the errors along with the index (row number)
                    $errors[] = [
                        'index' => $index + 1, // To make the index human-readable (1-based)
                        'row' => $row, // The specific row data
                        'errors' => $validator->errors()->all() // The validation errors
                    ];
                }
            }
            // dd($errors);

            // If there are any validation errors, pass them to the session
            if (!empty($errors)) {
                return redirect()->back()
                    ->with('bulk_errors', $errors) // Pass the entire errors array
                    ->withInput(); // Keep form input data
            }


            // $errors[] = [
            //     'row' => $row, // Store row data that failed
            //     'errors' => $validator->errors()->all() // Store the validation errors
            // ];


            // if (!empty($errors)) {
            //     return redirect()->back()
            //         ->with('bulk_errors', $errors) // Store the entire set of errors for bulk processing
            //         ->withInput(); // Keep input intact for the form fields
            // }


            $schoolClassId = SchoolClass::where('name', $data['kelas'])->value('id');
            $schoolClass = SchoolClass::find($schoolClassId);
            $majorId = $schoolClass ? Major::where('id', $schoolClass->major_id)->value('id') : null;

            // Handle dates
            $birthDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['tanggal_lahir'])->format('Y-m-d');
            $entryDate = $data['tanggal_masuk'] ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['tanggal_masuk'])->format('Y-m-d') : null;
            $exitDate = $data['tanggal_keluar'] ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['tanggal_keluar'])->format('Y-m-d') : null;

            // Create or update student
            Student::updateOrCreate(
                ['nis' => $data['nis']],
                [
                    'school_class_id' => $schoolClassId,
                    'major_id' => $majorId,
                    'entry_year_id' => EntryYear::where('year', $data['tahun_masuk'])->value('id'),
                    'graduation_year_id' => GraduationYear::where('year', $data['tahun_lulus'])->value('id'),
                    'full_name' => $data['nama_lengkap'],
                    'gender' => $genderMapping[$data['jenis_kelamin']] ?? '',
                    'student_statuses' => $studentStatusMapping[$data['status_siswa']] ?? 'active',
                    'nisn' => $data['nisn'],
                    'nik' => $data['nik'],
                    'nis' => $data['nis'],
                    'birth_date' => $birthDate,
                    'birth_place' => $data['tempat_lahir'],
                    'religion' => $data['agama'],
                    'nationality' => $data['kewarganegaraan'],
                    'special_needs' => $data['kebutuhan_khusus'] === 0,
                    'address' => $data['alamat'],
                    'rt' => $data['rt'],
                    'rw' => $data['rw'],
                    'village' => $data['desa'],
                    'district' => $data['kecamatan'],
                    'postal_code' => $data['kode_pos'],
                    'residence' => $data['tempat_tinggal'],
                    'height' => $data['tinggi_badan'],
                    'weight' => $data['berat_badan'],
                    'siblings' => $data['jumlah_saudara'],
                    'phone' => $data['telepon'],
                    'email' => $data['email'],
                    'father_name' => $data['nama_ayah'],
                    'father_birth_year' => $data['tahun_kelahiran_ayah'],
                    'father_education' => $data['pendidikan_ayah'],
                    'father_job' => $data['pekerjaan_ayah'],
                    'father_nik' => $data['nik_ayah'],
                    'father_special_needs' => $data['kebutuhan_khusus_ayah'] ?? 0 ,
                    'mother_name' => $data['nama_ibu'],
                    'mother_birth_year' => $data['tahun_kelahiran_ibu'],
                    'mother_education' => $data['pendidikan_ibu'],
                    'mother_job' => $data['pekerjaan_ibu'],
                    'mother_nik' => $data['nik_ibu'],
                    'mother_special_needs' => $data['kebutuhan_khusus_ibu'] ?? 0 ,
                    'guardian_name' => $data['nama_wali'],
                    'guardian_birth_year' => $data['tahun_kelahiran_wali'],
                    'guardian_education' => $data['pendidikan_wali'],
                    'guardian_job' => $data['pekerjaan_wali'],
                    'exam_number' => $data['nomor_ujian'],
                    'smp_certificate_number' => $data['nomor_sertifikat_smp'],
                    'smp_skhun_number' => $data['nomor_skhun_smp'],
                    'school_origin' => $data['sekolah_asal'],
                    'entry_date' => $entryDate,
                    'smk_certificate_number' => $data['nomor_sertifikat_smk'],
                    'smk_skhun_number' => $data['nomor_skhun_smk'],
                    'exit_date' => $exitDate,
                    'exit_reason' => $data['alasan_keluar'],
                ]
            );

            \Log::info('Successfully processed row: ' . json_encode($data->toArray()));
        }
    }


    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    // Mendapatkan ID student untuk validasi
    protected function getStudentId(array $row)
    {
        $student = Student::where('nis', $row['nis'])->first();
        return $student ? $student->id : null;
    }
}
