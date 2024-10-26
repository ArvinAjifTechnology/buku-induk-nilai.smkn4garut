<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Major;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\EntryYear;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Imports\GradesImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ManageGradeController extends Controller
{
    public function index()
    {
        $entryYears = EntryYear::with('students.major')->orderBy('year', 'desc')->get();

        return view('manage_grades.index', compact('entryYears'));
    }

    public function showMajors(EntryYear $entryYear)
    {
        $entryYear = EntryYear::with('majors.subjects')->where('uniqid', $entryYear->uniqid)->firstOrFail();

        return view('manage_grades.majors', compact('entryYear'));
    }

    public function showSchoolClasses(EntryYear $entryYear)
    {
        // Mengambil EntryYear beserta Majors dan SchoolClasses yang terkait
        $entryYear = EntryYear::with(['majors.schoolClasses' => function ($query) use ($entryYear) {
            $query->whereHas('major.entryYears', function ($subQuery) use ($entryYear) {
                $subQuery->where('entry_years.id', $entryYear->id);
            });
        }, 'majors.subjects'])
                    ->where('uniqid', $entryYear->uniqid)
                    ->firstOrFail();

        // Semester
        $semesters = Semester::all();

        // Mengirim data ke view
        return view(
            'manage_grades.school-classes',
            compact('entryYear', 'semesters')
        );
    }

    public function showStudentsByMajorAndEntryYear($entryYearUniqid ,$majorUniqid)
    {
        // Fetch the EntryYear
        $entryYear = EntryYear::where('uniqid', $entryYearUniqid)->firstOrFail();

        // Fetch the Major and its students for the given entry year
        $major = Major::where('uniqid', $majorUniqid)
            ->with(['students' => function ($query) use ($entryYear) {
                // Filter students by the entry year
                $query->where('entry_year_id', $entryYear->id)
                    ->orderBy('school_class_id', 'asc'); // Order by school_class_id
            }])
            ->firstOrFail();

        // Retrieve students
        $students = $major->students;

        // Retrieve all subjects for the major and entry year
        $allSubjects = Subject::whereExists(function ($query) use ($major, $entryYear) {
            $query->select(DB::raw(1))
                ->from('major_subjects')
                ->where('major_subjects.major_id', $major->id)
                ->where('major_subjects.entry_year_id', $entryYear->id)
                ->whereColumn('major_subjects.subject_id', 'subjects.id');
        })->get();

        // Retrieve all semesters
        $semesters = Semester::all();

        // Return the view with the necessary data
        return view('manage_grades.students', compact('students', 'semesters', 'major', 'entryYear', 'allSubjects'));
    }


    public function showStudentsByClassMajorAndEntryYear($schoolClassUniqid, $entryYearUniqid, $majorUniqid)
    {
        // Fetch the EntryYear
        $entryYear = EntryYear::where('uniqid', $entryYearUniqid)->firstOrFail();

        // Fetch the SchoolClass and its students for the given entry year
        $schoolClass = SchoolClass::where('uniqid', $schoolClassUniqid)
            ->whereHas('students', function ($query) use ($entryYear) {
                $query->where('entry_year_id', $entryYear->id);
            })
            ->with(['students' => function ($query) use ($entryYear) {
                $query->where('entry_year_id', $entryYear->id);
            }])
            ->firstOrFail();

        // Retrieve students
        $students = $schoolClass->students;

        // Retrieve Major and filter subjects based on entryYear
        $major = Major::where('uniqid', $majorUniqid)
            ->with(['subjects' => function ($query) use ($entryYear) {
                $query->whereExists(function ($query) use ($entryYear) {
                    $query->select(DB::raw(1))
                          ->from('major_subjects')
                          ->where('major_subjects.major_id', 'majors.id') // Ensure filtering by major_id
                          ->where('major_subjects.entry_year_id', $entryYear->id) // Ensure filtering by entry_year_id
                          ->whereColumn('major_subjects.subject_id', 'subjects.id');
                });
            }])
            ->firstOrFail();

        // Retrieve all subjects based on entryYear
        $allSubjects = Subject::whereExists(function ($query) use ($major, $entryYear) {
            $query->select(DB::raw(1))
                  ->from('major_subjects')
                  ->where('major_subjects.major_id', $major->id) // Ensure filtering by entry_year_id
                  ->where('major_subjects.entry_year_id', $entryYear->id) // Ensure filtering by entry_year_id
                  ->whereColumn('major_subjects.subject_id', 'subjects.id');
        })->get();

        // Retrieve all semesters
        $semesters = Semester::all();

        // Return the view with data
        return view('manage_grades.students', compact('students', 'semesters', 'schoolClass', 'entryYear', 'allSubjects'));
    }

    public function showFormByClassEntryYearMajor($schoolClassUniqid, $entryYearUniqid, $majorUniqid)
    {
       // Fetch the EntryYear
        $entryYear = EntryYear::where('uniqid', $entryYearUniqid)->firstOrFail();

        // Fetch the SchoolClass and its students for the given entry year
        $schoolClass = SchoolClass::where('uniqid', $schoolClassUniqid)
            ->whereHas('students', function ($query) use ($entryYear) {
                $query->where('entry_year_id', $entryYear->id);
            })
            ->with(['students' => function ($query) use ($entryYear) {
                $query->where('entry_year_id', $entryYear->id);
            }])
            ->firstOrFail();

        // Retrieve students in the class for the specific entry year
        $students = $schoolClass->students;

        // Retrieve Major and filter subjects based on entryYear
        $major = Major::where('uniqid', $majorUniqid)
            ->with(['subjects' => function ($query) use ($entryYear) {
                $query->whereExists(function ($query) use ($entryYear) {
                    $query->select(DB::raw(1))
                        ->from('major_subjects')
                        ->where('major_subjects.major_id', 'majors.id')
                        ->where('major_subjects.entry_year_id', $entryYear->id)
                        ->whereColumn('major_subjects.subject_id', 'subjects.id');
                });
            }])
            ->firstOrFail();

        // Retrieve subjects for this major and entry year
        $allSubjects = Subject::whereExists(function ($query) use ($major, $entryYear) {
            $query->select(DB::raw(1))
                ->from('major_subjects')
                ->where('major_subjects.major_id', $major->id)
                ->where('major_subjects.entry_year_id', $entryYear->id)
                ->whereColumn('major_subjects.subject_id', 'subjects.id');
        })->get();

        // Retrieve all semesters
        $semesters = Semester::all();

        // Return the view with data
        return view('manage_grades.form', compact('students', 'semesters', 'schoolClass', 'entryYear', 'allSubjects', 'major'));
    }
    public function showFormByMajor($majorUniqid, $entryYearUniqid)
    {
       // Fetch the EntryYear
       $entryYear = EntryYear::where('uniqid', $entryYearUniqid)->firstOrFail();

       // Fetch the Major and its students for the given entry year
       $major = Major::where('uniqid', $majorUniqid)
           ->with(['students' => function ($query) use ($entryYear) {
               // Filter students by the entry year
               $query->where('entry_year_id', $entryYear->id)
                   ->orderBy('school_class_id', 'asc'); // Order by school_class_id
           }])
           ->firstOrFail();

       // Retrieve students
       $students = $major->students;

       // Retrieve all subjects for the major and entry year
       $allSubjects = Subject::whereExists(function ($query) use ($major, $entryYear) {
           $query->select(DB::raw(1))
               ->from('major_subjects')
               ->where('major_subjects.major_id', $major->id)
               ->where('major_subjects.entry_year_id', $entryYear->id)
               ->whereColumn('major_subjects.subject_id', 'subjects.id');
       })->get();

       // Retrieve all semesters
       $semesters = Semester::all();

        // Return the view with data
        return view('manage_grades.form', compact('students', 'semesters', 'major', 'entryYear', 'allSubjects'));
    }

    public function store(Request $request)
    {
        $data = $request->input('grades') ?? 0;

        foreach ($data as $studentId => $subjects) {
            foreach ($subjects as $subjectId => $semesters) {
                foreach ($semesters as $semesterId => $values) {
                    $grade = Grade::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'subject_id' => $subjectId,
                            'semester_id' => $semesterId
                        ],
                        ['score' => $values['score'] ?? 0]
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Data nilai berhasil disimpan.');
    }

    // public function import(Request $request)
    // {
    //     // Validasi file
    //     $request->validate([
    //         'file' => 'required|file|mimes:xlsx,xls',
    //     ]);

    //     try {
    //         // Menggunakan kelas GradesImport untuk mengimpor data
    //         Excel::import(new GradesImport(), $request->file('file'));

    //         return back()->with('success', 'Data nilai berhasil diimpor.');
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
    //     }
    // }

    public function previewFile()
    {
        $allImportData = session('import_data', []);
        $currentIndex = session('current_file_index', 0);

        // Cek jika semua file sudah diproses
        if ($currentIndex >= count($allImportData)) {
            return redirect()->route('home')->with('success', 'Semua file berhasil diimpor.');
        }

        // Ambil data file saat ini berdasarkan indeks
        $import = $allImportData[$currentIndex];

        // Kirim data file yang sedang dipreview ke view
        return view('manage_grades.preview', compact('import', 'currentIndex'));
    }

    public function previewImport(Request $request)
    {
        $files = $request->file('files'); // Ambil semua file
        $allImportData = []; // Untuk menyimpan data dari semua file

        foreach ($files as $file) {
            $import = new \App\Imports\GradesImport;
            $rows = \Maatwebsite\Excel\Facades\Excel::toCollection($import, $file)->first();

            if (is_null($rows) || $rows->isEmpty()) {
                return redirect()->back()->with(
                    'error',
                    "File '{$file->getClientOriginalName()}' tidak mengandung data."
                );
            }

            // Ambil semua mata pelajaran dari header (baris ke-7)
            $subjects = Subject::all();
            $subjectIndex = $this->mapSubjectIndex($rows[6]->toArray(), $subjects);

            $importData = [];
            foreach ($rows->skip(7) as $row) {
                $student = Student::where('nisn', $row[2])->with(['schoolClass', 'major', 'entryYear'])->first();
                if ($student) {
                    $rowArray = $row->toArray();
                    $scoresWithSubjects = [];

                    foreach ($subjectIndex as $subjectId => $columnIndex) {
                        $subjectName = $subjects->firstWhere('id', $subjectId)->name;
                        $score = $rowArray[$columnIndex] ?? 0;

                        $scoresWithSubjects[] = [
                            'subject' => $subjectName,
                            'score' => $score,
                        ];
                    }

                    $importData[] = [
                        'name' => $row[1],
                        'nisn' => $row[2],
                        'schoolClass' => $student->entryYear->year . '/' . $student->schoolClass->name,
                        'major' => $student->major->name,
                        'entryYear' => $student->entryYear->year,
                        'scores' => $scoresWithSubjects,
                    ];
                }
            }

            // Simpan semua data per file
            $allImportData[] = [
                'file_name' => $file->getClientOriginalName(),
                'class' => $rows[2][1],
                'yearRange' => explode(' ', $rows[3][1])[0],
                'semester' => $this->getSemesterId($rows[2][1], strtolower(explode(' ', $rows[3][1])[1])),
                'data' => $importData,
            ];
        }

        // Simpan semua data dan set file pertama sebagai aktif
        session(['import_data' => $allImportData, 'current_file_index' => 0]);

        return $this->showCurrentFile();
    }

    public function showCurrentFile()
    {
        $allImportData = session('import_data', []);
        $currentIndex = session('current_file_index', 0);

        if ($currentIndex >= count($allImportData)) {
            return redirect()->route('home')->with('success', 'Semua file berhasil diimpor.');
        }

        $import = $allImportData[$currentIndex];

        return view('manage_grades.preview', compact('import', 'currentIndex'));
    }

    public function cancelImport()
    {
        // Ambil semua data import dari sesi
        $allImportData = session('import_data', []);
        $currentIndex = session('current_file_index', 0);

        // Increment index untuk berpindah ke file berikutnya
        $nextIndex = $currentIndex + 1;

        // Hanya hapus data indeks file, jangan langsung semua data import
        session(['current_file_index' => $nextIndex]);

        // Cek jika masih ada data untuk dipreview
        if ($nextIndex >= count($allImportData)) {
            // Jika tidak ada file lagi, redirect ke home
            session()->forget('import_data'); // Bersihkan data import
            return redirect()->route('home')->with('info', 'Proses import dibatalkan. Semua file telah diproses.');
        }

        // Redirect ke file berikutnya
        return redirect()->route('students-grades-e-raport-preview-file')
        ->with('info', 'Lanjut ke file berikutnya.');
    }

    public function confirmImport()
    {
        $allImportData = session('import_data');
        $currentIndex = session('current_file_index', 0); // Default index = 0

        if (!$allImportData || $currentIndex >= count($allImportData)) {
            return redirect()->route('home')->with('info', 'Semua file telah diimpor.');
        }

        $import = $allImportData[$currentIndex];

        foreach ($import['data'] as $row) {
            $student = Student::where('nisn', $row['nisn'])->first();
            if (!$student) {
                return redirect()->back()->with(
                    'error',
                    "Siswa dengan NISN '{$row['nisn']}' tidak ditemukan di file '{$import['file_name']}'."
                );
            }

            foreach ($row['scores'] as $scoreData) {
                $subject = Subject::where('name', $scoreData['subject'])->first();
                if (!$subject) {
                    return redirect()->back()->with(
                        'error',
                        "Mata pelajaran '{$scoreData['subject']}' tidak ditemukan di file '{$import['file_name']}'."
                    );
                }

                Grade::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'semester_id' => $import['semester'],
                    ],
                    ['score' => $scoreData['score']]
                );
            }
        }

        // Increment current file index untuk file berikutnya
        session(['current_file_index' => $currentIndex + 1]);

        if ($currentIndex + 1 < count($allImportData)) {
            // Jika masih ada file, kembali ke preview file berikutnya
            return redirect()->route('students-grades-e-raport-preview-file')
            ->with('info', 'File berhasil diproses. Lanjut ke file berikutnya.');
        }

        return redirect()->back()->with('success', 'Semua file berhasil diimpor.');
    }// end function confirmImport

    private function getSemesterId(string $class, string $academicSemester)
    {
        $semesterNumber = 0;

        if (strpos($class, '10') !== false) {
            $semesterNumber = ($academicSemester === 'ganjil') ? 1 : 2;
        } elseif (strpos($class, '11') !== false) {
            $semesterNumber = ($academicSemester === 'ganjil') ? 3 : 4;
        } elseif (strpos($class, '12') !== false) {
            $semesterNumber = ($academicSemester === 'ganjil') ? 5 : 6;
        }

        $semester = Semester::where('name', "Semester {$semesterNumber}")->first();

        if (!$semester) {
            throw new \Exception("Semester tidak ditemukan.");
        }

        return $semester->id;
    }

    private function mapSubjectIndex(array $headers, $subjects)
    {
        $subjectIndex = [];
        foreach ($headers as $index => $header) {
            foreach ($subjects as $subject) {
                if (strpos(strtolower($header), strtolower($subject->name)) !== false) {
                    $subjectIndex[$subject->id] = $index;
                }
            }
        }
        return $subjectIndex;
    }

    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        // Load file Excel
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->path());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Ambil header
        $headers = array_shift($data);

        // Ambil semua subjects dan semesters
        $subjects = Subject::all();
        $semesters = Semester::all();

        // Buat map untuk mencari index kolom
        $subjectIndex = [];
        foreach ($headers as $index => $header) {
            foreach ($subjects as $subject) {
                if (strpos($header, $subject->name) !== false) {
                    $subjectIndex[$subject->id] = $index;
                }
            }
        }

        // Array untuk menampung kesalahan validasi
        $invalidScores = [];

        // Proses baris data
        foreach ($data as $row) {
            $nis = $row[1];
            $nisn = $row[2];
            $class = $row[3];
            $major = $row[4];
            $name = $row[5];

            $student = Student::where('nis', $nis)->first();

            if (!$student) {
                // Student tidak ditemukan, lanjutkan ke baris berikutnya
                continue;
            }

            foreach ($subjects as $subject) {
                if (isset($subjectIndex[$subject->id])) {
                    for ($semesterIndex = 1; $semesterIndex <= 6; ++$semesterIndex) {
                        $semester = $semesters->find($semesterIndex);

                        if (!$semester) {
                            continue;
                        }

                        $dataIndex = $subjectIndex[$subject->id] + ($semesterIndex - 1);

                        if (isset($row[$dataIndex])) {
                            $score = $row[$dataIndex];

                            // Validasi nilai harus di antara 1 dan 100
                            if ($score < 1 || $score > 100) {
                                // Tambahkan kesalahan ke array invalidScores
                                $invalidScores[] = "Ada error pada baris " . (array_search($row, $data) + 2) . " Nilai {$score} untuk siswa {$student->full_name} pada mata pelajaran {$subject->name} Semester {$semester->id} tidak valid.";

                                continue;
                            }

                            Grade::updateOrCreate(
                                [
                                    'student_id' => $student->id,
                                    'subject_id' => $subject->id,
                                    'semester_id' => $semester->id,
                                ],
                                ['score' => $score]
                            );
                        }
                    }
                }
            }
        }

        // Redirect dengan pesan kesalahan jika ada nilai tidak valid
        if (!empty($invalidScores)) {
            return redirect()->back()->with('success', 'Data Nilai Berhasil Diimport dengan beberapa kesalahan.')->with('errors', $invalidScores);
        }

        return redirect()->back()->with('success', 'Data Nilai Berhasil Diimport tanpa kesalahan.');
    }
}
