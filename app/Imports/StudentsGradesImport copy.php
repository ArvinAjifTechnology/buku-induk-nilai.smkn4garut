<?php

namespace App\Imports;

use App\Models\Grade;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsGradesImportCopy implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
{
    // Ambil baris header
    $headerRow = $rows->shift()->toArray();
    Log::info('Header Row: '.print_r($headerRow, true));

    // Ambil nama-nama subjek mulai dari kolom ke-6
    $subjectHeaders = array_slice($headerRow, 6);
    Log::info('Subject Headers: '.print_r($subjectHeaders, true));

    $subjectNames = [];
    $subjectIndices = [];

    $currentSubjectName = '';

    foreach ($subjectHeaders as $key => $value) {
        if (is_string($value) && !empty($value)) {
            $currentSubjectName = $value;
            $subjectNames[$value] = $key;
            $subjectIndices[$value] = [];
        } elseif (is_numeric($value)) {
            $subjectIndices[$currentSubjectName][] = $key;
        }
    }

    Log::info('Subject Names Mapping: '.print_r($subjectNames, true));
    Log::info('Subject Indices Mapping: '.print_r($subjectIndices, true));

    $allSubjects = Subject::pluck('id', 'name')->toArray();
    Log::info('All Subjects: '.print_r($allSubjects, true));

    foreach ($rows as $row) {
        $student = Student::where('nis', $row['nis'])->first();
        if (!$student) {
            Log::info('Student not found for NIS: '.$row['nis']);
            continue;
        }

        foreach ($subjectNames as $subjectName => $startIndex) {
            $normalizedSubjectName = str_replace(['_', '-'], ' ', $subjectName);
            $subject = Subject::where('name', 'LIKE', '%' . $normalizedSubjectName . '%')->first();
            if (!$subject) {
                Log::info('Subject not found: '.$subjectName);
                continue;
            }


            $subjectId = $subject->id;

            foreach ($subjectIndices[$subjectName] as $semesterIndex => $dataIndex) {
                if (isset($row[$dataIndex])) {
                    $semester = $allSemesters->get($semesterIndex + 1);
                    Log::info('Inserting/Updating grade for NIS: '.$row['nis'].', Subject: '.$subjectName.', Semester: '.$semester->name.', Score: '.$row[$dataIndex]);
                    Grade::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'subject_id' => $subjectId,
                            'semester_id' => $semester->id,
                        ],
                        ['score' => $row[$dataIndex]]
                    );
                } else {
                    Log::warning('Data not found at index: '.$dataIndex.' for NIS: '.$row['nis']);
                }
            }
        }
    }
}


}
