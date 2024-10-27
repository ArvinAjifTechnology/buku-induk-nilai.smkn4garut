<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use ZipArchive;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Major;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\EntryYear;
use App\Models\SchoolClass;
use App\Models\SubjectType;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use App\Exports\StudentsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\StudentsExcelExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\Element\Image;
use PhpOffice\PhpWord\Element\TextRun;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer\Word2007\Element\Text;
use PhpOffice\PhpWord\Writer\Word2007\Element\TextBreak;

class StudentExportController extends Controller
{

    protected $wordPath;

    public function index(Request $request)
    {
        $students = Student::with(['schoolClass', 'major', 'entryYear'])->paginate(10);
        $studentsForm = Student::with(['schoolClass', 'major', 'entryYear'])->get();
        $schoolClasses = SchoolClass::all();
        $majors = Major::all();
        $entryYears = EntryYear::all();

        $query = Student::query()->with(['entryYear', 'major', 'schoolClass']);

        if ($request->filled('student_id')) {
            $query->where('id', $request->student_id);
        }

        if ($request->filled('school_class_id')) {
            $query->where('school_class_id', $request->school_class_id);
        }

        if ($request->filled('major_id')) {
            $query->where('major_id', $request->major_id);
        }

        if ($request->filled('entry_year_id')) {
            $query->where('entry_year_id', $request->entry_year_id);
        }

        if ($request->filled('student_statuses')) {
            $query->where('student_statuses', $request->student_statuses);
        }
        $students = $query->paginate(10);

        return view('students_exports.index', compact('students', 'schoolClasses', 'majors', 'entryYears', 'studentsForm'));
    }


    public function exportWord(Request $request)
    {
        // Set batas memori dan waktu eksekusi
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 300);
        $query = Student::query()->with(['schoolClass', 'major', 'entryYear']);

        if ($request->filled('student_id')) {
            $query->where('id', $request->student_id);
        }

        if ($request->filled('school_class_id')) {
            $query->where('school_class_id', $request->school_class_id);
        }

        if ($request->filled('major_id')) {
            $query->where('major_id', $request->major_id);
        }

        if ($request->filled('entry_year_id')) {
            $query->where('entry_year_id', $request->entry_year_id);
        }

        if ($request->filled('student_statuses')) {
            $query->where('student_statuses', $request->student_statuses);
        }

        $query->orderBy('nisn', 'asc');

