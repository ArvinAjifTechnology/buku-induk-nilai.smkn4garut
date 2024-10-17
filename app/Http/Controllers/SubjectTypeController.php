<?php

namespace App\Http\Controllers;

use App\Models\SubjectType;
use Illuminate\Http\Request;

class SubjectTypeController extends Controller
{
    public function index()
    {
        $subjectTypes = SubjectType::all();

        return view('subject_types.index', compact('subjectTypes'));
    }

    public function create()
    {
        return view('subject_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        SubjectType::create($request->all());

        return redirect()->route('subject_types.index')
                         ->with('success', 'Subject Type created successfully.');
    }

    public function show(SubjectType $subjectType)
    {
        return view('subject_types.show', compact('subjectType'));
    }

    public function edit(SubjectType $subjectType)
    {
        return view('subject_types.edit', compact('subjectType'));
    }

    public function update(Request $request, SubjectType $subjectType)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $subjectType->update($request->all());

        return redirect()->route('subject_types.index')
                         ->with('success', 'Subject Type updated successfully.');
    }

    public function destroy(SubjectType $subjectType)
    {
        $subjectType->delete();

        return redirect()->route('subject_types.index')
                         ->with('success', 'Data '. $subjectType->name. ' berhasil dihapus.');
    }
}
