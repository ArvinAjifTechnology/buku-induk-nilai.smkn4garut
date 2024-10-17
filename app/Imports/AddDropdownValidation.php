<?php

namespace App\Imports;

use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class AddDropdownValidation
{
    public function handle()
    {
        // Load existing file
        $spreadsheet = Excel::toPHPExcel('public/templates/Template Siswa.xlsx');

        // Access the sheets
        $sheet = $spreadsheet->getActiveSheet();
        $dropdownSheet = $spreadsheet->getSheetByName('DropdownData');

        // Add dropdown validation
        $dropdownSheet->getCell('A1')->setValue('Dropdown data here'); // Example
        $validation = $sheet->getCell('A1')->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setFormula1('\'DropdownData\'!$A$1:$A$10');
        $validation->setAllowBlank(true);
        $validation->setShowDropDown(true);

        // Save the modified file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('public/templates/template_with_validation.xlsx');
    }
}
