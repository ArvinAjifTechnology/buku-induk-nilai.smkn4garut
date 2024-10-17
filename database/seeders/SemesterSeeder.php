<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesters = [
            ['uniqid' => uniqid(), 'name' => 'Semester 1'],
            ['uniqid' => uniqid(), 'name' => 'Semester 2'],
            ['uniqid' => uniqid(), 'name' => 'Semester 3'],
            ['uniqid' => uniqid(), 'name' => 'Semester 4'],
            ['uniqid' => uniqid(), 'name' => 'Semester 5'],
            ['uniqid' => uniqid(), 'name' => 'Semester 6'],
        ];

        DB::table('semesters')->insert($semesters);
    }
}
