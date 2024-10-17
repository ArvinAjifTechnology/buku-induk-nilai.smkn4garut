<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\Student;

class GradesImport implements ToCollection
{
    protected $student;

    public function __construct($student)
    {
        $this->student = $student;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Asumsi kolom 1 adalah nama subjek, kolom 2-7 adalah nilai untuk semester 1-6
            $subjectName = $row[1]; // Nama mata pelajaran

            $subject = Subject::where('name', $subjectName)->first();

            if ($subject) {
                // Iterasi melalui kolom yang mewakili semester
                for ($i = 2; $i <= 7; $i++) {
                    $semesterId = $i - 1; // Semester ID (1, 2, 3, dst.)
                    $score = $row[$i]; // Nilai untuk semester tersebut

                    if ($score !== null) {
                        Grade::updateOrCreate(
                            [
                                'student_id' => Student::where('id', $this->student)->value('id'),
                                'subject_id' => $subject->id,
                                'semester_id' => $semesterId,
                            ],
                            [
                                'score' => $score,
                            ]
                        );
                    }
                }
            }
        }
    }
}
