<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Imports\MajorImport;
use Illuminate\Http\Request;
use App\Imports\MajorsImport;
use Maatwebsite\Excel\Facades\Excel;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::all();

        return view('majors.index', compact('majors'));
    }

    public function create()
    {
        return view('majors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:majors,name',
            'short' => 'required|string|max:10|unique:majors,short',
        ]);

        Major::create($request->all());

        return redirect()->route('majors.index')
                         ->with('success', 'Jurusan berhasil Ditambahkan.');
    }

    public function show(Major $major)
    {
        return view('majors.show', compact('major'));
    }

    public function edit(Major $major)
    {
        return view('majors.edit', compact('major'));
    }

    public function update(Request $request, Major $major)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:majors,name,'. $major->id,
            'short' => 'required|string|max:10|unique:majors,short,'. $major->id,
        ]);

        $major->update($request->all());

        return redirect()->route('majors.index')
                         ->with('success', 'Jurusan '.$major->name .' Berhasil di update ');
    }

    public function destroy(Major $major)
    {
        $major->delete();

        return redirect()->route('majors.index')
                         ->with('success', 'Jurusan '.$major->name.' Berhasil Dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls', // Atau bisa juga gunakan: 'file' => 'required|mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);

        try {
            Excel::import(new MajorsImport(), $request->file('file'));

            return redirect()->back()->with('success', 'Data Jurusan berhasil diimpor.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $errors = $e->errors();

            return redirect()->back()->withErrors($errors)->withInput();
        }
    }


}
