<?php

namespace App\Imports;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Semester;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class GradesImport implements ToCollection
{
    private $semester_id;

    public function __construct()
    {
        $this->semester_id = null; // Untuk menyimpan semester saat ini.
    }

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        // Ambil informasi kelas dan tahun pelajaran dari baris yang sesuai
        $class = $rows[2][1]; // Kelas pada baris ke-3
        $academicYearInfo = explode(' ', $rows[3][1]); // Tahun Pelajaran pada baris ke-4
        // dd($class);
        $yearRange = explode('/', $academicYearInfo[0]); // ["2024", "2025"]
        $academicSemester = strtolower($academicYearInfo[1]); // "ganjil" atau "genap"

        // Tentukan semester ID berdasarkan kelas dan semester
        $this->semester_id = $this->getSemesterId($class, $academicSemester);

        // Ambil semua mata pelajaran dari database
        $subjects = Subject::all();

        // Buat peta antara header dan subject ID
        $subjectIndex = $this->mapSubjectIndex($rows[6]->toArray(), $subjects);

        // Loop setiap baris data siswa mulai dari baris ke-8
        foreach ($rows as $index => $row) {
            if ($index < 7) continue; // Lewati header dan metadata

            $nisn = $row[2]; // Ambil NISN dari kolom yang sesuai (indeks 2)
            $student = Student::where('nisn', $nisn)->first(); // Mencari siswa berdasarkan NISN

            if ($student) {
                foreach ($subjectIndex as $subjectId => $columnIndex) {
                    $score = $row[$columnIndex] ?? 0; // Nilai default 0 jika kosong

                    // Validasi nilai harus antara 1 dan 100
                    if ($score < 1 || $score > 100) {
                        throw new \Exception(
                            "Nilai tidak valid pada baris " . ($index + 1) .
                                " untuk siswa {$student->full_name} pada mata pelajaran ID {$subjectId}. Nilai: {$score}"
                        );
                    }

                    // Simpan atau perbarui nilai di database
                    Grade::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'subject_id' => $subjectId,
                            'semester_id' => $this->semester_id,
                        ],
                        ['score' => $score]
                    );
                }
            }
        }
    }

    /**
     * Fungsi untuk memetakan header Excel dengan ID subject.
     */
    private function mapSubjectIndex(array $headers, $subjects)
    {
        $subjectIndex = [];

        foreach ($headers as $index => $header) {
            foreach ($subjects as $subject) {
                if (strpos(strtolower($header), strtolower($subject->name)) !== false) {
                    $subjectIndex[$subject->id] = $index;
                }
            }
        }

        return $subjectIndex;
    }

    /**
     * Fungsi untuk mencari semester ID berdasarkan kelas dan jenis semester.
     */
    private function getSemesterId(string $class, string $academicSemester)
    {
        // Tentukan semester berdasarkan kelas dan semester ganjil/genap
        $semesterNumber = 0;

        if (strpos($class, '10') !== false) {
            $semesterNumber = ($academicSemester === 'ganjil') ? 1 : 2;
        } elseif (strpos($class, '11') !== false) {
            $semesterNumber = ($academicSemester === 'ganjil') ? 3 : 4;
        } elseif (strpos($class, '12') !== false) {
            $semesterNumber = ($academicSemester === 'ganjil') ? 5 : 6;
        }

        // Sesuaikan nama semester
        $semesterName = "Semester {$semesterNumber}";

        // Cari semester berdasarkan nama di database
        $semester = Semester::where('name', $semesterName)->first();

        if (!$semester) {
            throw new \Exception("Semester dengan nama '{$semesterName}' tidak ditemukan.");
        }

        return $semester->id;
    }
}
