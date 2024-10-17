<?php

namespace App\Imports;

use App\Models\Major;
use App\Models\SchoolClass;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SchoolClassesImport implements ToCollection, WithHeadingRow, WithValidation, WithMultipleSheets
{
    public function rules(): array
    {
        return [
            // 'nama' => 'required|string|max:255',
            // 'jurusan' => 'required',
        ];
    }

    public function collection(Collection $rows)
    {
        $errors = [];

        foreach ($rows as $index => $row) {
            // Bersihkan kunci row
            $data = $row->mapWithKeys(function ($value, $key) {
                $key = strtolower(str_replace(' ', '_', $key));
                return [$key => $value];
            });

            if ($data->filter()->isEmpty()) {
                // Jika seluruh kolom kosong, lewati baris ini
                continue;
            }

            // Validasi baris
            $validator = Validator::make($data->toArray(), [
                'nama' => 'required|string|max:255|unique:school_classes,name',
                'jurusan' => 'required',
            ]);

            if ($validator->fails()) {
                // Simpan error bersama dengan index baris
                $errors[] = [
                    'index' => $index + 1, // Untuk membuat index bisa dibaca manusia (mulai dari 1)
                    'row' => $row, // Data baris spesifik
                    'errors' => $validator->errors()->all() // Error validasi
                ];
                continue; // Lewati baris jika validasi gagal
            }

            // Cari SchoolClass berdasarkan nama (cek apakah ada atau tidak)
            $schoolClass = SchoolClass::where('name', $data['nama'])->first();

            // Jika SchoolClass tidak ditemukan, buat yang baru
            SchoolClass::updateOrCreate(
                ['name' => $data['nama']],
                [
                    'name' => $data['nama'],
                    'major_id' => Major::where('name', $data['jurusan'])->value('id'),
                ]
            );
        }

        // Jika ada error, simpan ke session dan redirect kembali
        if (!empty($errors)) {
            return redirect()->back()
                ->with('bulk_errors', $errors) // Pass seluruh array errors
                ->withInput(); // Simpan input form
        }
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
}
