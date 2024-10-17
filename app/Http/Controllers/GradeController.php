<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    protected $students;
    protected $subjects;
    protected $semesters;

    public function __construct()
    {
        $this->students = Student::all();
        $this->subjects = Subject::all();
        $this->semesters = Semester::all();
    }

    public function index()
    {
        $schoolClasses = SchoolClass::with('major', 'students')->get();
        $grades = Grade::all();

        return view('grades.index', compact('grades', 'schoolClasses'));
    }

    public function create()
    {
        // dd($this->students);
        return view('grades.create', [
            'students' => $this->students,
            'subjects' => $this->subjects,
            'semesters' => $this->semesters,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'grades.*.student_id' => 'required|exists:students,id',
            'grades.*.subject_id' => 'required|exists:subjects,id',
            'grades.*.semester_id' => 'required|exists:semesters,id',
            'grades.*.score' => 'required|numeric|min:0|max:100', // Adjust min and max as needed
        ];

        // Create validator
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $grades = $request->input('grades');

        foreach ($grades as $grade) {
            // Ensure that student_id is the same
            $studentId = $grade['student_id'];

            // Update or create Grade record
            Grade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $grade['subject_id'],
                    'semester_id' => $grade['semester_id'],
                ],
                [
                    'score' => $grade['score'],
                ]
            );
        }

        return redirect()->route('grades.index')
                         ->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function show(SchoolClass $schoolClass)
    {
        // $schoolClass->load('students', 'major');

        return view('grades.show', compact('schoolClass'));
    }

    public function edit(Grade $grade)
    {
        return view('grades.edit', [
            'students' => $this->students,
            'subjects' => $this->subjects,
            'semesters' => $this->semesters,
        ]);
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'student_id' => 'required',
            'subject_id' => 'required',
            'semester_id' => 'required',
            'score' => 'required|integer',
        ]);

        $grade->update($request->all());

        return redirect()->route('grades.index')
                         ->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('grades.index')
                         ->with('success', 'Nilai berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $data = Excel::toArray(new GradesImport(), $file);

        foreach ($data as $row) {
            foreach ($row['subjects'] as $subject) {
                foreach ($subject['semesters'] as $semesterId => $score) {
                    Grade::updateOrCreate(
                        ['student_id' => $studentId, 'subject_id' => $subject['id'], 'semester_id' => $semesterId],
                        ['score' => $score]
                    );
                }
            }
        }
    }
}
