<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Subject;
use App\Models\EntryYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListSubjectController extends Controller
{
    public function index()
    {
        $entryYears = EntryYear::all();
        $majors = Major::all();
    
        return view('list-subjects.index', compact('entryYears', 'majors'));
    }

    public function manage($entryYearId)
    {
        $entryYear = EntryYear::findOrFail($entryYearId);
        $majors = Major::all();
        $subjects = Subject::all();
    
        return view('list-subjects.manage', compact('entryYear', 'majors', 'subjects'));
    }
    
    public function update(Request $request, $entryYearId, $majorId)
    {
        $major = Major::findOrFail($majorId);
        $subjects = $request->input('subjects');

        // Siapkan data untuk sync
        $syncData = [];
        foreach ($subjects as $subjectId) {
            $syncData[$subjectId] = ['entry_year_id' => $entryYearId];
        }

        // Sinkronkan dengan metode sync untuk menambahkan dan memperbarui data
        $major->subjects()->sync($syncData, false); // false berarti tidak menghapus data yang ada

        return redirect()->route('list-subjects.manage', $entryYearId)->with('success', 'Mata Pelajaran berhasil diperbarui!');
    }


}
