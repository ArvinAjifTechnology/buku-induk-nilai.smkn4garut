<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Student;
use App\Models\EntryYear;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class StudentFilterController extends Controller
{
    public function export(Request $request)
    {
        // Validasi input jika diperlukan
        $validated = $request->validate([
            'major_id' => 'nullable|integer|exists:majors,id',
            'entry_year' => 'nullable|integer|exists:entry_years,year',
            'school_class_id' => 'nullable|integer|exists:school_classes,id',
            'student_statuses' => 'nullable|string',
        ]);

        // Ambil filter dari request
        $filters = [
            'major_id' => $request->input('major_id'),
            'entry_year' => $request->input('entry_year'),
            'school_class_id' => $request->input('school_class_id'),
            'student_statuses' => $request->input('student_statuses'),
        ];

        // Buat nama file dinamis
        $fileName = 'Data Siswa';

        // Tambahkan tahun jika ada
        if (!empty($filters['entry_year'])) {
            $fileName .= '_Tahun_' . $filters['entry_year'];
        }

        // Tambahkan jurusan jika ada
        if (!empty($filters['major_id'])) {
            $major = Major::find($filters['major_id']);
            $majorName = $major ? $major->name : 'Jurusan tidak ditemukan';
            $fileName .= '_Jurusan_' . $majorName;
        }

        // Tambahkan kelas jika ada
        if (!empty($filters['school_class_id'])) {
            $schoolClass = SchoolClass::find($filters['school_class_id']);
            $schoolClassName = $schoolClass ? $schoolClass->name : 'Kelas tidak ditemukan';
            $fileName .= '_Kelas_' . $schoolClassName;
        }

        // Tambahkan status siswa jika ada
        if (!empty($filters['student_statuses'])) {
            switch ($filters['student_statuses']) {
                case 'active':
                    $studentStatusName = 'Aktif';
                    break;
                case 'graduated':
                    $studentStatusName = 'Lulus';
                    break;
                case 'dropped_out':
                    $studentStatusName = 'Keluar';
                    break;
                default:
                    $studentStatusName = 'Status_Tidak_Dikenal';
                    break;
            }

            $fileName .= '_Status_' . $studentStatusName;
        }


        // Lengkapi nama file dengan ekstensi
        $fileName .= '.xlsx';

        // Query data sesuai dengan filter
        $query = Student::query();

        // Terapkan filter jika ada
        if (!empty($filters['entry_year'])) {
            $query->whereHas('entryYear', function ($q) use ($filters) {
                $q->where('year', $filters['entry_year']);
            });
        }

        if (!empty($filters['major_id'])) {
            $query->where('major_id', $filters['major_id']);
        }

        if (!empty($filters['school_class_id'])) {
            $query->where('school_class_id', $filters['school_class_id']);
        }

        if (!empty($filters['student_statuses'])) {
            $query->where('student_statuses', $filters['student_statuses']);
        }

        // Eksekusi query
        $students = $query->get();

        // dd($students);

        // Jika tidak ada data, kembalikan pesan error
        if ($students->isEmpty()) {
            return back()->withErrors(['error' => 'Tidak ada data siswa yang ditemukan sesuai filter yang diberikan.']);
        }

        // Logika eksport tergantung filter yang diterapkan
        return Excel::download(new StudentsExport($filters), $fileName);
    }


    public function search(Request $request)
    {
        if (empty($request->query('query'))) {
            $students = Student::with(['entryYear', 'major', 'schoolClass'])->get(); // Load semua relasi
        } else {
            $query = $request->query('query');

            // Lakukan pencarian pada tabel utama dan relasi terkait
            $students = Student::with(['entryYear', 'major', 'schoolClass'])
                ->where('full_name', 'like', '%' . $query . '%')
                ->orWhere('nis', 'like', '%' . $query . '%')
                ->orWhere('nik', 'like', '%' . $query . '%')
                ->orWhereHas('schoolClass', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                })
                ->orWhereHas('major', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                })
                ->get();
        }


        return response()->json($students);
    }

    public function importForm()
    {
        return view('students.import');
    }

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls,csv|max:2048',
    //     ]);

    //     Excel::import(new StudentsImport, $request->file('file'));

    //     return redirect()->route('students.index')->with('success', 'Students imported successfully.');
    // }

    public function filter(Request $request)
    {
        $entryYears = EntryYear::all();
        $majors = Major::all();
        $schoolClasses = SchoolClass::all();

        $entryYear = $request->input('entry_year');
        $majorId = $request->input('major_id');
        $schoolClassId = $request->input('school_class_id');
        $studentStatuses = $request->input('student_statuses');

        $students = Student::query()->orderBy('school_class_id', 'asc')->orderBy('full_name', 'asc');
        $query = $students->with(['schoolClass', 'major', 'entryYear']);

        if ($entryYear) {
            $query->whereHas('entryYear', function ($q) use ($entryYear) {
                $q->where('year', $entryYear);
            });
        }

        if ($majorId) {
            $query->whereHas('major', function ($q) use ($majorId) {
                $q->where('id', $majorId);
            });
        }

        if ($schoolClassId) {
            $query->whereHas('schoolClass', function ($q) use ($schoolClassId) {
                $q->where('id', $schoolClassId);
            });
        }

        if ($studentStatuses) {
            $query->where('student_statuses', $studentStatuses);
        }

        $students = $query->get();

        return view('students.filter', compact('students', 'entryYears', 'majors', 'schoolClasses'));
        // return 'haii';
    }
}
