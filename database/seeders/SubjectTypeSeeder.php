<?php

namespace Database\Seeders;

use App\Models\SubjectType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjectTypes = [
            ['name' => 'Muatan Nasional'],
            ['name' => 'Muatan Peminatan Kejuruan'],
        ];

        foreach ($subjectTypes as $type) {
            SubjectType::create($type);
        }
    }
}
