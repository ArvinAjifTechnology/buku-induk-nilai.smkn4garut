<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Major;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\EntryYear;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardController extends Controller
{
    /**
     * Initialize the controller with middleware to require authentication.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the dashboard with statistics and charts.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Count the number of students, majors, classes, subjects, and entry years
        $studentCount = Student::count();
        $userCount = User::count();
        $majorCount = Major::count();
        $schoolClassCount = SchoolClass::count();
        $subjectCount = Subject::count();
        $entryYearCount = EntryYear::count();
        $entryYears = EntryYear::all();
        $schoolClasses = SchoolClass::all();
        $semesters = Semester::all();
        $majors = Major::all();


        // Get selected filters from the request or set default values
        $selectedEntryYear = $request->input('entry_year', null);
        $selectedMajor = $request->input('major', null);
        $selectedSchoolClass = $request->input('school_class', null);
        $selectedSemester = $request->input('semester', null);
        $selectedSubject = $request->input('subject', null);
        $subjects = Subject::whereExists(function ($query) use ($selectedEntryYear, $selectedMajor) {
            $query->select(DB::raw(1))
            ->from('major_subjects')
            ->where('major_subjects.entry_year_id', $selectedEntryYear)
            ->whereColumn('subjects.id', 'major_subjects.subject_id')
            ->where('major_subjects.major_id', $selectedMajor);
        })->get();

        // Buat Chart
        $studentStatusesChart = $this->createStudentStatusChart();
        $studentGrowthChart = $this->createStudentGrowthChart();
        $genderDistributionChart = $this->createGenderDistributionChart();
        $statisticGradeChart = $this->createGradeStatistic($request);
        $subjectCompletionChart = $this->createSubjectCompletion($request);
        $gradeRangeChart = $this->createGradeRangeChart($request);

        // Pass the data to the dashboard view
        return view('dashboard.index', array_merge(
            compact(
                'studentStatusesChart',
                'studentCount',
                'userCount',
                'majorCount',
                'schoolClassCount',
                'subjectCount',
                'entryYearCount',
                'studentGrowthChart',
                'genderDistributionChart',
                'statisticGradeChart',
                'subjectCompletionChart',
                'gradeRangeChart',
                'selectedEntryYear',
                'selectedMajor',
                'selectedSchoolClass',
                'selectedSemester', // Add this line
                'selectedSubject', // Add this line
            ),
            $statisticGradeChart,
            $subjectCompletionChart, // Add this line
            compact('entryYears', 'majors', 'schoolClasses', 'semesters', 'subjects') // Add this line
        ));
    }

    public function getClasses($majorId)
    {
        $classes = SchoolClass::where('major_id', $majorId)->get();
        if ($classes->isEmpty()) {
            return response()->json([], 200); // Berikan respons kosong jika tidak ada kelas
        }

        return response()->json($classes, 200);
    }

    public function getSubjects($classId, Request $request)
    {
        // Mengambil major_id dari student dengan entry_year_id dan school_class_id yang diberikan
        $entryYearId = $request->input('entry_year_id'); // Misalnya, ambil dari permintaan
        $majorIds = Major::where('entry_year_id', $entryYearId)
            ->pluck('id')->toArray();

        // Mengambil mata pelajaran yang terkait dengan major_id dan kelas
        $subjects = Subject::whereIn('id', function ($query) use ($majorIds) {
            $query->select('subject_id')
            ->from('major_subjects')
            ->whereIn('major_id', $majorIds);
        })->whereHas('schoolClasses', function ($query) use ($classId) {
            $query->where('id', $classId);
        })->get();

        return response()->json($subjects);
    }


    /**
     * Create a chart showing the student statuses by entry year.
     *
     * @return \ArielMejiaDev\LarapexCharts\LarapexChart
     */
    protected function createStudentStatusChart()
    {
        // Fetch student data grouped by entry year and status
        $students = Student::selectRaw('entry_year_id, student_statuses, count(*) as total')
            ->orderBy('entry_year_id', 'desc')
            ->groupBy('entry_year_id', 'student_statuses')
            ->get();

        // Fetch all entry years, sorted in descending order
        $allYears = EntryYear::orderBy('year', 'desc')->pluck('year', 'id')->toArray();

        // Extract years and their IDs
        $years = array_values($allYears);
        $yearIds = array_keys($allYears);

        // Define student statuses to include in the chart
        $statuses = ['active', 'graduated', 'dropped_out'];
        $statusData = [];

        // Populate status data by year
        foreach ($statuses as $status) {
            $statusData[$status] = array_map(function ($yearId) use ($status, $students) {
                return $students->where('entry_year_id', $yearId)
                ->where('student_statuses', $status)
                ->sum('total');
            }, $yearIds);
        }

        // Create the bar chart
        $chart = (new LarapexChart)->barChart()
            ->setTitle('Status Siswa Berdasarkan Tahun Masuk')
            ->addData('Aktif', $statusData['active'])
            ->addData('Lulus', $statusData['graduated'])
            ->addData('Keluar', $statusData['dropped_out'])
            ->setLabels($years)
            ->setHeight(400)
            ->setWidth(6000); // Adjust width to fit data

        return $chart;
    }

    protected function createStudentGrowthChart()
    {
        // Ambil data dari 5 angkatan terakhir
        $entryYears = EntryYear::orderBy('year', 'desc')->take(5)->pluck('year', 'id');

        // Membuat array kosong untuk menyimpan data jumlah siswa per tahun
        $studentCounts = [];

        foreach ($entryYears as $yearId => $year) {
            // Menghitung jumlah siswa untuk setiap angkatan
            $studentCounts[] = Student::where('entry_year_id', $yearId)->count();
        }

        // Membalik urutan agar dari tahun terlama ke terbaru
        $studentCounts = array_reverse($studentCounts);
        $years = array_reverse($entryYears->values()->toArray());

        // Membuat grafik menggunakan LarapexChart
        $chart = (new LarapexChart)->lineChart()
            ->setTitle('Student Growth Over Last 5 Entry Years')
            ->addData('Number of Students', $studentCounts)
            ->setXAxis($years)
            ->setHeight(200);

        return $chart;
    }

    protected function createGenderDistributionChart()
    {
        // Ambil data dari 3 angkatan terakhir
        $entryYears = EntryYear::orderBy('year', 'desc')->take(3)->pluck('year', 'id');

        // Array untuk menyimpan jumlah siswa laki-laki dan perempuan
        $maleCounts = [];
        $femaleCounts = [];

        foreach ($entryYears as $yearId => $year) {
            // Menghitung jumlah siswa laki-laki dan perempuan untuk setiap angkatan
            $maleCounts[] = Student::where('entry_year_id', $yearId)
            ->where('gender', 'male')
            ->count();
            $femaleCounts[] = Student::where('entry_year_id', $yearId)
            ->where('gender', 'female')
            ->count();
        }

        // Membalik urutan agar dari tahun terlama ke terbaru
        $maleCounts = array_reverse($maleCounts);
        $femaleCounts = array_reverse($femaleCounts);
        $years = array_reverse($entryYears->values()->toArray());

        // Membuat grafik menggunakan LarapexChart
        $chart = (new LarapexChart)->barChart()
            ->setTitle('Student Gender Distribution Over Last 3 Entry Years')
            ->addData('Male', $maleCounts)
            ->addData('Female', $femaleCounts)
            ->setXAxis($years)
            ->setHeight(300);

        return $chart;
    }

    protected function createGradeStatistic(Request $request)
    {
        $entryYears = EntryYear::all();
        $majors = Major::all();

        $selectedEntryYear = $request->input('entry_year', $entryYears->first()->id);
        $selectedMajor = $request->input('major', $majors->first()->id);

        $grades = Grade::whereHas('subject')
            ->whereHas('student', function ($query) use ($selectedMajor) {
                $query->where('major_id', $selectedMajor);
            })
            ->whereHas('student', function ($query) use ($selectedEntryYear) {
                $query->where('entry_year_id', $selectedEntryYear);
            })
            ->get();

        // Get unique subject names as a Laravel Collection
        $subjectNames = $grades->pluck('subject.name')->unique();

        // Map scores using Laravel Collection methods
        $subjectScores = $subjectNames->map(function ($subjectName) use ($grades) {
            return $grades->where('subject.name', $subjectName)->pluck('score')->average();
        });

        // Create the chart
        // Determine chart width based on number of subjects
        $numSubjects = $subjectNames->count();
        $chartWidth = $numSubjects * 700; // Adjust the multiplier as needed

        // Set a maximum width to prevent the chart from being too wide
        $chartWidth = min($chartWidth, 2000); // 2000px as the max width

        $statisticGradeChart = (new LarapexChart)
            ->setType('bar')
            ->setTitle('Rata-Rata Nilai per Mata Pelajaran')
            ->setLabels($subjectNames->values()->toArray())
            ->setDataset([
                [
                    'name' => 'Nilai',
                    'data' => $subjectScores->values()->toArray()
                ]
            ])
            ->setHeight(600)
            ->setWidth($chartWidth);

        return [
            'statisticGradeChart' => $statisticGradeChart,
            'entryYears' => $entryYears,
            'majors' => $majors,
            'selectedEntryYear' => $selectedEntryYear,
            'selectedMajor' => $selectedMajor
        ];
    }

    protected function createSubjectCompletion(Request $request)
    {
        // Get selected filters from request
        $selectedEntryYear = $request->input('entry_year');
        $selectedMajor = $request->input('major');
        $selectedSemester = $request->input('semester');
        $selectedSchoolClass = $request->input('school_class');

        // Initialize arrays for chart data
        $subjectNames = [];
        $completedCounts = [];
        $notCompletedCounts = [];

        // Handle case where no filter is applied
        if ($selectedEntryYear && $selectedMajor && $selectedSemester && $selectedSchoolClass) {
            // Get all subjects and their completion status for the selected filters
            $subjects = Subject::whereHas('majors', function ($query) use ($selectedMajor) {
                $query->where('major_id', $selectedMajor);
            })
            ->with(['grades' => function ($query) use (
                $selectedEntryYear,
                $selectedSemester,
                $selectedSchoolClass
            ) {
                $query->whereHas('student', function ($query) use ($selectedEntryYear, $selectedSemester, $selectedSchoolClass) {
                    $query->where('entry_year_id', $selectedEntryYear)
                    ->where('semester_id', $selectedSemester)
                    ->where('school_class_id', $selectedSchoolClass);
                });
            }])->get();



            foreach ($subjects as $subject) {
                $subjectNames[] = $subject->name;

                $totalStudents = Student::where('entry_year_id', $selectedEntryYear)
                    ->where('major_id', $selectedMajor)
                    ->where('school_class_id', $selectedSchoolClass)
                    ->count();

                $completedCount = $subject->grades->count();
                $notCompletedCount = $totalStudents - $completedCount;

                $completedCounts[] = $completedCount;
                $notCompletedCounts[] = $notCompletedCount;
            }
        }

        // If no data available, create a default chart
        if (empty($subjectNames)) {
            $subjectNames = ['No Data'];
            $completedCounts = [0];
            $notCompletedCounts = [0];
        }

        // Create the bar chart
        $chart = (new LarapexChart)->barChart()
            ->setTitle('Status Nilai Mata Pelajaran per Kelas')
            ->addData('Completed', $completedCounts)
            ->addData('Not Completed', $notCompletedCounts)
            ->setLabels($subjectNames)
            ->setHeight(600)
            ->setWidth(4000);

        return [
            'subjectCompletionChart' => $chart
        ];
    }
    protected function createGradeRangeChart(Request $request)
    {
        // Ambil input dari filter
        $selectedEntryYear = $request->input('entry_year');
        $selectedMajor = $request->input('major');
        $selectedSemester = $request->input('semester');
        $selectedSchoolClass = $request->input('school_class');
        $selectedSubject = $request->input('subject');

        // Query untuk mengambil data nilai berdasarkan filter
        $gradesQuery = Grade::query();

        if ($selectedSubject) {
            $gradesQuery->where('subject_id', $selectedSubject);
        }
        if ($selectedSemester) {
            $gradesQuery->where('semester_id', $selectedSemester);
        }
        if ($selectedSchoolClass) {
            $gradesQuery->whereHas('student', function ($query) use ($selectedSchoolClass) {
                $query->where('school_class_id', $selectedSchoolClass);
            });
        }
        if ($selectedEntryYear) {
            $gradesQuery->whereHas('student', function ($query) use ($selectedEntryYear) {
                $query->where('entry_year_id', $selectedEntryYear);
            });
        }
        if ($selectedMajor) {
            $gradesQuery->whereHas('student', function ($query) use ($selectedMajor) {
                $query->where('major_id', $selectedMajor);
            });
        }

        // Ambil semua skor sebagai collection
        $grades = $gradesQuery->pluck('score');

        // Hitung jumlah siswa untuk setiap rentang nilai per 10 poin
        $ranges = [
            '0-10'   => $grades->filter(fn($score) => $score >= 0 && $score <= 10)->count(),
            '11-20'  => $grades->filter(fn($score) => $score >= 11 && $score <= 20)->count(),
            '21-30'  => $grades->filter(fn($score) => $score >= 21 && $score <= 30)->count(),
            '31-40'  => $grades->filter(fn($score) => $score >= 31 && $score <= 40)->count(),
            '41-50'  => $grades->filter(fn($score) => $score >= 41 && $score <= 50)->count(),
            '51-60'  => $grades->filter(fn($score) => $score >= 51 && $score <= 60)->count(),
            '61-70'  => $grades->filter(fn($score) => $score >= 61 && $score <= 70)->count(),
            '71-80'  => $grades->filter(fn($score) => $score >= 71 && $score <= 80)->count(),
            '81-90'  => $grades->filter(fn($score) => $score >= 81 && $score <= 90)->count(),
            '91-100' => $grades->filter(fn($score) => $score >= 91 && $score <= 100)->count(),
        ];

        // Buat chart dengan LarapexChart
        $chart = (new LarapexChart)->barChart()
            ->setTitle('Distribusi Nilai Siswa per Range 10')
            ->addData('Jumlah Siswa', array_values($ranges))
            ->setLabels(array_keys($ranges))
            ->setHeight(400)
            ->setWidth(600);

        return $chart;  // Kembalikan objek chart
    }

}