        $students = $query->get();

        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada siswa yang sesuai dengan filter.');
        }

        $semesters = Semester::all();
        $subjectTypes = SubjectType::with('subjects')->get();

        $templatePath = storage_path('app/public/templates/template_word.docx');

        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'File template tidak ditemukan.');
        }

        $genderMap = [
            'male' => 'Laki-Laki',
            'female' => 'Perempuan',
        ];

        $statusMap = [
            'active' => 'Aktif',
            'graduated' => 'Lulus',
            'dropped_out' => 'Keluar',
        ];

        foreach ($students as $student) {
            $this->generateWordForStudent($templatePath, $student, $semesters, $subjectTypes, $request, $genderMap, $statusMap);
        }
        $wordPath = $this->wordPath;

        return redirect()->back()->with('success', 'File Word berhasil dibuat di ' . $wordPath . '.');
    }

    protected function generateWordForStudent($templatePath, $student, $semesters, $subjectTypes, $request, $genderMap, $statusMap)
    {
        $templateProcessor = new TemplateProcessor($templatePath);

        $gender = $genderMap[$student->gender] ?? 'N/A';
        $studentStatus = $statusMap[$student->student_statuses] ?? 'N/A';

        $data = [
            'full_name' => htmlspecialchars($student->full_name, ENT_XML1, 'UTF-8'),
            'gender' => htmlspecialchars($gender, ENT_XML1, 'UTF-8'),
            'nisn' => htmlspecialchars($student->nisn, ENT_XML1, 'UTF-8'),
            'nis' => htmlspecialchars($student->nis, ENT_XML1, 'UTF-8'),
            'nik' => htmlspecialchars($student->nik, ENT_XML1, 'UTF-8'),
            'birth_place' => htmlspecialchars($student->birth_place, ENT_XML1, 'UTF-8'),
            'birth_date' => Carbon::parse($student->birth_date)->format('d-m-Y'),
            'school_class' => htmlspecialchars($student->schoolClass->name, ENT_XML1, 'UTF-8'),
            'entry_year' => htmlspecialchars($student->entryYear->year, ENT_XML1, 'UTF-8'),
            'major' => htmlspecialchars($student->major->name, ENT_XML1, 'UTF-8'),
            'religion' => htmlspecialchars($student->religion, ENT_XML1, 'UTF-8'),
            'nationality' => htmlspecialchars($student->nationality, ENT_XML1, 'UTF-8'),
            'special_needs' => htmlspecialchars($student->special_needs, ENT_XML1, 'UTF-8'),
            'address' => htmlspecialchars($student->address, ENT_XML1, 'UTF-8'),
            'rt' => htmlspecialchars($student->rt, ENT_XML1, 'UTF-8'),
            'rw' => htmlspecialchars($student->rw, ENT_XML1, 'UTF-8'),
            'village' => htmlspecialchars($student->village, ENT_XML1, 'UTF-8'),
            'district' => htmlspecialchars($student->district, ENT_XML1, 'UTF-8'),
            'postal_code' => htmlspecialchars($student->postal_code, ENT_XML1, 'UTF-8'),
            'residence' => htmlspecialchars($student->residence, ENT_XML1, 'UTF-8'),
            'height' => htmlspecialchars($student->height, ENT_XML1, 'UTF-8'),
            'weight' => htmlspecialchars($student->weight, ENT_XML1, 'UTF-8'),
            'siblings' => htmlspecialchars($student->siblings, ENT_XML1, 'UTF-8'),
            'phone' => htmlspecialchars($student->phone, ENT_XML1, 'UTF-8'),
            'email' => htmlspecialchars($student->email, ENT_XML1, 'UTF-8'),
            'father_name' => htmlspecialchars($student->father_name, ENT_XML1, 'UTF-8'),
            'father_birth_year' => htmlspecialchars($student->father_birth_year, ENT_XML1, 'UTF-8'),
            'father_education' => htmlspecialchars($student->father_education, ENT_XML1, 'UTF-8'),
            'father_job' => htmlspecialchars($student->father_job, ENT_XML1, 'UTF-8'),
            'father_nik' => htmlspecialchars($student->father_nik, ENT_XML1, 'UTF-8'),
            'father_special_needs' => htmlspecialchars($student->father_special_needs, ENT_XML1, 'UTF-8'),
            'mother_name' => htmlspecialchars($student->mother_name, ENT_XML1, 'UTF-8'),
            'mother_birth_year' => htmlspecialchars($student->mother_birth_year, ENT_XML1, 'UTF-8'),
            'mother_education' => htmlspecialchars($student->mother_education, ENT_XML1, 'UTF-8'),
            'mother_job' => htmlspecialchars($student->mother_job, ENT_XML1, 'UTF-8'),
            'mother_nik' => htmlspecialchars($student->mother_nik, ENT_XML1, 'UTF-8'),
            'mother_special_needs' => htmlspecialchars($student->mother_special_needs, ENT_XML1, 'UTF-8'),
            'guardian_name' => htmlspecialchars($student->guardian_name, ENT_XML1, 'UTF-8'),
            'guardian_birth_year' => htmlspecialchars($student->guardian_birth_year, ENT_XML1, 'UTF-8'),
            'guardian_education' => htmlspecialchars($student->guardian_education, ENT_XML1, 'UTF-8'),
            'guardian_job' => htmlspecialchars($student->guardian_job, ENT_XML1, 'UTF-8'),
            'exam_number' => htmlspecialchars($student->exam_number, ENT_XML1, 'UTF-8'),
            'smp_certificate_number' => htmlspecialchars($student->smp_certificate_number, ENT_XML1, 'UTF-8'),
            'smp_skhun_number' => htmlspecialchars($student->smp_skhun_number, ENT_XML1, 'UTF-8'),
            'school_origin' => htmlspecialchars($student->school_origin, ENT_XML1, 'UTF-8'),
            'entry_date' => Carbon::parse($student->entry_date)->format('d-m-Y'),
            'smk_certificate_number' => htmlspecialchars($student->smk_certificate_number, ENT_XML1, 'UTF-8'),
            'smk_skhun_number' => htmlspecialchars($student->smk_skhun_number, ENT_XML1, 'UTF-8'),
            'exit_date' => $student->exit_date ? Carbon::parse($student->exit_date)->format('d-m-Y') : '',
            'exit_reason' => htmlspecialchars($student->exit_reason, ENT_XML1, 'UTF-8'),
        ];

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        // Path foto
        $photoPath = storage_path('app/public/' . $student->photo);

        // Debug path foto
        Log::info("Photo path: " . $photoPath);

        if (file_exists($photoPath)) {
            try {
                $templateProcessor->setImageValue('photo', [
                    'path' => $photoPath,
                    'width' => 113,  // 3 cm dalam piksel
                    'height' => 151, // 4 cm dalam piksel
                    'ratio' => true, // Menjaga rasio asli
                ]);
            } catch (\Exception $e) {
                Log::error("Error setting image: " . $e->getMessage());
            }
        } else {
            Log::error("Photo does not exist at: " . $photoPath);
        }


        // Filter subjects based on the student's major and entry year
        $filteredSubjectTypes = SubjectType::with(['subjects' => function ($query) use ($student) {
            $query->whereHas('majors', function ($query) use ($student) {
                $query->where('major_id', $student->major_id);
            })->whereHas('entryYears', function ($query) use ($student) {
                $query->where('entry_year_id', $student->entry_year_id);
            });
        }])->get();

        $this->generateStudentScoresTable($templateProcessor, $student, $filteredSubjectTypes, $semesters);

        $gender = $genderMap[$student->gender] ?? 'N/A';
        $studentStatus = $statusMap[$student->student_statuses] ?? 'N/A';

        // Ambil input dari request
        $schoolClassId = $request->input('school_class_id');
        $majorId = $request->input('major_id');
        $entryYearId = $request->input('entry_year_id');
        $studentId = $request->input('student_id');
        $studentStatus = $request->input('student_statuses', 'unknown');

        // Tentukan nama status
        $statusMap = [
            'active' => 'Aktif',
            'graduated' => 'Lulus',
            'dropped_out' => 'Keluar',
            'unknown' => 'Semua Status'
        ];
        $studentStatusName = $statusMap[$studentStatus] ?? 'Semua Status';

        // Ambil tahun masuk
        $entryYear = $student->entryYear->year ?? 'unknown';

        // Struktur nama folder
        $baseFolder = "C:/Documents/StudentReports/{$studentStatusName}_{$entryYear}";
        $baseFolderStudent = "C:/Documents/StudentReport/";

        if ($schoolClassId) {
            // Jika berdasarkan kelas
            $schoolClassName = SchoolClass::find($schoolClassId)->name;
            $folderPath = "{$baseFolder}_{$schoolClassName}";
        } elseif ($majorId) {
            // Jika berdasarkan jurusan
            $majorName = Major::find($majorId)->name;
            $folderPath = "{$baseFolder}_{$majorName}";
        } elseif ($studentId) {
            $folderPath = $baseFolderStudent;
        } else {
            // Jika hanya berdasarkan tahun masuk
            $folderPath = $baseFolder;
        }

        // Buat folder jika belum ada
        $this->createFolder($folderPath);

        // Nama file Word
        $fileName = "{$student->entryYear->year}_{$student->schoolClass->name}_{$student->nisn}_{$student->full_name}.docx";
        $this->wordPath = "{$folderPath}/{$fileName}";
        // Buat ZIP dari folder dan unduh

        try {
            $templateProcessor->saveAs($this->wordPath);
            $zip = $this->downloadAsZip($folderPath);
            // dd($zip);

            // $pdfPath = $this->convertWordFilesToPdf($folderPath);
            dd(response()->download($zip)->deleteFileAfterSend(false));

            session()->flash('success', 'Dokumen Word untuk siswa ' . $student->full_name . ' berhasil disimpan di ' . $this->wordPath);
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan dokumen Word: ' . $e->getMessage());
            Log::error("Error saving Word document: " . $e->getMessage());
        }
        // return redirect()->back()->with('success', 'File Word berhasil dibuat untuk setiap siswa.');

    }
    private function createFolder($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
    }

    public function downloadAsZip($folderPath)
    {
        // Ambil nama folder terakhir dari path
        $folderName = basename($folderPath);

        // Tentukan path dan nama file ZIP secara dinamis
        $zipPath = storage_path("app/{$folderName}.zip");

        // Hapus ZIP jika sudah ada
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        $zip = new ZipArchive;

        // Buka file ZIP untuk ditulis
        if (
            $zip->open($zipPath, ZipArchive::CREATE) !== TRUE
        ) {
            return back()->with('error', 'Gagal membuka file ZIP: ' . $zip->getStatusString());
        }

        // Tambahkan semua file dalam folder ke ZIP
        $files = File::allFiles($folderPath);
        if (empty($files)) {
            return back()->with('error', 'Tidak ada file di folder ' . $folderPath);
        }

        foreach ($files as $file) {
            $relativeNameInZip = $file->getRelativePathname(); // Pertahankan struktur
            $zip->addFile($file->getRealPath(), $relativeNameInZip);
        }

        // Siapkan pesan sukses sebelum mengirim file
        session()->flash('success', 'ZIP berhasil dibuat dan siap diunduh.');
        $zip->close();

        // return response()->download($zipPath)->deleteFileAfterSend(true);
        return $zipPath;
    }

    protected function convertWordFilesToPdf($folderPath)
    {
        $dompdf = new \Dompdf\Dompdf();
        $content = ''; // Menampung semua konten

        $files = File::allFiles($folderPath);
        foreach ($files as $file) {
            if ($file->getExtension() === 'docx') {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($file->getRealPath(), 'Word2007');

                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        $content .= $this->extractTextFromElement($element); // Memanggil metode dengan benar
                    }
                }
            }
        }

        // Render PDF dengan Dompdf
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Simpan PDF ke storage
        $pdfPath = storage_path('app/merged_students_report.pdf');
        file_put_contents($pdfPath, $dompdf->output());

        return $pdfPath;
    }

    /**
     * Fungsi rekursif untuk mengekstrak teks dari berbagai elemen Word.
     */
    protected function extractTextFromElement($element)
    {
        $text = '';

        if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
            // Urai sub-elemen di dalam TextRun
            foreach ($element->getElements() as $childElement) {
                $text .= $this->extractTextFromElement($childElement); // Panggil lagi secara rekursif
            }
        } elseif ($element instanceof \PhpOffice\PhpWord\Element\Text) {
            // Tangani elemen teks langsung
            $text .= '<p>' . htmlspecialchars($element->getText(), ENT_QUOTES, 'UTF-8') . '</p>';
        } elseif ($element instanceof \PhpOffice\PhpWord\Element\Table) {
            // Tangani elemen tabel
            foreach ($element->getRows() as $row) {
                foreach ($row->getCells() as $cell) {
                    foreach ($cell->getElements() as $cellElement) {
                        $text .= $this->extractTextFromElement($cellElement);
                    }
                }
            }
        }

        return $text;
    }




    protected function generateStudentScoresTable($templateProcessor, $student, $subjectTypes, $semesters)
    {
        $rows = [];
        $rowNo = 1;
        $totalScores = array_fill(1, 6, 0); // Array untuk menyimpan total nilai untuk setiap semester
        $subjectCount = 0; // Variabel untuk menghitung jumlah mata pelajaran

        foreach ($subjectTypes as $subjectType) {
            if ($subjectType->subjects->isNotEmpty()) {
                foreach ($subjectType->subjects as $subject) {
                    $scores = [];
                    $hasScores = false;

                    for ($semester = 1; $semester <= 6; $semester++) {
                        $score = (float)$student->getScoreForSubjectAndSemester($subject->id, $semester);
                        if ($score > 0) {
                            $hasScores = true;
                        }
                        $scores[] = $score;
                        $totalScores[$semester] += $score; // Tambahkan nilai untuk setiap semester
                    }

                    if ($hasScores) {
                        $subjectCount++;
                        $rows[] = [
                            'no' => $rowNo++,
                            'subject_name' => htmlspecialchars($subject->name, ENT_XML1, 'UTF-8'),
                            'semester_1' => htmlspecialchars($scores[0], ENT_XML1, 'UTF-8'),
                            'semester_2' => htmlspecialchars($scores[1], ENT_XML1, 'UTF-8'),
                            'semester_3' => htmlspecialchars($scores[2], ENT_XML1, 'UTF-8'),
                            'semester_4' => htmlspecialchars($scores[3], ENT_XML1, 'UTF-8'),
                            'semester_5' => htmlspecialchars($scores[4], ENT_XML1, 'UTF-8'),
                            'semester_6' => htmlspecialchars($scores[5], ENT_XML1, 'UTF-8'),
                        ];
                    }
                }
            }
        }

        // Hitung rata-rata per semester hanya untuk mata pelajaran yang memiliki nilai
        $averageScores = [];
        for ($semester = 1; $semester <= 6; $semester++) {
            $subjectCountInSemester = 0; // Menghitung jumlah mata pelajaran dengan nilai di semester ini
            $totalScoresForSemester = 0;

            foreach ($subjectTypes as $subjectType) {
                foreach ($subjectType->subjects as $subject) {
                    $score = (float)$student->getScoreForSubjectAndSemester($subject->id, $semester);
                    if ($score > 0) {
                        $totalScoresForSemester += $score;
                        $subjectCountInSemester++;
                    }
                }
            }

            $averageScores[$semester] = $subjectCountInSemester > 0
                ? number_format($totalScoresForSemester / $subjectCountInSemester, 2, '.', '')
                : 0;
        }

        // Set nilai rata-rata dan total nilai di template
        for ($semester = 1; $semester <= 6; $semester++) {
            $templateProcessor->setValue("total_score_$semester", number_format($totalScores[$semester], 2, '.', ''));
            $templateProcessor->setValue("average_score_$semester", $averageScores[$semester]);
        }

        // Status ketercapaian dan kelulusan
        $promotionStatuses = [];
        // Tercapai/Tidak Tercapai untuk semester 1 dan 2
        $promotionStatuses[1] = $averageScores[1] >= 75 && $averageScores[2] >= 75 ? 'Tercapai' : 'Tidak Tercapai';
        // Tercapai/Tidak Tercapai untuk semester 3 dan 4
        $promotionStatuses[2] = $averageScores[3] >= 75 && $averageScores[4] >= 75 ? 'Tercapai' : 'Tidak Tercapai';
        // Lulus/Tidak Lulus untuk semester 5 dan 6
        $promotionStatuses[3] = $averageScores[5] >= 75 && $averageScores[6] >= 75 ? 'Lulus' : 'Tidak Lulus';

        // Set status kelulusan di template
        $templateProcessor->setValue("promotion_status_1", $promotionStatuses[1]);
        $templateProcessor->setValue("promotion_status_2", $promotionStatuses[2]);
        $templateProcessor->setValue("promotion_status_3", $promotionStatuses[3]);

        try {
            $templateProcessor->cloneRowAndSetValues('no', $rows);
        } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
            Log::error("Error generating student scores table: " . $e->getMessage());
        }
    }



    public function getScoreForSubjectAndSemester($subjectId, $semester)
    {
        // Assuming you have a way to retrieve the score
        $score = $this->scores()->where('subject_id', $subjectId)->where('semester', $semester)->value('score');
        return $score ? (float)$score : 0;
    }

    public function exportExcel(Request $request)
    {
        // Query dasar untuk mengambil data siswa dengan relasi
        $query = Student::query()->with(['schoolClass', 'major', 'entryYear', 'grades.subject', 'grades.semester']);

        // Filter berdasarkan ID siswa
        if ($request->filled('student_id')) {
            $query->where('id', $request->student_id);
        }

        // Filter berdasarkan kelas
        if ($request->filled('school_class_id')) {
            $query->where('school_class_id', $request->school_class_id);
        }

        // Filter berdasarkan jurusan
        if ($request->filled('major_id')) {
            $query->where('major_id', $request->major_id);
        }

        // Filter berdasarkan tahun masuk
        if ($request->filled('entry_year_id')) {
            $query->where('entry_year_id', $request->entry_year_id);
        }

        // Filter berdasarkan status siswa
        if ($request->filled('student_statuses')) {
            $query->where('student_statuses', $request->student_statuses);
        }

        // Eksekusi query untuk mendapatkan data siswa yang difilter
        $students = $query->orderBy('school_class_id', 'asc')  // Urutkan berdasarkan kelas
            ->get();  // Pastikan query dieksekusi

        // Ambil subjects yang terkait dengan jurusan dan tahun masuk jika major_id tersedia
        $subjects = Subject::whereExists(function ($query) use ($request) {
            $query->select(DB::raw(1))
                ->from('major_subjects')
                ->where('major_subjects.entry_year_id', $request->entry_year_id)
                ->whereColumn('subjects.id', 'major_subjects.subject_id');

            if ($request->filled('major_id')) {
                $query->where('major_subjects.major_id', $request->major_id);
            }
        })->get();

        // Ambil semua semester
        $semesters = Semester::all();

        // Export ke Excel dengan file yang difilter

        // Menyusun nama file berdasarkan filter
        $fileName = 'Data Siswa_';
        if ($request->filled('student_id')) {
            $student = Student::find($request->student_id)->first();
            $fileName .= $student->nis . '_' . $student->nis . '_';
        }
        if ($request->filled('student_statuses')) {
            $fileName .= 'Status_' . $request->student_statuses . '_';
        }
        if ($request->filled('entry_year_id')) {
            $entryYear = EntryYear::find($request->entry_year_id)->first();
            $fileName .= $entryYear->year . '_';
        }
        if ($request->filled('major_id')) {
            $major = Major::find($request->major_id)->first();
            $fileName .= '' . $major->name . '_';
        }
        if ($request->filled('school_class_id')) {
            $schoolClass = SchoolClass::find($request->school_class_id)->first();
            $fileName .=   $schoolClass->name . '_';
        }

        // Menghapus underscore terakhir
        $fileName = rtrim($fileName, '_') . '.xlsx';

        // Mengunduh file Excel
        return Excel::download(new StudentsExcelExport($students, $subjects, $semesters), $fileName);
    }


    public function mergeWordToPdf(Request $request)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $content = '';
        $images = [];

        foreach ($request->file('documents') as $file) {
            $docPath = $file->getPathName();
            $loadedWord = IOFactory::load($docPath);

            foreach ($loadedWord->getSections() as $loadedSection) {
                foreach ($loadedSection->getElements() as $element) {
                    $content .= $this->extractText($element);
                }
            }
        }

        // Generate PDF
        $pdf = Pdf::loadView('students_exports.pdf_template', ['wordContent' => $content, 'images' => $images]);
        return $pdf->download('merged.pdf');
    }


    public function extractText($element)
    {
        $textContent = '';

        if ($element instanceof TextRun) {
            foreach ($element->getElements() as $subElement) {
                if ($subElement instanceof Text) {
                    $textContent .= $subElement->getText() . " ";
                } elseif ($subElement instanceof Image) {
                    $imageData = $subElement->getImageStringData();
                    $imageName = uniqid() . '.png';
                    Storage::put('public/images/' . $imageName, $imageData);
                    $images[] = asset('storage/images/' . $imageName);
                } elseif ($subElement instanceof TextBreak) {
                    // Handle line break (TextBreak)
                    $textContent .= "\n";
                }
            }
        } elseif ($element instanceof Text) {
            $textContent .= $element->getText() . "\n";
        } elseif ($element instanceof Paragraph) {
            foreach ($element->getElements() as $subElement) {
                $textContent .= $this->extractText($subElement); // Handle nested elements
            }
        } elseif ($element instanceof Table) {
            foreach ($element->getRows() as $row) {
                foreach ($row->getCells() as $cell) {
                    foreach ($cell->getElements() as $cellElement) {
                        $textContent .= $this->extractText($cellElement); // Handle table cells
                    }
                }
            }
        } elseif ($element instanceof TextBreak) {
            // Handle line break (TextBreak)
            $textContent .= "\n";
        }

        return $textContent;
    }

    public function mergeWordFiles(Request $request)
    {
        // Validasi input file
        $request->validate([
            'file1' => 'required|mimes:docx',
            'file2' => 'required|mimes:docx',
        ]);

        // Dapatkan file dari request
        $file1 = $request->file('file1');
        $file2 = $request->file('file2');

        // Baca file Word menggunakan PHPWord
        $phpWord1 = IOFactory::load($file1->getPathName(), 'Word2007');
        $phpWord2 = IOFactory::load($file2->getPathName(), 'Word2007');

        // Membuat dokumen baru untuk hasil penggabungan
        $phpWord = new PhpWord();

        // Gabungkan isi dari kedua dokumen
        foreach ($phpWord1->getSections() as $section) {
            $phpWord->addSection();
            foreach ($section->getElements() as $element) {
                $phpWord->getSections()[0]->addElement($element);
            }
        }

        foreach ($phpWord2->getSections() as $section) {
            $phpWord->addSection();
            foreach ($section->getElements() as $element) {
                $phpWord->getSections()[1]->addElement($element);
            }
        }

        // Simpan hasil gabungan ke file baru
        $fileName = 'merged.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        // Kembalikan file hasil gabungan sebagai response download
        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    public function merge(Request $request)
    {
        // Validasi input untuk memastikan file yang diunggah
        $request->validate([
            'files.*' => 'required|file|mimes:docx'
        ]);

        // Tempat untuk menyimpan file yang diunggah sementara
        $uploadFolder = 'uploads';
        $uploadedFiles = [];

        // Simpan file ke folder sementara
        foreach ($request->file('files') as $file) {
            $filePath = $file->store($uploadFolder);
            $uploadedFiles[] = storage_path('app/' . $filePath);
        }

        // Panggil script Python untuk menggabungkan file
        $outputFile = 'C:\Documents\Merged\merged.docx';
        $this->runPythonScript($uploadedFiles, $outputFile);

        // Berikan file hasil gabungan sebagai respons download
        return response()->download($outputFile);
    }

    private function runPythonScript($files, $outputFile)
    {
        // Gabungkan daftar file menjadi string untuk dikirim ke Python
        $fileList = implode(' ', $files);

        // Menjalankan script Python menggunakan exec
        $command = "python3 python_scripts/merge.py $fileList $outputFile";
        exec($command);
    }
}
