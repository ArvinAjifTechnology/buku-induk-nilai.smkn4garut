<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\EntryYear;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StudentsExport implements FromCollection, WithHeadings, WithStyles, WithMapping, WithColumnFormatting
{
    protected $filters;

    // Constructor to accept filter parameters
    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $entryYearId = null;
        if (isset($this->filters['entry_year'])) {
            $entryYear = EntryYear::where('year', $this->filters['entry_year'])->first();
            $entryYearId = $entryYear ? $entryYear->id : null;
        }

        $query = Student::query()
            ->orderBy('school_class_id', 'asc')
            ->orderBy('full_name', 'asc')
            ->leftJoin('school_classes', 'students.school_class_id', '=', 'school_classes.id')
            ->leftJoin('majors', 'students.major_id', '=', 'majors.id')
            ->leftJoin('entry_years', 'students.entry_year_id', '=', 'entry_years.id')
            ->leftJoin('graduation_years', 'students.graduation_year_id', '=', 'graduation_years.id')
            ->select(
                'school_classes.name as class_name',
                'entry_years.year as entry_year',
                'students.student_statuses as student_status',
                'students.full_name',
                'students.gender',
                'students.nisn',
                'students.nis',
                'students.nik',
                'students.birth_date',
                'students.birth_place',
                'students.religion',
                'students.nationality',
                'students.special_needs',
                'students.address',
                'students.rt',
                'students.rw',
                'students.village',
                'students.district',
                'students.postal_code',
                'students.residence',
                'students.height',
                'students.weight',
                'students.siblings',
                'students.phone',
                'students.email',
                'students.father_name',
                'students.father_birth_year',
                'students.father_education',
                'students.father_job',
                'students.father_nik',
                'students.father_special_needs',
                'students.mother_name',
                'students.mother_birth_year',
                'students.mother_education',
                'students.mother_job',
                'students.mother_nik',
                'students.mother_special_needs',
                'students.guardian_name',
                'students.guardian_birth_year',
                'students.guardian_education',
                'students.guardian_job',
                'students.exam_number',
                'students.smp_certificate_number',
                'students.smp_skhun_number',
                'students.school_origin',
                'students.entry_date',
                'students.smk_certificate_number',
                'students.smk_skhun_number',
                'students.exit_date',
                'graduation_years.year as graduation_year',
                'students.exit_reason'
            );

        // Applying filters
        if (isset($this->filters['major_id'])) {
            $query->where('majors.id', $this->filters['major_id']);
        }
        if (isset($this->filters['school_class_id'])) {
            $query->where('school_classes.id', $this->filters['school_class_id']);
        }
        if ($entryYearId) {
            $query->where('students.entry_year_id', $entryYearId);
        }
        if (isset($this->filters['student_statuses'])) {
            $query->where('students.student_statuses', $this->filters['student_statuses']);
        }
        $students = $query->get();

        // Map English values to Indonesian
        $statusMap = [
            'active' => 'Aktif',
            'graduated' => 'Lulus',
            'dropped_out' => 'Keluar',
        ];

        $genderMap = [
            'male' => 'Laki-Laki',
            'female' => 'Perempuan',
        ];

        // Translate data
        foreach ($students as $student) {
            $student->student_status = $statusMap[$student->student_status] ?? $student->student_status;
            $student->gender = $genderMap[$student->gender] ?? $student->gender;
        }

        return $students;
    }

    public function map($student): array
    {
        return [
            $student->class_name,
            $student->entry_year,
            $student->student_status,
            $student->full_name,
            $student->gender,
            $student->nisn,
            $student->nis,
            $student->nik,
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($student->birth_date),
            $student->birth_place,
            $student->religion,
            $student->nationality,
            $student->special_needs === 0 || $student->special_needs === 1 ? ($student->special_needs ? 0 : 1) : 0, // Show 0 for false or null
            $student->address,
            $student->rt,
            $student->rw,
            $student->village,
            $student->district,
            $student->postal_code ?? 'N/A',
            $student->residence,
            $student->height,
            $student->weight,
            $student->siblings,
            $student->phone,
            $student->email,
            $student->father_name,
            $student->father_birth_year,
            $student->father_education,
            $student->father_job,
            $student->father_nik,
            $student->father_special_needs === 0 || $student->father_special_needs === 1 ? ($student->father_special_needs ? 0 : 1) : 0, // Show 0 for false or null
            $student->mother_name,
            $student->mother_birth_year,
            $student->mother_education,
            $student->mother_job,
            $student->mother_nik,
            $student->mother_special_needs === 0 || $student->mother_special_needs === 1 ? ($student->mother_special_needs ? 0 : 1) : 0, // Show 0 for false or null
            $student->guardian_name,
            $student->guardian_birth_year,
            $student->guardian_education,
            $student->guardian_job,
            $student->exam_number,
            $student->smp_certificate_number,
            $student->smp_skhun_number,
            $student->school_origin,
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($student->entry_date),
            $student->smk_certificate_number,
            $student->smk_skhun_number,
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($student->exit_date),
            $student->graduation_year,
            $student->exit_reason,
        ];
    }



    public function headings(): array
    {
        return [
            'Kelas',
            'Tahun Masuk',
            'Status Siswa',
            'Nama Lengkap',
            'Jenis Kelamin',
            'NISN',
            'NIS',
            'NIK',
            'Tanggal Lahir',
            'Tempat Lahir',
            'Agama',
            'Kewarganegaraan',
            'Kebutuhan Khusus',
            'Alamat',
            'RT',
            'RW',
            'Desa',
            'Kecamatan',
            'Kode Pos',
            'Tempat Tinggal',
            'Tinggi Badan',
            'Berat Badan',
            'Jumlah Saudara',
            'Telepon',
            'Email',
            'Nama Ayah',
            'Tahun Kelahiran Ayah',
            'Pendidikan Ayah',
            'Pekerjaan Ayah',
            'NIK Ayah',
            'Kebutuhan Khusus Ayah',
            'Nama Ibu',
            'Tahun Kelahiran Ibu',
            'Pendidikan Ibu',
            'Pekerjaan Ibu',
            'NIK Ibu',
            'Kebutuhan Khusus Ibu',
            'Nama Wali',
            'Tahun Kelahiran Wali',
            'Pendidikan Wali',
            'Pekerjaan Wali',
            'Nomor Ujian',
            'Nomor Sertifikat SMP',
            'Nomor SKHUN SMP',
            'Sekolah Asal',
            'Tanggal Masuk',
            'Nomor Sertifikat SMK',
            'Nomor SKHUN SMK',
            'Tanggal Keluar',
            'Tahun Lulus',
            'Alasan Keluar'
        ];
    }

    // Formatting the date columns
    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Tanggal Lahir
            'AI' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Tanggal Masuk
            'AM' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Tanggal Keluar
        ];
    }

    // Styling the headings
    public function styles(Worksheet $sheet)
    {
        $headerRow = 1; // Assuming headers are in the first row

        // Apply styles to the header row
        $sheet->getStyle('A' . $headerRow . ':AY' . $headerRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['argb' => 'FFFFFFFF']
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center'
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => 'FF000000'] // Background color: black
            ]
        ]);

        // Adjust column widths manually
        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY'];
        foreach ($columns as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }
}
