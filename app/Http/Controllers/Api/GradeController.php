<?php

namespace App\Http\Controllers\Api;

use App\Models\Subject;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    /**
     * Get options (subjects and semesters) for a given student.
     *
     * @param  int  $studentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOptionsByStudent($studentId)
    {
        // Get available subjects and semesters not yet assigned to the student
        $subjects = Subject::whereDoesntHave('grades', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })->get();

        $semesters = Semester::whereDoesntHave('grades', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })->get();

        return response()->json([
            'subjects' => $subjects,
            'semesters' => $semesters,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
