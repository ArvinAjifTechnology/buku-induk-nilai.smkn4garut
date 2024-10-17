<?php

namespace App\Http\Controllers;

use App\Models\EntryYear;
use App\Models\Major;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageSubjectAndMajorController extends Controller
{
    public function index()
    {
        $entryYears = EntryYear::with('majors.subjects')->orderBy('year', 'desc')->get();

        return view('manage-subject-and-major.index', compact('entryYears'));
    }

    // Menampilkan daftar Major berdasarkan Entry Year
    public function showMajors($entryYearUniqid)
    {
        $entryYear = EntryYear::with('majors.subjects')->where('uniqid', $entryYearUniqid)->firstOrFail();

        return view('manage-subject-and-major.majors', compact('entryYear'));
    }

    // Menampilkan daftar Subject berdasarkan Major
    public function showSubjects($entryYearUniqid, $majorUniqid)
    {
        // Mendapatkan EntryYear berdasarkan uniqid
        $entryYear = EntryYear::where('uniqid', $entryYearUniqid)->firstOrFail();

        // Mendapatkan Major beserta Subjects yang terhubung dengan entry year yang dipilih
        $major = Major::with(['subjects' => function ($query) use ($entryYear) {
            $query->where('major_subjects.entry_year_id', $entryYear->id);
        }])->where('uniqid', $majorUniqid)->firstOrFail();

        // Mengambil semua mata pelajaran
        $allSubjects = Subject::all();

        // Mengembalikan view dengan data yang telah dikompilasi
        return view('manage-subject-and-major.subjects', compact('major', 'allSubjects', 'entryYearUniqid'));
    }

    // Menampilkan form untuk menghubungkan mata pelajaran yang sudah ada dengan jurusan dan tahun masuk
    public function showAddExistingSubjectsForm($entryYearUniqid, $majorUniqid)
    {
        // Mendapatkan Entry Year dan Major berdasarkan uniqid
        $entryYear = EntryYear::where('uniqid', $entryYearUniqid)->firstOrFail();
        $major = Major::where('uniqid', $majorUniqid)->firstOrFail();

        // Mengambil semua mata pelajaran
        $subjects = Subject::all();

        // Mengambil subject_ids yang terhubung dengan major dan entry year tertentu
        $attachedSubjectIds = DB::table('major_subjects')
            ->where('entry_year_id', $entryYear->id)  // Memastikan entry_year_id digunakan di sini
            ->where('major_id', $major->id)
            ->pluck('subject_id')  // Mengambil subject_id saja
            ->toArray();

        // Mengembalikan view dengan data yang telah dikompilasi
        return view('manage-subject-and-major.add-existing-subjects', compact('entryYear', 'major', 'subjects', 'attachedSubjectIds'));
    }

    // Menyimpan hubungan mata pelajaran dengan jurusan dan tahun masuk
    public function storeAddExistingSubjects(Request $request)
    {
        $validatedData = $request->validate([
            'entry_year_uniqid' => 'required|exists:entry_years,uniqid',
            'major_uniqid' => 'required|exists:majors,uniqid',
            'subject_ids' => 'nullable|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $entryYear = EntryYear::where('uniqid', $validatedData['entry_year_uniqid'])->firstOrFail();
        $major = Major::where('uniqid', $validatedData['major_uniqid'])->firstOrFail();
        $subjectIds = $validatedData['subject_ids'] ?? [];

        // Hapus semua hubungan `major` dengan `subjects` untuk `entryYear` tertentu
        $major->subjectsForEntryYear($entryYear->id)->detach();

        // Simpan hubungan baru jika ada mata pelajaran yang dipilih
        if (!empty($subjectIds)) {
            foreach ($subjectIds as $subjectId) {
                // Gunakan attach dengan pivot data yang lengkap, termasuk `entry_year_id`
                $major->subjectsForEntryYear($entryYear->id)->attach($subjectId, [
                    'entry_year_id' => $entryYear->id, // Pastikan `entry_year_id` selalu disertakan
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    // Menampilkan form untuk mengisi jurusan tiap tahun masuk
    public function showAssignMajorsForm()
    {
        $entryYears = EntryYear::all();
        $majors = Major::all();

        return view('manage-subject-and-major.assign-majors', compact('entryYears', 'majors'));
    }

    // Menyimpan hubungan jurusan dengan tahun masuk
    public function storeAssignMajors(Request $request)
    {
        $request->validate([
            'entry_year_uniqid' => 'required|exists:entry_years,uniqid',
            'major_ids' => 'required|array',
            'major_ids.*' => 'exists:majors,id',
        ]);

        $entryYear = EntryYear::where('uniqid', $request->entry_year_uniqid)->firstOrFail();
        $entryYear->majors()->sync($request->major_ids ?: []);

        return redirect()->route('manage-subject-and-major.majors', $entryYear->uniqid)->with('success', 'Jurusan berhasil dihubungkan dengan tahun masuk.');
    }

    public function getMajorsByEntryYear($entryYearUniqid)
    {
        $entryYear = EntryYear::where('uniqid', $entryYearUniqid)->first();

        if ($entryYear) {
            $majors = $entryYear->majors;  // Mengambil jurusan terkait

            return response()->json($majors);
        }

        return response()->json([]);
    }
}
