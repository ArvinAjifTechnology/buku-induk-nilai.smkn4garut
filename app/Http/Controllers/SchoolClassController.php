<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Imports\SchoolClassesImport;
use Maatwebsite\Excel\Facades\Excel;

class SchoolClassController extends Controller
{
    public function index()
    {
        $schoolClasses = SchoolClass::with('major')
                        ->orderBy('name', 'asc')
                        ->get();

        return view('school_classes.index', compact('schoolClasses'));
    }

    public function create()
    {
        $majors = Major::all();

        return view('school_classes.create', compact('majors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:school_classes,name',
            'major_id' => 'required',
        ]);

        SchoolClass::create($request->all());

        return redirect()->route('school_classes.index')
        ->with('success', 'Kelas berhasil ditambahkan');
    }

    public function show(SchoolClass $schoolClass)
    {
        return view('school_classes.show', compact('schoolClass'));
    }

    public function edit(SchoolClass $schoolClass)
    {
        $majors = Major::all();

        return view('school_classes.edit', compact('schoolClass', 'majors'));
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:school_classes,name,' . $schoolClass->id,
            'major_id' => 'required',
        ]);

        $schoolClass->update($request->all());

        return redirect()->route('school_classes.index')
        ->with('success', 'Kelas '.$schoolClass->name.' Berhasil Diupdate');
    }

    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();

        return redirect()->route('school_classes.index')
                         ->with('success', 'Kelas '.$schoolClass->name.' Berhasil Dihapus');
    }


    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx,xls', // Atau bisa juga gunakan: 'file' => 'required|mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);

        try {
            Excel::import(new SchoolClassesImport(), $request->file('file'));

            return redirect()->back()->with('success', 'Data berhasil diimpor.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $errors = $e->errors();

            return redirect()->back()->withErrors($errors)->withInput();
        }
    }
}
