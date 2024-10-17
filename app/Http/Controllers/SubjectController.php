<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Subject;
use App\Models\SubjectType;
use Illuminate\Http\Request;
use App\Imports\SubjectsImport;
use Maatwebsite\Excel\Facades\Excel;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();

        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $subjectTypes = SubjectType::all();

        return view('subjects.create', compact('subjectTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name',
            'subject_type_id' => 'required',
            'short' => 'required|string|max:10|unique:subjects,short',
            'description' => 'nullable|string',
        ]);

        Subject::create($request->all());

        return redirect()->route('subjects.index')
                         ->with('success', 'Mata Pelajaran Berhasil Dibuat');
    }

    public function show(Subject $subject)
    {
        return view('subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $subjectTypes = SubjectType::all();
        return view('subjects.edit', compact('subject', 'subjectTypes'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'subject_type_id' => 'required',
            'short' => 'required|string|max:10|unique:subjects,short,' . $subject->id,
            'description' => 'nullable|string',
        ]);

        $subject->update($request->all());

        return redirect()->route('subjects.index')
                         ->with('success', 'Mata pelajaran '. $subject->name .' berhasil diupdate');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subjects.index')
                         ->with('success', 'Mata Pelajaran'. $subject->name .'');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls', // Atau bisa juga gunakan: 'file' => 'required|mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);

        try {
            Excel::import(new SubjectsImport(), $request->file('file'));

            return redirect()->back()->with('success', 'Data berhasil diimpor.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $errors = $e->errors();

            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

}
