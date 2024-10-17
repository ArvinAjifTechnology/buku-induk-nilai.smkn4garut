<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    public function run()
    {
        $majors = [
            ['name' => 'Agribisnis Pengolahan Hasil Pertanian', 'short' => 'APHP'],
            ['name' => 'Agribisnis Tanaman', 'short' => 'AGTAN'],
            ['name' => 'Agribisnis Ternak', 'short' => 'AGTER'],
            ['name' => 'Desain Komunikasi Visual', 'short' => 'DKV'],
            ['name' => 'Kimia Analisis', 'short' => 'KA'],
            ['name' => 'Brodcasting dan Perfilman', 'short' => 'BDP'],
            ['name' => 'Teknik Otomotif', 'short' => 'TO'],
            ['name' => 'Kehutanan', 'short' => 'KHU'],
            ['name' => 'Agribisnis Tanaman Pangan Dan Holtikultura', 'short' => 'ATPH'],
            ['name' => 'Agribisnis Tanaman Perkebunan', 'short' => 'ATP'],
            ['name' => 'Agribisnis Pemuliaan Tanaman', 'short' => 'APT'],
            ['name' => 'Agribisnis Ternak Ruminansia', 'short' => 'ATR'],
            ['name' => 'Agribisnis Ternak Unggas', 'short' => 'ATU'],
            ['name' => 'Analisis Pengujian Lab', 'short' => 'APL'],
            ['name' => 'Animasi', 'short' => 'ANI'],
            ['name' => 'Teknik Kendaraan Ringan Otomotif', 'short' => 'TKR'],
            ['name' => 'Teknik Reklamasi Dan Rehabilitasi Hutan', 'short' => 'TRRH'],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }
    }
}
