<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Subject;
use App\Models\EntryYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListSubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listSubjects = Major::with('subjects.entryYears')->get();

        return view('list-subjects.index', compact('listSubjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entryYears = EntryYear::all();
        $majors = Major::all();
        $subjects = Subject::all();

        return view('list-subjects.create', compact('entryYears', 'majors', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $majorId = $request->input('major_id');
        $entryYearIds = $request->input('entry_year_id'); // Ambil array entry_year_id
        $subjectIds = $request->input('subject_id'); // Ambil array subject_id

        // Validasi array entry_year_id dan subject_id
        $request->validate([
            'entry_year_id' => 'required|array|min:1',
            'entry_year_id.*' => 'exists:entry_years,id', // Validasi untuk setiap item dalam array entry_year_id
            'subject_id' => 'required|array|min:1',
            'subject_id.*' => 'exists:subjects,id', // Validasi untuk setiap item dalam array subject_id
        ]);

        // Menyimpan data ke tabel pivot
        $major = Major::findOrFail($majorId);
        foreach ($subjectIds as $subjectId) {
            foreach ($entryYearIds as $entryYearId) {
                $major->subjects()->attach($subjectId, ['entry_year_id' => $entryYearId]);
            }
        }

        return redirect()->route('list-subjects.index')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $major = Major::with('subjects.entryYears')->findOrFail($id);

        // Mengelompokkan data berdasarkan tahun masuk
        $yearsGrouped = [];
        foreach ($major->subjects as $subject) {
            foreach ($subject->entryYears as $entryYear) {
                if (!isset($yearsGrouped[$entryYear->year])) {
                    $yearsGrouped[$entryYear->year] = [];
                }
                $yearsGrouped[$entryYear->year][] = [
                    'subject_name' => $subject->name,
                    'entry_year_id' => $entryYear->id,
                ];
            }
        }

        return view('list-subjects.show', compact('major', 'yearsGrouped'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $major = Major::findOrFail($id);
        $entryYears = EntryYear::all();
        $subjects = Subject::all();
        $selectedEntryYears = $major->entryYears->pluck('id')->toArray();
        $selectedSubjects = $major->subjects->pluck('id')->toArray();

        return view('list-subjects.edit', compact('major', 'entryYears', 'subjects', 'selectedEntryYears', 'selectedSubjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uniqid)
    {
        $major = Major::where('uniqid', $uniqid)->firstOrFail();

        $major = Major::where('uniqid', $uniqid)->firstOrFail();

        $entryYearIds = $request->input('entry_year_id');
        $subjectIds = $request->input('subject_id');
        
        $request->validate([
            'entry_year_id' => 'required|array|min:1',
            'entry_year_id.*' => 'exists:entry_years,id',
            'subject_id' => 'required|array|min:1',
            'subject_id.*' => 'exists:subjects,id',
        ]);
        
        $syncData = [];
        
        // Formatkan data untuk sinkronisasi
        foreach ($subjectIds as $subjectId) {
            foreach ($entryYearIds as $entryYearId) {
                $syncData[] = [
                    'subject_id' => $subjectId,
                    'entry_year_id' => $entryYearId,
                    'major_id' => $major->id,
                ];
            }
        }
        
        // Hapus data lama jika perlu
        DB::table('entry_year_major_subject')
            ->where('major_id', $major->id)
            ->delete();
        
        // Masukkan data baru
        foreach ($syncData as $data) {
            DB::table('entry_year_major_subject')->insert([
                'subject_id' => $data['subject_id'],
                'entry_year_id' => $data['entry_year_id'],
                'major_id' => $data['major_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return redirect()->route('list-subjects.index')->with('success', 'Data berhasil diperbarui!');
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
