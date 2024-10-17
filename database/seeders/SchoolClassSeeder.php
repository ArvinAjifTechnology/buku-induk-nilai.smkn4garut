<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    public function run()
    {
        $schoolClasses = [
            // Agribisnis Pengolahan Hasil Pertanian
            ['name' => 'APHP-1', 'major_id' => 1],
            ['name' => 'APHP-2', 'major_id' => 1],
            ['name' => 'APHP-3', 'major_id' => 1],

            // Agribisnis Tanaman
            ['name' => 'AGTAN-1', 'major_id' => 2],
            ['name' => 'AGTAN-2', 'major_id' => 2],
            ['name' => 'AGTAN-3', 'major_id' => 2],
            // ['name' => 'ATPH', 'major_id' => 2],p

            // Agribisnis Ternak
            ['name' => 'AGTER-1', 'major_id' => 3],
            ['name' => 'AGTER-2', 'major_id' => 3],
            // ['name' => 'ATR', 'major_id' => 3],

            // Desain Komunikasi Visual
            ['name' => 'DKV-1', 'major_id' => 4],
            ['name' => 'DKV-2', 'major_id' => 4],

            // Kimia Analisis
            ['name' => 'KA-1', 'major_id' => 5],
            ['name' => 'KA-2', 'major_id' => 5],
            ['name' => 'KA-3', 'major_id' => 5],
            // ['name' => 'APL-1', 'major_id' => 5],

            // Brodcasting dan Perfilman
            ['name' => 'BDP-1', 'major_id' => 6],
            ['name' => 'BDP-2', 'major_id' => 6],
            ['name' => 'BDP-3', 'major_id' => 6],
            ['name' => 'BDP-4', 'major_id' => 6],

            // Teknik Otomotif
            ['name' => 'TO-1', 'major_id' => 7],
            ['name' => 'TO-2', 'major_id' => 7],
            ['name' => 'TO-3', 'major_id' => 7],
            ['name' => 'TO-4', 'major_id' => 7],
            ['name' => 'TKR-1', 'major_id' => 7],

            // Kehutanan
            ['name' => 'KHU-1', 'major_id' => 8],
            ['name' => 'KHU-2', 'major_id' => 8],
            ['name' => 'KHU-3', 'major_id' => 8],
            ['name' => 'TRRH-1', 'major_id' => 8],

            // Agribisnis Tanaman Pangan Dan Holtikultura
            ['name' => 'ATPH', 'major_id' => 9],

            // Agribisnis Tanaman Perkebunan
            ['name' => 'ATP', 'major_id' => 10],

            // Agribisnis Pemuliaan Tanaman
            ['name' => 'APT', 'major_id' => 11],

            // Agribisnis Ternak Ruminansia
            ['name' => 'ATR', 'major_id' => 12],

            // Agribisnis Ternak Unggas
            ['name' => 'ATU', 'major_id' => 13],

            // Analisis Pengujian Lab
            ['name' => 'APL-2', 'major_id' => 14],

            // Animasi
            ['name' => 'ANI-1', 'major_id' => 15],

            // Teknik Kendaraan Ringan Otomotif
            ['name' => 'TKR-2', 'major_id' => 16],

            // Teknik Reklamasi Dan Rehabilitasi Hutan
            ['name' => 'TRRH-2', 'major_id' => 17],

        ];

        foreach ($schoolClasses as $schoolClass) {
            SchoolClass::create($schoolClass);
        }
    }
}
