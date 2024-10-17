
<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\Grade;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class StudentsGradesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Pastikan kolom yang Anda gunakan sesuai dengan file Excel Anda
            $nis = $row['nis'];
            $nisn = $row['nisn'];
            $class = $row['kelas'];
            $major = $row['jurusan'];
            $name = $row['nama'];

            $student = Student::where('nis', $nis)->first();

            if (!$student) {
                // Student tidak ditemukan, lanjutkan ke baris berikutnya
                continue;
            }

            // Ambil semua subjects dan semesternya
            $subjects = Subject::all();
            $semesters = Semester::all();

            $subjectHeaders = array_keys($row->toArray());

            foreach ($subjects as $subject) {
                $subjectName = $subject->name;

                // Cek apakah subject name ada di header
                $subjectIndex = array_search($subjectName, $subjectHeaders);

                if ($subjectIndex !== false) {
                    for ($semesterIndex = 1; $semesterIndex <= 6; $semesterIndex++) {
                        $semester = $semesters->find($semesterIndex);

                        if (!$semester) {
                            continue;
                        }

                        $dataIndex = $subjectIndex + ($semesterIndex - 1);

                        $score = isset($row[$dataIndex]) ? $row[$dataIndex] : 0;
                            Grade::updateOrCreate(
                                [
                                    'student_id' => $student->id,
                                    'subject_id' => $subject->id,
                                    'semester_id' => $semester->id,
                                ],
                                ['score' => $score]
                            );
                    }
                }
            }
        }
    }
}
