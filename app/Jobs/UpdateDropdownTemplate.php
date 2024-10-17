<?php

namespace App\Jobs;

use App\Exports\DropdownDataExport;
use Maatwebsite\Excel\Facades\Excel;

class UpdateDropdownTemplate extends Job
{
    public function handle()
    {
        // Generate template dengan data terbaru
        Excel::store(new DropdownDataExport(), 'public/templates/dropdown_data.xlsx');
    }
}
