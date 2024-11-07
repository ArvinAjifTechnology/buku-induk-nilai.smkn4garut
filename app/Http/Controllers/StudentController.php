<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Grade;
use App\Models\Major;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\EntryYear;
use App\Models\SchoolClass;
use App\Models\SubjectType;
use Illuminate\Http\Request;
use App\Imports\GradesImport;
use App\Models\GraduationYear;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entryYears = EntryYear::orderBy('year', 'desc')->get();
        $majors = Major::all();
        $schoolClasses = SchoolClass::all();
        // $schoolClasses = SchoolClass::all(); // Ambil semua data kelas
        $students = Student::with(['schoolClass', 'major', 'entryYear'])
            ->orderBy('entry_year_id', 'asc')
            ->orderBy('school_class_id', 'asc')
            ->orderBy('full_name', 'asc')
            ->paginate(10);
        // $majors = Major::all(); // Ambil semua data jurusan, jika ada

        return view('students.index', compact('students', 'entryYears', 'majors', 'schoolClasses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolClasses = SchoolClass::all(); // Ambil semua data kelas
        $students = Student::all();
        $currentYear = date('Y');
        $entryYears = EntryYear::where('year', '<=', $currentYear)
            ->orderBy('year', 'desc')
            ->get();
        $graduationYears = GraduationYear::where('year', '<=', $currentYear)
            ->orderBy('year', 'desc')
            ->get();
        $majors = Major::all(); // Ambil semua data jurusan, jika ada

        return view('students.create', compact('students', 'schoolClasses', 'majors', 'entryYears', 'graduationYears'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->entry_year_id);
        $request->validate([
            'school_class_id' => 'required',
            'entry_year_id' => 'nullable',
            'graduation_year_id' => 'nullable',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'nisn' => 'required|string|max:20|unique:students,nisn',
            'nis' => 'required|string|max:20|unique:students,nis',
            'nik' => 'required|string|max:20|unique:students,nik',
            'student_statuses' => 'required|in:active,graduated,dropped_out',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'religion' => 'required|string|max:50',
            'nationality' => 'required|string|max:50',
            'special_needs' => 'boolean',
            'address' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'residence' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_birth_year' => 'nullable|integer',
            'father_education' => 'nullable|string|max:50',
            'father_job' => 'nullable|string|max:100',
            'father_nik' => 'nullable|string|max:20',
            'father_special_needs' => 'boolean',
            'mother_name' => 'nullable|string|max:255',
            'mother_birth_year' => 'nullable|integer',
            'mother_education' => 'nullable|string|max:50',
            'mother_job' => 'nullable|string|max:100',
            'mother_nik' => 'nullable|string|max:20',
            'mother_special_needs' => 'boolean',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_birth_year' => 'nullable|integer',
            'guardian_education' => 'nullable|string|max:50',
            'guardian_job' => 'nullable|string|max:100',
            'exam_number' => 'nullable|string|max:50',
            'smp_certificate_number' => 'nullable|string|max:50',
            'smp_skhun_number' => 'nullable|string|max:50',
            'school_origin' => 'nullable|string|max:255',
            'entry_date' => 'nullable|date',
            'smk_certificate_number' => 'nullable|string|max:50',
            'smk_skhun_number' => 'nullable|string|max:50',
            'exit_date' => 'nullable|date',
            'exit_reason' => 'nullable|string|max:255',
        ]);
        $student = new Student($request->except('photo'));

        $schoolClass = SchoolClass::find($request->school_class_id);
        $major = $schoolClass->major->id;
        $student->major_id = $major;

        if ($request->hasFile('photo')) {
            // Retrieve the necessary data
            $nim = $request->input('nisn');
            $className = $student->schoolClass->name; // Assuming there's a relationship 'schoolClass' to get the class name
            $entryYear = $request->input('entry_year');

            // Sanitize class name to avoid invalid characters in the filename
            $className = preg_replace('/[^A-Za-z0-9-_]/', '_', $className);

            // Generate the custom filename
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filename = "{$nim}_{$className}_{$entryYear}." . $extension;

            // Store the file with the custom filename
            $path = $request->file('photo')->storeAs('students/photos', $filename, 'public');
            $student->photo = $path;
        }

        $student->save();


        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        // Fetch student data with related entryYear and major
        $student = Student::with(['entryYear', 'major'])->findOrFail($student->id);

        // Get the entryYearId and majorId from the student
        $entryYearId = $student->entryYear->id;
        $majorId = $student->major->id;

        // Retrieve all subject types with subjects filtered by majorId and entryYearId
        $subjectTypes = SubjectType::with(['subjects' => function ($query) use ($majorId, $entryYearId) {
            $query->whereHas('majors', function ($query) use ($majorId) {
                $query->where('major_id', $majorId);
            })->whereHas('entryYears', function ($query) use ($entryYearId) {
                $query->where('entry_year_id', $entryYearId);
            });
        }])->get();

        // Retrieve all semesters
        $semesters = Semester::all();

        // Pass data to the view
        return view('students.show', compact('subjectTypes', 'semesters', 'student'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $student = Student::findOrFail($student->id);
        $currentYear = date('Y');
        $entryYears = EntryYear::where('year', '<=', $currentYear)
            ->orderBy('year', 'desc')
            ->get();
        $graduationYears = GraduationYear::where('year', '<=', $currentYear)
            ->orderBy('year', 'desc')
            ->get();
        $schoolClasses = SchoolClass::all(); // Ambil semua data kelas
        $majors = Major::all(); // Ambil semua data jurusan, jika ada

        return view('students.edit', compact('student', 'schoolClasses', 'entryYears', 'majors', 'graduationYears'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // dd($request->photo);
        $request->validate([
            'school_class_id' => 'required',
            'entry_year_id' => 'required',
            'graduation_year_id' => 'nullable',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'nisn' => 'required|string|max:20|unique:students,nisn,' . $student->id,
            'nis' => 'required|string|max:20|unique:students,nis,' . $student->id,
            'nik' => 'required|string|max:20|unique:students,nik,' . $student->id,
            'student_statuses' => 'required|in:active,graduated,dropped_out',
            'photo' => 'nullable|max:2048',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'religion' => 'required|string|max:50',
            'nationality' => 'required|string|max:50',
            'special_needs' => 'boolean',
            'address' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'residence' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_birth_year' => 'nullable|integer',
            'father_education' => 'nullable|string|max:50',
            'father_job' => 'nullable|string|max:100',
            'father_nik' => 'nullable|string|max:20',
            'father_special_needs' => 'boolean',
            'mother_name' => 'nullable|string|max:255',
            'mother_birth_year' => 'nullable|integer',
            'mother_education' => 'nullable|string|max:50',
            'mother_job' => 'nullable|string|max:100',
            'mother_nik' => 'nullable|string|max:20',
            'mother_special_needs' => 'boolean',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_birth_year' => 'nullable|integer',
            'guardian_education' => 'nullable|string|max:50',
            'guardian_job' => 'nullable|string|max:100',
            'exam_number' => 'nullable|string|max:50',
            'smp_certificate_number' => 'nullable|string|max:50',
            'smp_skhun_number' => 'nullable|string|max:50',
            'school_origin' => 'nullable|string|max:255',
            'entry_date' => 'nullable|date',
            'smk_certificate_number' => 'nullable|string|max:50',
            'smk_skhun_number' => 'nullable|string|max:50',
            'exit_date' => 'nullable|date',
            'exit_reason' => 'nullable|string|max:255',
        ]);

        $schoolClass = SchoolClass::find($request->school_class_id);

        if ($schoolClass && $schoolClass->major) {
            $major = $schoolClass->major->id;
            $student->major_id = $major;
        } else {
            // Tangani jika major tidak ditemukan atau school_class tidak valid
            return back()->withErrors(['major_id' => 'Jurusan tidak ditemukan untuk kelas ini'])->withInput();
        }

        if ($request->hasFile('photo')) {
            // Optionally, delete the old photo
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }

            // Retrieve the necessary data
            $nis = $student->nis; // Assuming NIM is stored in 'nisn'
            $name = $student->full_name; // Assuming NIM is stored in 'nisn'
            $className = $student->schoolClass->name; // Assuming there's a relationship 'schoolClass' to get the class name
            $entryYear = $student->entryYear->year; // Assuming 'entry_year' is the entry year field

            // Sanitize class name to avoid invalid characters in the filename
            $className = preg_replace('/[^A-Za-z0-9-_]/', '_', $className);

            // Generate the custom filename
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filename = "{$nis}_{$className}_{$entryYear}_{$name}." . $extension;

            // Store the file with the custom filename
            $path = $request->file('photo')->storeAs('students/photos', $filename, 'public');
            $student->photo = $path;
        }

        $student->update($request->except('photo'));


        return redirect()->route('students.index')->with('success', 'Data siswa ' . $student->full_name . ' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // $student->entryYear()->delete();
        // $student->major()->delete();
        // $student->schoolClass()->delete();
        // $student->grades()->delete();
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data siswa ' . $student->full_name . ' berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls', // Atau bisa juga gunakan: 'file' => 'required|mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);

        try {
            Excel::import(new StudentsImport(), $request->file('file'));

            return redirect()->back()->with('success', 'Data berhasil diimpor.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $errors = $e->errors();

            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function importGrades(Request $request, $id)
    {
        $file = $request->file('file');
        $student = Student::findOrFail($id);

        // Validasi file
        $request->validate([
            'file' => 'mimes:xlsx',
        ]);

        // Import data
        Excel::import(new GradesImport($id), $file);

        return redirect()->back()->with('success', 'Data Nilai ' . $student->nis . ' ' . $student->full_name . ' berhasil diimpor.');
    }

    public function getMajorByClass($classId)
    {
        $schoolClass = SchoolClass::find($classId);
        $major = $schoolClass ? $schoolClass->major : null;

        if ($major) {
            return response()->json([
                'success' => true,
                'major' => [
                    'id' => $major->id,
                    'name' => $major->name,
                ],
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    public function uploadPhoto(Request $request)
    {
        // Validasi input file
        $request->validate([
            'photos.*' => 'required|mimes:jpeg,png,jpg|max:2048', // Validasi setiap file
        ]);

        // Mengambil file yang diunggah
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                // Mendapatkan nama file asli dan mencoba mengambil NIS dari nama file
                $originalName = $file->getClientOriginalName();
                $nis = pathinfo($originalName, PATHINFO_FILENAME); // Asumsi nama file adalah NIS

                // Cari data siswa berdasarkan NIS
                $student = Student::where('nis', $nis)->first();

                if ($student) {
                    if ($student->photo) {
                        Storage::disk('public')->delete($student->photo);
                    }

                    // Retrieve the necessary data
                    $nis = $student->nis;
                    $name = $student->full_name;
                    $className = $student->schoolClass->name;
                    $entryYear = $student->entryYear->year;


                    $className = preg_replace('/[^A-Za-z0-9-_]/', '_', $className);


                    $extension = $file->getClientOriginalExtension();
                    $filename = "{$nis}_{$className}_{$entryYear}_{$name}." . $extension;


                    $path = $file->storeAs('students/photos', $filename, 'public');
                    $student->photo = $path;
                    $student->save();
                } else {
                    return redirect()->back()->withErrors("Siswa dengan NIS $nis tidak ditemukan.");
                }
            }

            return redirect()->back()->with('success', 'Semua foto berhasil diupload!');
        }

        return redirect()->back()->withErrors('Gagal mengupload foto.');
    }

    public function studentGradesForm(Student $student)
    {

        // Fetch student data with related entryYear and major
        $student = Student::with(['entryYear', 'major'])->findOrFail($student->id);

        // Get the entryYearId and majorId from the student
        $entryYearId = $student->entryYear->id;
        $majorId = $student->major->id;

        // Retrieve all subject types with subjects filtered by majorId and entryYearId
        $subjectTypes = SubjectType::with(['subjects' => function ($query) use ($majorId, $entryYearId) {
            $query->whereHas('majors', function ($query) use ($majorId) {
                $query->where('major_id', $majorId);
            })->whereHas('entryYears', function ($query) use ($entryYearId) {
                $query->where('entry_year_id', $entryYearId);
            });
        }])->get();

        // Retrieve all semesters
        $semesters = Semester::all();

        // Pass data to the view
        return view('students.form_grades', compact('subjectTypes', 'semesters', 'student'));
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
        // $entryYear = $request->input('entry_year');
        // $majorId = $request->input('major_id');
        // $schoolClassId = $request->input('school_class_id');

        // $query = Student::query();

        // if ($entryYear) {
        //     $query->whereHas('entryYear', function ($q) use ($entryYear) {
        //         $q->where('year', $entryYear);
        //     });
        // }

        // if ($majorId) {
        //     $query->whereHas('major', function ($q) use ($majorId) {
        //         $q->where('id', $majorId);
        //     });
        // }

        // if ($schoolClassId) {
        //     $query->whereHas('schoolClass', function ($q) use ($schoolClassId) {
        //         $q->where('id', $schoolClassId);
        //     });
        // }

        // $students = $query->paginate(10);

        // return view('students.index', compact('students'));
        return 'haii';
    }


    public function studentGradesStore(Request $request)
    {
        // Validate input
        $request->validate([
            'grades' => 'required|array',
            'grades.*.*' => 'nullable|numeric|min:0|max:100', // Each score must be a valid number
        ]);

        $studentId = $request->input('student_id'); // Assuming the logged-in user is a student

        foreach ($request->input('grades') as $subjectId => $semesters) {
            foreach ($semesters as $semesterId => $score) {
                // Only process if a score is entered
                if ($score !== null) {
                    // Try to find the existing grade
                    $grade = Grade::where('student_id', $studentId)
                        ->where('subject_id', $subjectId)
                        ->where('semester_id', $semesterId)
                        ->first();

                    if ($grade) {
                        // Update existing grade
                        $grade->update(['score' => $score]);
                    } else {
                        // Create a new grade if not found
                        Grade::create([
                            'student_id' => $studentId,
                            'subject_id' => $subjectId,
                            'semester_id' => $semesterId,
                            'score' => $score,
                        ]);
                    }
                }
            }
        }

        // Redirect back with success message
        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }

    // public function exportPhotos(Request $request)
    // {
    //     $students = Student::query();

    //     // Filter data siswa berdasarkan input
    //     // if ($request->nis) {
    //     //     $students->where('nis', $request->nis);
    //     // }
    //     // if ($request->name) {
    //     //     $students->where('name', $request->name);
    //     // }
    //     if ($request->school_class_id) {
    //         $students->where('school_class_id', $request->school_class_id);
    //     }
    //     if ($request->major_id) {
    //         $students->where('major_id', $request->major_id);
    //     }
    //     if ($request->entry_year) {
    //         $students->where('entry_year_id', $request->entry_year);
    //     }

    //     $students = $students->get();

    //     if ($students->isEmpty()) {
    //         return back()->with('error', 'Tidak ada siswa yang sesuai.');
    //     }

    //     // Path ZIP ke C:\Documents
    //     $zipPath = 'C:\Documents\photos_export.zip';

    //     // Hapus file ZIP jika sudah ada
    //     if (file_exists($zipPath)) {
    //         unlink($zipPath);
    //     }

    //     // Buat objek ZIP
    //     $zip = new ZipArchive;
    //     if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    //         return back()->with('error', "Gagal membuka file ZIP.");
    //     }
    //     dd($zip);
    //     foreach ($students as $student) {
    //         $fileName = "{$student->nis}_{$student->class}_{$student->year}_{$student->name}.jpg";
    //         $photoPath = 'public/' . $student->photo;
    //         $absolutePath = storage_path('app/' . $photoPath);

    //         if (!file_exists($absolutePath)) {
    //             return back()->with('error', "Foto tidak ditemukan: {$student->photo}");
    //         }

    //         if (!$zip->addFile($absolutePath, $fileName)) {
    //             return back()->with('error', "Gagal menambahkan foto: {$student->photo}");
    //         }
    //     }

    //     $zip->close();

    //     // Unduh ZIP
    //     return response()->download($zipPath);

    // }

    public function exportPhotos(Request $request)
    {
        $students = Student::query();

        if ($request->school_class_id) {
            $students->where('school_class_id', $request->school_class_id);
        }
        if ($request->major_id) {
            $students->where('major_id', $request->major_id);
        }
        if ($request->entry_year) {
            $students->where('entry_year_id', $request->entry_year);
        }

        $students = $students->get();
        // dd($students);
        if ($students->isEmpty()) {
            return back()->with('error', 'Tidak ada siswa yang sesuai.');
        }

        // Nama folder export
        $folderName = 'photos_export_' . time();
        $exportPath = storage_path('app/' . $folderName);

        // Buat folder jika belum ada
        if (!file_exists($exportPath)) {
            mkdir($exportPath, 0777, true);
        }

        $validPhotos = 0; // Counter untuk foto yang berhasil ditemukan

        // Pindahkan setiap foto ke folder export
        foreach ($students as $student) {
            $fileName = "{$student->nis}_{$student->schoolClass->name}_{$student->entryYear->year}_{$student->full_name}.jpg";
            $photoPath = 'public/' . $student->photo;
            $absolutePath = storage_path('app/' . $photoPath);

            // Pastikan path mengarah ke file yang valid
            if (is_file($absolutePath)) {
                // Salin foto ke folder export
                copy($absolutePath, $exportPath . '/' . $fileName);
                $validPhotos++; // Hitung siswa yang fotonya ditemukan
            }
        }

        if ($validPhotos === 0) {
            return back()->with('error', 'Tidak ada foto yang valid untuk diexport.');
        }
        // Kompres folder menjadi ZIP
        $zipPath = storage_path("app/{$folderName}.zip");
        $zip = new \ZipArchive;

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach (scandir($exportPath) as $file) {
                if ($file !== '.' && $file !== '..') {
                    $zip->addFile($exportPath . '/' . $file, $file);
                }
            }
            $zip->close();
        } else {
            return back()->with('error', 'Gagal membuat file ZIP.');
        }

        // Hapus folder setelah kompresi (opsional)
        $this->deleteFolder($exportPath);

        // Download file ZIP
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    // Fungsi untuk menghapus folder beserta isinya
    private function deleteFolder($folderPath)
    {
        foreach (scandir($folderPath) as $file) {
            if ($file !== '.' && $file !== '..') {
                unlink($folderPath . '/' . $file);
            }
        }
        rmdir($folderPath);
    }
}
