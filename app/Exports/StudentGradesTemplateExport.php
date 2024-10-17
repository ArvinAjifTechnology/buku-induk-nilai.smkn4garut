<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentGradesTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    protected $data;
    protected $semesters;

    public function __construct($data, $semesters)
    {
        // Convert data to Collection if it is not already
        $this->data = $data instanceof Collection ? $data : collect($data);
        $this->semesters = $semesters;
    }

    public function array(): array
    {
        return $this->data->map(function ($item, $key) {
            $semesters = is_array($item['semesters']) ? array_map(function ($score) {
                return $score === '-' ? '' : $score;
            }, $item['semesters']) : [];

            return array_merge([($key +1),$item['subject_name']], $semesters);
        })->toArray();
    }

    public function headings(): array
    {
        return array_merge(['No', 'Mata Pelajaran'], $this->semesters->pluck('name')->toArray());
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Set header row font style
            1 => ['font' => ['bold' => true, 'size' => 12]],
            // Set border around the table
            'A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow() => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 60,
            'C' => 13,
            'D' => 13,
            'E' => 13,
            'F' => 13,
            'G' => 13,
            'H' => 13,
        ];
    }


}
