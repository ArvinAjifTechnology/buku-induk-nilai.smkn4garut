<?php

namespace App\Exports;

use App\Models\EntryYear;
use App\Models\Major;
use App\Models\SchoolClass;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Facades\Excel;

class DropdownDataExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Majors' => new class(Major::all()->pluck('name')->toArray()) implements FromArray {
                protected $data;

                public function __construct(array $data)
                {
                    $this->data = $data;
                }

                public function array(): array
                {
                    return array_map(fn ($item) => [$item], $this->data);
                }
            },
            'SchoolClass' => new class(SchoolClass::all()->pluck('name')->toArray()) implements FromArray {
                protected $data;

                public function __construct(array $data)
                {
                    $this->data = $data;
                }

                public function array(): array
                {
                    return array_map(fn ($item) => [$item], $this->data);
                }
            },
            'EntryYears' => new class(EntryYear::all()->pluck('year')->toArray()) implements FromArray {
                protected $data;

                public function __construct(array $data)
                {
                    $this->data = $data;
                }

                public function array(): array
                {
                    return array_map(fn ($item) => [$item], $this->data);
                }
            },
        ];
    }
}
Excel::store(new DropdownDataExport(), 'public/templates/dropdown_data.xlsx');
