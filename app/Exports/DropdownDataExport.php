<?php

namespace App\Exports;

use App\Models\EntryYear;
use App\Models\Major;
use App\Models\SchoolClass;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class DropdownDataExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new DropdownSheet('Jurusan', Major::pluck('name')->toArray()),
            new DropdownSheet('Kelas', SchoolClass::pluck('name')->toArray()),
            new DropdownSheet('Tahun Masuk', EntryYear::pluck('year')->toArray()),
        ];
    }
}

class DropdownSheet implements FromArray, WithTitle
{
    private $title;
    private $data;

    public function __construct($title, $data)
    {
        $this->title = $title;
        $this->data = $data;
    }

    public function array(): array
    {
        return array_map(fn ($item) => [$item], $this->data);
    }

    public function title(): string
    {
        return $this->title;
    }
}
