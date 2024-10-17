<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Semester;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StudentsExcelExport implements WithMultipleSheets
{
    protected $students;
    protected $subjects;
    protected $semesters;

    public function __construct($students, $subjects, $semesters)
    {
        $this->students = $students;
        $this->subjects = $subjects;
        $this->semesters = $semesters;
    }

    public function sheets(): array
    {
        return [
            new DetailSheet($this->students),
            new GradesSheet($this->students, $this->subjects, $this->semesters),
        ];
    }
}

class DetailSheet implements FromView, WithStyles
{
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function view(): View
    {
        return view('exports.students_detail', [
            'students' => $this->students,
        ]);
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
            $this->insertImages($sheet);
        }

        private function insertImages(Worksheet $sheet)
        {
            $row = 2; // Baris pertama untuk data siswa
            foreach ($this->students as $student) {
                if ($student->photo) {
                    $drawing = new Drawing();
                    $drawing->setName('Foto Siswa');
                    $drawing->setDescription('Foto Siswa ' . $student->full_name);
                    $drawing->setPath(public_path('storage/' . $student->photo)); // Pastikan path ini benar
                    $drawing->setHeight(90); // Atur tinggi gambar menjadi 20px
                    $drawing->setWidth(90);  // Atur lebar gambar menjadi 20px

                    // Atur posisi sel untuk gambar
                    $drawing->setCoordinates('B' . $row); // Sesuaikan dengan kolom yang Anda inginkan
                    $drawing->setWorksheet($sheet); // Menyisipkan gambar ke worksheet

                    // Mengatur sel B pada baris tertentu agar lebih besar jika diperlukan
                    $sheet->getRowDimension($row)->setRowHeight(90); // Atur tinggi baris
                    $sheet->getColumnDimension('B')->setWidth(90); // Atur lebar kolom
                }
                $row++;
            }
        }

}

class GradesSheet implements FromView, WithStyles
{
    protected $students;
    protected $subjects;
    protected $semesters;

    public function __construct($students, $subjects, $semesters)
    {
        $this->students = $students;
        $this->subjects = $subjects;
        $this->semesters = $semesters;
    }

    public function view(): View
    {
        return view('exports.students_grades', [
            'students' => $this->students,
            'subjects' => $this->subjects,
            'semesters' => $this->semesters,
        ]);
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
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => '3310E080'] // 20% transparency green color
            ]
        ]);
        $sheet->getStyle('A2:'.$highestColumn.'2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => '3310E080'] // 20% transparency green color
            ]
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
