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

class MajorStudentsGradesExport implements FromView, WithStyles
{
    protected $majorId;
    protected $entryYearId;

    public function __construct($majorId, $entryYearId)
    {
        $this->majorId = $majorId;
        $this->entryYearId = $entryYearId;
    }

    public function view(): View
    {
        // Retrieve students filtered by major and entry year, ordered by class
        $students = Student::where('students.major_id', $this->majorId)
                ->where('students.entry_year_id', $this->entryYearId)
                ->orderBy('school_class_id', 'asc')
                ->join('school_classes', 'students.school_class_id', '=', 'school_classes.id')
                ->with(['entryYear', 'major', 'schoolClass', 'grades.subject', 'grades.semester'])
                ->orderBy('school_classes.name')
                ->select('students.*')  // Ensure only columns from the students table are selected
                ->get();

        // Retrieve subjects linked to the major
        $subjects = Subject::whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('major_subjects')
                  ->where('major_subjects.entry_year_id', $this->entryYearId)
                  ->whereColumn('subjects.id', 'major_subjects.subject_id')
                  ->where('major_subjects.major_id', $this->majorId);
        })->get();

        $semesters = Semester::all();

        return view('exports.students_grades', compact('students', 'subjects', 'semesters'));
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->freezePane('G3');
        $this->setColumnWidths($sheet);

        // Apply header styling
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

    private function setColumnWidths(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(5);   // No
        $sheet->getColumnDimension('B')->setWidth(15);  // NIS
        $sheet->getColumnDimension('C')->setWidth(15);  // NISN
        $sheet->getColumnDimension('D')->setWidth(20);  // Kelas
        $sheet->getColumnDimension('E')->setWidth(10);  // Jurusan
        $sheet->getColumnDimension('F')->setWidth(40);  // Nama
        // Additional column widths as needed for grades
    }

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

    private function indexToExcelColumn($index)
    {
        $column = '';
        while ($index > 0) {
            --$index;
            $column = chr($index % 26 + ord('A')).$column;
            $index = intval($index / 26);
        }

        return $column;
    }
}
