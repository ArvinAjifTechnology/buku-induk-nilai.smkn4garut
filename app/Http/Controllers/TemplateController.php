<?php

namespace App\Http\Controllers;

use App\Exports\MajorStudentsGradesExport;
use App\Exports\SchoolClassStudentsGradesExport;
use App\Exports\StudentGradesTemplateExport;
use App\Models\EntryYear;
use App\Models\GraduationYear;
use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SubjectType;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TemplateController extends Controller
{
    public function studentTemplateDownload()
    {
        // 1. Baca file template yang sudah ada
        $templatePath = storage_path('app/public/templates/Template_Siswa_Awal.xlsx');

        // Periksa apakah file ada
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }

        // Load template Excel
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // 2. Ambil data untuk dropdown dari database
        $schoolClasses = SchoolClass::orderBy('name', 'asc')->pluck('name')->toArray();
        $entryYears = EntryYear::orderBy('year', 'desc')->pluck('year')->toArray();
        $graduationYears = GraduationYear::orderBy('year', 'desc')->pluck('year')->toArray();
        // dd($graduationYears);
        $studentStatuses =['Aktif', 'Lulus', 'Keluar'];
        $genders =['Laki-Laki', 'Perempuan'];

        // 3. Buat sheet baru untuk data dropdown
        $dropdownSheet = $spreadsheet->createSheet();
        $dropdownSheet->setTitle('DropdownData');

        // Isi data dropdown Kelas
        foreach ($schoolClasses as $index => $schoolClass) {
            $dropdownSheet->setCellValue('A'.($index + 1), $schoolClass);
        }

        // Isi data dropdown Tahun Masuk
        foreach ($entryYears as $index => $entryYear) {
            $dropdownSheet->setCellValue('B'.($index + 1), $entryYear);
        }

        foreach ($studentStatuses as $index => $studentStatus) {
            $dropdownSheet->setCellValue('C'.($index + 1), $studentStatus);
        }
        foreach ($genders as $index => $gender) {
            $dropdownSheet->setCellValue('E'.($index + 1), $gender);
        }

        foreach ($graduationYears as $index => $graduationYear) {
            $dropdownSheet->setCellValue('AX'.($index + 1), $graduationYear);
        }
        // 4. Tambahkan dropdown untuk seluruh kolom Kelas, Tahun Masuk, dan Jurusan hingga baris 1000
        for ($row = 2; $row <= 10000; ++$row) {
            $schoolClassValidation = $sheet->getCell('A'.$row)->getDataValidation();
            $schoolClassValidation->setType(DataValidation::TYPE_LIST);
            $schoolClassValidation->setErrorStyle(DataValidation::STYLE_STOP);
            $schoolClassValidation->setAllowBlank(true);
            $schoolClassValidation->setShowDropDown(true);
            $schoolClassValidation->setFormula1('DropdownData!$A$1:$A$'.count($schoolClasses));

            $entryYearValidation = $sheet->getCell('B'.$row)->getDataValidation();
            $entryYearValidation->setType(DataValidation::TYPE_LIST);
            $entryYearValidation->setErrorStyle(DataValidation::STYLE_STOP);
            $entryYearValidation->setAllowBlank(true);
            $entryYearValidation->setShowDropDown(true);
            $entryYearValidation->setFormula1('DropdownData!$B$1:$B$'.count($entryYears));


            $studentStatusValidation = $sheet->getCell('C'.$row)->getDataValidation();
            $studentStatusValidation->setType(DataValidation::TYPE_LIST);
            $studentStatusValidation->setErrorStyle(DataValidation::STYLE_STOP);
            $studentStatusValidation->setAllowBlank(true);
            $studentStatusValidation->setShowDropDown(true);
            $studentStatusValidation->setFormula1('DropdownData!$C$1:$C$'.count($studentStatuses));

            $genderValidation = $sheet->getCell('E'.$row)->getDataValidation();
            $genderValidation->setType(DataValidation::TYPE_LIST);
            $genderValidation->setErrorStyle(DataValidation::STYLE_STOP);
            $genderValidation->setAllowBlank(true);
            $genderValidation->setShowDropDown(true);
            $genderValidation->setFormula1('DropdownData!$E$1:$E$'.count($genders));

            $graduationYearValidation = $sheet->getCell('AX'.$row)->getDataValidation();
            $graduationYearValidation->setType(DataValidation::TYPE_LIST);
            $graduationYearValidation->setErrorStyle(DataValidation::STYLE_STOP);
            $graduationYearValidation->setAllowBlank(true);
            $graduationYearValidation->setShowDropDown(true);
            $graduationYearValidation->setFormula1('DropdownData!$AX$1:$AX$'.count($graduationYears));
        }

        // 5. Simpan file Excel yang sudah dimodifikasi
        $filePath = storage_path('app/public/templates/Template_Siswa.xlsx');
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        // 6. Kembalikan file untuk diunduh oleh pengguna
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function majorsTemplateDownload()
    {
        $templatePath = storage_path('app/public/templates/Template_Jurusan.xlsx');

        return response()->download($templatePath)->deleteFileAfterSend(true);
    }

    public function subjectsTemplateDownload()
    {
        // 1. Baca file template yang sudah ada
        $templatePath = storage_path('app/public/templates/Template_Mata_Pelajaran_Awal.xlsx');

        // Periksa apakah file ada
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }

        // Load template Excel
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // 2. Ambil data untuk dropdown dari database
        $subjectTypes = SubjectType::pluck('name')->toArray();

        // 3. Buat sheet baru untuk data dropdown
        $dropdownSheet = $spreadsheet->createSheet();
        $dropdownSheet->setTitle('DropdownData');

        // Isi data dropdown Jenis Mata Pelajaran
        foreach ($subjectTypes as $index => $class) {
            $dropdownSheet->setCellValue('A'.($index + 1), $class);
        }
        // 4. Tambahkan dropdown untuk seluruh kolom Kelas, Tahun Masuk, dan Jurusan hingga baris 1000
        for ($row = 2; $row <= 10000; ++$row) {
            $classValidation = $sheet->getCell('C'.$row)->getDataValidation();
            $classValidation->setType(DataValidation::TYPE_LIST);
            $classValidation->setErrorStyle(DataValidation::STYLE_STOP);
            $classValidation->setAllowBlank(true);
            $classValidation->setShowDropDown(true);
            $classValidation->setFormula1('DropdownData!$A$1:$A$'.count($subjectTypes));
        }

        // 5. Simpan file Excel yang sudah dimodifikasi
        $filePath = storage_path('app/public/templates/Template_Mata_Pelajaran.xlsx');
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        // 6. Kembalikan file untuk diunduh oleh pengguna
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function schoolClassesTemplateDownload()
    {
        // 1. Baca file template yang sudah ada
        $templatePath = storage_path('app/public/templates/Template_Kelas_Awal.xlsx');

        // Periksa apakah file ada
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }

        // Load template Excel
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // 2. Ambil data untuk dropdown dari database
        $majors = Major::pluck('name')->toArray();

        // 3. Buat sheet baru untuk data dropdown
        $dropdownSheet = $spreadsheet->createSheet();
        $dropdownSheet->setTitle('DropdownData');

        // Isi data dropdown Jenis Mata Pelajaran
        foreach ($majors as $index => $class) {
            $dropdownSheet->setCellValue('A'.($index + 1), $class);
        }
        // 4. Tambahkan dropdown untuk seluruh kolom Kelas, Tahun Masuk, dan Jurusan hingga baris 1000
        for ($row = 2; $row <= 10000; ++$row) {
            $classValidation = $sheet->getCell('B'.$row)->getDataValidation();
            $classValidation->setType(DataValidation::TYPE_LIST);
            $classValidation->setErrorStyle(DataValidation::STYLE_STOP);
            $classValidation->setAllowBlank(true);
            $classValidation->setShowDropDown(true);
            $classValidation->setFormula1('DropdownData!$A$1:$A$'.count($majors));
        }

        // 5. Simpan file Excel yang sudah dimodifikasi
        $filePath = storage_path('app/public/templates/Template_Kelas.xlsx');
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        // 6. Kembalikan file untuk diunduh oleh pengguna
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function studentGradesTemplateDownload(Student $student)
    {
        // Ambil data sesuai dengan logika yang sudah Anda buat
        $student = Student::with(['entryYear', 'major'])->findOrFail($student->id);

        $entryYearId = $student->entry_year_id;
        $majorId = $student->major_id;

        $subjects = Subject::whereHas('majors', function ($query) use ($majorId) {
            $query->where('major_id', $majorId);
        })
        ->whereHas('entryYears', function ($query) use ($entryYearId) {
            $query->where('entry_year_id', $entryYearId);
        })
        ->with(['grades' => function ($query) use ($student) {
            $query->where('student_id', $student->id);
        }])
        ->get();

        $semesters = Semester::all();

        // Buat data untuk export
        $data = [];
        foreach ($subjects as $key => $subject) {
            $row = [
                'subject_name' => $subject->name,
                'semesters' => [],
            ];

            foreach ($semesters as $semester) {
                $grade = $subject->grades->where('semester_id', $semester->id)->first();
                $row['semesters'][] = $grade ? $grade->score : '-';
            }

            $data[] = $row;
        }

        return Excel::download(new StudentGradesTemplateExport($data, $semesters), $student->nis.' '.$student->full_name.'.xlsx');
    }

    public function studentsGradesTemplateDownload($schoolClassId, $entryYearId)
    {
        $schoolClass = SchoolClass::where('id', $schoolClassId)->firstOrFail();
        $entryYear = EntryYear::where('id', $entryYearId)->firstOrFail();
        // Create a sanitized version of the filename
        $sanitizedClassName = Str::replace(['/', '\\'], '_', $schoolClass->name);
        $sanitizedEntryYear = Str::replace(['/', '\\'], '_', $entryYear->year);

        // Construct the filename
        $filename = 'Nilai Siswa '.$sanitizedEntryYear.' '.$sanitizedClassName.'.xlsx';

        // Return the download response
        return Excel::download(new SchoolClassStudentsGradesExport($schoolClassId, $entryYearId), $filename);
    }

    public function studentsGradesMajorTemplateDownload($majorId, $entryYearId)
    {
        $major = Major::where('id', $majorId)->firstOrFail();
        $entryYear = EntryYear::where('id', $entryYearId)->firstOrFail();

        return Excel::download(new MajorStudentsGradesExport($majorId, $entryYearId), 'Nilai Siswa Jurusan '.$major->short.' Tahun '.$entryYear->year.'.xlsx');
    }
}
