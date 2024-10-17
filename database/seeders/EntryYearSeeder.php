<?php

namespace Database\Seeders;

use App\Models\EntryYear;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntryYearSeeder extends Seeder
{
    public function run()
    {
        $startYear = 1968;
        $currentYear = Carbon::now()->year;

        $years = range($startYear, $currentYear); // Adding 10 years into the future

        foreach ($years as $year) {
            EntryYear::updateOrCreate(
                ['year' => $year] // Fields to update or insert
            );
        }
    }
}
