<?php

namespace App\Exports;

use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SchoolClassStudentsGradesExport implements FromView, WithStyles
{
    protected $schoolClassId;
    protected $entryYearId;

    public function __construct($schoolClassId, $entryYearId)
    {
        $this->schoolClassId = $schoolClassId;
        $this->entryYearId = $entryYearId;
    }

    public function view(): View
    {
        // Retrieve students filtered by school class and entry year
        $students = Student::where('school_class_id', $this->schoolClassId)
            ->where('entry_year_id', $this->entryYearId)
            ->with(['entryYear', 'major', 'schoolClass', 'grades.subject', 'grades.semester'])
            ->get();

        // Retrieve subjects and semesters
        $majorId = $students->first()->major_id ?? null;
        $entryYearId = $students->first()->entryYear->id ; // Assuming all students in the same class have the same major
        $subjects = Subject::whereExists(function ($query) use ($majorId, $entryYearId) {
            $query->select(DB::raw(1))
                  ->from('major_subjects')
                  ->where('major_subjects.entry_year_id', $entryYearId)
                  ->join('majors', 'major_subjects.major_id', '=', 'majors.id')
                  ->whereColumn('subjects.id', 'major_subjects.subject_id')
                  ->where('majors.id', $majorId);
        })->get();

        $semesters = Semester::all();

        return view('exports.students_grades', compact('students', 'subjects', 'semesters'));
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->freezePane('G3');
        // Mengatur lebar kolom
        $this->setColumnWidths($sheet);

        // Menambahkan style pada header
        $highestColumn = $sheet->getHighestColumn();
        $sheet->getStyle('A1:'.$highestColumn.'1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
    }

    // Metode privat untuk mengatur lebar kolom
    private function setColumnWidths(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(5);   // Kolom No
        $sheet->getColumnDimension('B')->setWidth(15);  // Kolom NIS
        $sheet->getColumnDimension('C')->setWidth(15);  // Kolom NISN
        $sheet->getColumnDimension('D')->setWidth(20);  // Kolom Kelas
        $sheet->getColumnDimension('E')->setWidth(10);  // Kolom Jurusan
        $sheet->getColumnDimension('F')->setWidth(40);  // Kolom Nama

        // Atur lebar kolom untuk kolom lainnya jika diperlukan
        // Misalnya, jika kolom lebih dari F, sesuaikan lebar kolom di sini.
    }

    // Metode privat untuk mengubah kolom dari format Excel (misalnya 'AA') menjadi indeks numerik
    private function excelColumnToIndex($column)
    {
        $column = strtoupper($column);
        $length = strlen($column);
        $index = 0;
        for ($i = 0; $i < $length; ++$i) {
            $index = $index * 26 + (ord($column[$i]) - ord('A') + 1);
        }
        return $index;
    }

    // Metode privat untuk mengubah indeks numerik menjadi format Excel (misalnya 27 menjadi 'AA')
    private function indexToExcelColumn($index)
    {
        $column = '';
        while ($index > 0) {
            --$index;
            $column = chr($index % 26 + ord('A')) . $column;
            $index = intval($index / 26);
        }
        return $column;
    }
}
