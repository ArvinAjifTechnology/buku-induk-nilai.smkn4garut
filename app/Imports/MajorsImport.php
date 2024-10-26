<?php

namespace App\Imports;

use App\Models\Major;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MajorsImport implements ToCollection, WithHeadingRow, WithValidation
{
    // Aturan validasi untuk import
    public function rules(): array
    {
        return [
            // 'nama' => 'required|string|max:255',
            // 'singkatan' => 'required|string|max:10',
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

            // Validasi manual
            $validator = Validator::make($data->toArray(), [
                'nama' => 'required|string|max:255|unique:majors,name',
                'singkatan' => 'required|string|max:10|unique:majors,short',
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

            // Buat atau update major
            Major::updateOrCreate(
                ['short' => $data['singkatan']],
                [
                    'name' => $data['nama'],
                    'short' => $data['singkatan'],
                ]
            );

            Log::info('Successfully processed row: ' . json_encode($data->toArray()));
        }

        // Jika ada error, simpan ke session dan redirect kembali setelah loop selesai
        if (!empty($errors)) {
            return redirect()->back()
                ->with('bulk_errors', $errors) // Pass seluruh array errors
                ->withInput(); // Simpan input form
        }
    }
}
