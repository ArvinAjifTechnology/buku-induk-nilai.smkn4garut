<?php

namespace App\Imports;

use App\Models\Subject;
use App\Models\SubjectType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SubjectsImport implements ToCollection, WithHeadingRow, WithValidation, WithMultipleSheets
{
    // Aturan validasi untuk import
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255|unique:subjects,name',
            'jenis_mata_pelajaran' => 'required',
            'singkatan' => 'required|string|max:10|unique:subjects,short',
            'deskripsi' => 'nullable|string',
        ];
    }

    public function collection(Collection $rows)
    {
        $errors = [];
        foreach ($rows as $index =>$row) {
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
            $validator = \Validator::make($data->toArray(), [
                'nama' => 'required|string|max:255|unique:subjects,name',
                'jenis_mata_pelajaran' => 'required',
                'singkatan' => 'required|string|max:10|unique:subjects,short',
                'deskripsi' => 'nullable|string',
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

            // Buat atau update subject
            Subject::updateOrCreate(
                ['short' => $data['singkatan']],
                [
                    'name' => $data['nama'],
                    'subject_type_id' => SubjectType::where('name', $data['jenis_mata_pelajaran'])->value('id'),
                    'short' => $data['singkatan'],
                    'description' => $data['deskripsi'],
                ]
            );

            \Log::info('Successfully processed row: ' . json_encode($data->toArray()));
             // Jika ada error, simpan ke session dan redirect kembali
            if (!empty($errors)) {
                return redirect()->back()
                    ->with('bulk_errors', $errors) // Pass seluruh array errors
                    ->withInput(); // Simpan input form
            }
        }
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
}
