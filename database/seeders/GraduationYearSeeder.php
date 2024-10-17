<?php

namespace Database\Seeders;

use App\Models\GraduationYear;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GraduationYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startYear = 1968;
        $currentYear = Carbon::now()->year;

        $years = range($startYear, $currentYear); // Adding 10 years into the future

        foreach ($years as $year) {
            GraduationYear::updateOrCreate(
                ['year' => $year] // Fields to update or insert
            );
        }
    }
}
