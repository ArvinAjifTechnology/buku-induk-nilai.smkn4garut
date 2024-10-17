<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['short' => 'PAI', 'name' => 'Pendidikan Agama Islam dan Budi Pekerti', 'subject_type_id' => 1],
            ['short' => 'PP', 'name' => 'Pendidikan Pancasila', 'subject_type_id' => 1],
            ['short' => 'BI', 'name' => 'Bahasa Indonesia', 'subject_type_id' => 1],
            ['short' => 'PJOK', 'name' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'subject_type_id' => 1],
            ['short' => 'SEJ', 'name' => 'Sejarah', 'subject_type_id' => 1],
            ['short' => 'SB', 'name' => 'Seni Budaya', 'subject_type_id' => 1],
            ['short' => 'MAT', 'name' => 'Matematika', 'subject_type_id' => 1],
            ['short' => 'BING', 'name' => 'Bahasa Inggris', 'subject_type_id' => 1],
            ['short' => 'INF', 'name' => 'Informatika', 'subject_type_id' => 1],
            ['short' => 'IPAS', 'name' => 'Projek Ilmu Pengetahuan Alam dan Sosial', 'subject_type_id' => 1],
            ['short' => 'BS', 'name' => 'Bahasa Sunda', 'subject_type_id' => 1],
            ['short' => 'BK', 'name' => 'Bimbingan Konseling', 'subject_type_id' => 1],
            ['short' => 'PKWU', 'name' => 'Projek Kreatif dan Kewirausahaan', 'subject_type_id' => 1],
            ['short' => 'DDATAN', 'name' => 'Dasar-Dasar Agribisnis Tanaman', 'subject_type_id' => 2],
            ['short' => 'DDATER', 'name' => 'Dasar-Dasar Agribisnis Ternak', 'subject_type_id' => 2],
            ['short' => 'DDAPHP', 'name' => 'Dasar-Dasar Agriteknologi Pengolahan Hasil Pertanian', 'subject_type_id' => 2],
            ['short' => 'DDA', 'name' => 'Dasar-Dasar Animasi', 'subject_type_id' => 2],
            ['short' => 'DDDKV', 'name' => 'Dasar-Dasar Desain Komunikasi Visual', 'subject_type_id' => 2],
            ['short' => 'DDK', 'name' => 'Dasar-Dasar Kehutanan', 'subject_type_id' => 2],
            ['short' => 'DDKA', 'name' => 'Dasar-Dasar Kimia Analisis', 'subject_type_id' => 2],
            ['short' => 'DDKTR', 'name' => 'Dasar-Dasar Teknik Kendaraan Ringan', 'subject_type_id' => 2],
            ['short' => 'DMI', 'name' => 'Desain Media Interaktif', 'subject_type_id' => 2],
            ['short' => 'BARISTA', 'name' => 'Mapel Pilihan : APHP BRISTA', 'subject_type_id' => 2],
            ['short' => 'MPAAT', 'name' => 'Mapel Pilihan : Agribisnis Pembibitan dan Kultur Jaringan', 'subject_type_id' => 2],
            ['short' => 'MPATPH', 'name' => 'Mapel Pilihan : Agribisnis Aneka Ternak', 'subject_type_id' => 2],
            ['short' => 'MPTKR', 'name' => 'Mapel Pilihan : Teknik Kendaraan Ringan', 'subject_type_id' => 2],
            ['short' => 'MPDMI', 'name' => 'Mapel Pilihan : Multimedia', 'subject_type_id' => 2],
            ['short' => 'MPPL', 'name' => 'Mapel Pilihan : Pengelolaan Laboratorium', 'subject_type_id' => 2],
            ['short' => 'AGFTRY', 'name' => 'Mapel pilihan : Agroforestry', 'subject_type_id' => 2],
            ['short' => 'KAPHP', 'name' => 'Konsentrasi Agribisnis Pengolahan Hasil Pertanian', 'subject_type_id' => 2],
            ['short' => 'PPHHB', 'name' => 'Produksi Pengolahan Hasil Perkebunan dan Herbal', 'subject_type_id' => 2],
            ['short' => 'PPHN', 'name' => 'Produksi Pengolahan Hasil Nabati', 'subject_type_id' => 2],
            ['short' => 'PPHHN', 'name' => 'Produksi Pengolahan Hasil Hewani', 'subject_type_id' => 2],
            ['short' => 'MPBARST', 'name' => 'Mata pelajaran Pilihan (Kebaristaan)', 'subject_type_id' => 2],
            ['short' => 'KAGTAN', 'name' => 'Konsentrasi Agribisnis Pertanian', 'subject_type_id' => 2],
            ['short' => 'ATBH', 'name' => 'Agribisnis Tanaman Buah', 'subject_type_id' => 2],
            ['short' => 'ATPNG', 'name' => 'Agribisnis Tanaman Pangan', 'subject_type_id' => 2],
            ['short' => 'ATSR', 'name' => 'Agribisnis Tanaman Sayuran', 'subject_type_id' => 2],
            ['short' => 'ATHS', 'name' => 'Agribisnis Tanaman Hias', 'subject_type_id' => 2],
            ['short' => 'APKJT', 'name' => 'Agribisnis Pembibitan dan Kultur Jaringan Tanaman', 'subject_type_id' => 2],
            ['short' => 'PPTP', 'name' => 'Persiapan lahan perkebunan', 'subject_type_id' => 2],
            ['short' => 'PNTNKBN', 'name' => 'Penananaman tanaman perkebunan', 'subject_type_id' => 2],
            ['short' => 'PELPKBN', 'name' => 'Pemeliharaan dan pengelolaan tanaman perkebunan', 'subject_type_id' => 2],
            ['short' => 'PMB', 'name' => 'Pengujian Mutu Benih', 'subject_type_id' => 2],
            ['short' => 'PPT', 'name' => 'Pemuliaan Tanaman', 'subject_type_id' => 2],
            ['short' => 'FT', 'name' => 'Fisiologi tumbuhan', 'subject_type_id' => 2],
            ['short' => 'PPPTPKBN', 'name' => 'Panen dan pasca panen tanaman perkebunan', 'subject_type_id' => 2],
            ['short' => 'PROPPBT', 'name' => 'Produksi, Pengolahan dan Pemasaran Benih Tanaman', 'subject_type_id' => 2],
            ['short' => 'KATR', 'name' => 'Konsentrasi Agribisnis Ternak Ruminansia', 'subject_type_id' => 2],
            ['short' => 'KATU', 'name' => 'Konsentrasi Agribisnis Ternak Unggas', 'subject_type_id' => 2],
            ['short' => 'KTKR', 'name' => 'Konsentrasi Teknik Kendaraan Ringan', 'subject_type_id' => 2],
            ['short' => 'PKKR', 'name' => 'Pemeliharaan Kelistrikan Kendaraan Ringan', 'subject_type_id' => 2],
            ['short' => 'PMKR', 'name' => 'Pemeliharaan Mesin Kendaraan Ringan', 'subject_type_id' => 2],
            ['short' => 'PCSPT', 'name' => 'Pemeliharaan Chasis dan Pemindah Tenaga', 'subject_type_id' => 2],
            ['short' => 'KAPL', 'name' => 'Konsentrasi Analisis Pengujian Labolatorium', 'subject_type_id' => 2],
            ['short' => 'PROKSIMAT', 'name' => 'Analisis Pengujian Labolatorium (Proksimat)', 'subject_type_id' => 2],
            ['short' => 'MIKRO', 'name' => 'Analisis Pengujian Labolatorium (mikro)', 'subject_type_id' => 2],
            ['short' => 'ATG', 'name' => 'Analisis Pengujian Labolatorium (ATG)', 'subject_type_id' => 2],
            ['short' => 'AKI', 'name' => 'Analisis Pengujian Labolatorium (AKI)', 'subject_type_id' => 2],
            ['short' => 'TSAMPLING', 'name' => 'Analisis Pengujian Labolatorium (teknik sampling)', 'subject_type_id' => 2],
            ['short' => 'ANORGNK', 'name' => 'Analisis Pengujian Labolatorium (anorganik)', 'subject_type_id' => 2],
            ['short' => 'EKOHBTP', 'name' => 'Ekowisata & Pembinaan Habitat dan populasi', 'subject_type_id' => 2],
            ['short' => 'PWHKTA', 'name' => 'Pembukaan Wilayah Hutan (PWH), Pemanenan Hasil Hutan (PHH), Pengujian dan Penatausahaan Hasil Hutan, KTA', 'subject_type_id' => 2],
            ['short' => 'PEMT/SIG', 'name' => 'Pengukuran dan Pemetaan Hutan, penerapan SIG di bidang kehutanan, Inventarisasi Sumber Daya Hutan dan Sosial Budaya', 'subject_type_id' => 2],
            ['short' => 'TRRH', 'name' => 'Produksi benih dan bibit tanaman hutan, TRRH', 'subject_type_id' => 2],
            ['short' => 'IKH', 'name' => 'Identifikasi keanekaragama hayati', 'subject_type_id' => 2],
            ['short' => 'DPB', 'name' => 'Desain Publikasi', 'subject_type_id' => 2],
            ['short' => 'KGF', 'name' => 'Komputer Grafis', 'subject_type_id' => 2],
            ['short' => 'FTG', 'name' => 'Fotography', 'subject_type_id' => 2],
            ['short' => 'VIDG', 'name' => 'Videography', 'subject_type_id' => 2],
            ['short' => 'KANIM', 'name' => 'Konsentrasi Animasi', 'subject_type_id' => 2],
            ['short' => 'MP DKV', 'name' => 'MAPEL : DKV', 'subject_type_id' => 2],
            ['short' => 'PLHP', 'name' => 'Pengelolaan Limbah Hasil Pertanian', 'subject_type_id' => 2],
        ];

        foreach ($subjects as $subject) {
           Subject::create([
                'name' => $subject['name'],
                'subject_type_id' => $subject['subject_type_id'],
                'short' => $subject['short'],
                'description' => $subject['description'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
