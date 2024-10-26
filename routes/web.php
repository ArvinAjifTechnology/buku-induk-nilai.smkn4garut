<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntryYearController;
use App\Http\Controllers\ManageGradeController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SubjectTypeController;
use App\Http\Controllers\StudentExportController;
use App\Http\Controllers\StudentFilterController;
use App\Http\Controllers\GraduationYearController;
use App\Http\Controllers\ManageSubjectAndMajorController;
use App\Http\Controllers\ManageSubjectAndMajorsController;
use App\Http\Controllers\Api\GradeController as ApiGradeController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Auth::routes(['register' => false, 'verify' => false]);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('home')->middleware('auth');
Route::get('/get-classes/{majorId}', [DashboardController::class, 'getClasses'])->name('get.classes');
Route::get('/get-subjects/{classId}', [DashboardController::class, 'getSubjects'])->name('get.subjects');
Route::middleware(['role:admin'])->group(function () {
    Route::resource('users', UserController::class)->except('destroy');
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::resource('students', StudentController::class);
    Route::get('/grades/form/{students}', [StudentController::class, 'studentGradesForm'])->name('students.grades.form');
    Route::post('/students/grades', [StudentController::class, 'studentGradesStore'])->name('students.grades.submit');
    Route::post('/students/upload-photo', [StudentController::class, 'uploadPhoto'])->name('students.upload-photo.submit');
    Route::get('/student-search', [StudentFilterController::class, 'search'])->name('students.search');
    Route::get('/student-filter', [StudentFilterController::class, 'filter'])->name('students.filter');
    Route::get('/student-export', [StudentFilterController::class, 'export'])->name('students.export');
    Route::post('/export-photo', [StudentController::class, 'exportPhotos'])->name('export.photo.process');
    Route::get('/api/get-major-by-class/{classId}', [StudentController::class, 'getMajorByClass']);
    Route::match(['get', 'post'], '/profile', ProfileController::class, 'index')->name('profile.index');
    Route::resource('majors', MajorController::class);
    Route::resource('school_classes', SchoolClassController::class);
    Route::resource('subject_types', SubjectTypeController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('grades', GradeController::class);
    Route::resource('entry-years', EntryYearController::class)->except('destroy');
    Route::resource('graduation-years', GraduationYearController::class)->except('destroy');
    Route::get('/manage-subject-and-major', [ManageSubjectAndMajorController::class, 'index'])->name('manage-subject-and-major.index');
    Route::get('/manage-subject-and-major/majors/{entryYear}', [ManageSubjectAndMajorController::class, 'showMajors'])->name('manage-subject-and-major.majors');
    Route::get('/manage-subject-and-major/subjects/{entryYear}/{major}', [ManageSubjectAndMajorController::class, 'showSubjects'])->name('manage-subject-and-major.subjects');
    Route::get('/manage-subject-and-major/add-existing-subjects/{entryYear}/{major_id}', [ManageSubjectAndMajorController::class, 'showAddExistingSubjectsForm'])->name('manage-subject-and-major.add-existing-subjects');
    Route::post('/manage-subject-and-major/add-existing-subjects', [ManageSubjectAndMajorController::class, 'storeAddExistingSubjects'])->name('manage-subject-and-major.store-add-existing-subjects');
    Route::get('/manage-subject-and-major/get-majors/{entry_year_id}', [ManageSubjectAndMajorController::class, 'getMajorsByEntryYear'])->name('manage-subject-and-major.get-majors');
    Route::get('/manage-subject-and-major/assign-majors', [ManageSubjectAndMajorController::class, 'showAssignMajorsForm'])->name('manage-subject-and-major.assign-majors');
    Route::post('/manage-subject-and-major/assign-majors', [ManageSubjectAndMajorController::class, 'storeAssignMajors'])->name('manage-subject-and-major.store-assign-majors');
    // Route::post('students-filter', [StudentExportController::class, 'index'])->name('students.filter');
    // Route::get('/students/export', [ManageSubjectAndMajorController::class, 'storeAssignMajors'])->name('manage-subject-and-major.store-assign-majors');

    // Import
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
    Route::post('/majors/import', [MajorController::class, 'import'])->name('majors.import');
    Route::post('/subjects/import', [SubjectController::class, 'import'])->name('subjects.import');
    Route::post('/school_classes/import', [SchoolClassController::class, 'import'])->name('school_classes.import');

    // Export
    Route::get('/student-template-download', [TemplateController::class, 'studentTemplateDownload'])->name('student-template-download');
    Route::get('/majors-template-download', [TemplateController::class, 'majorsTemplateDownload'])->name('majors-template-download');
    Route::get('/subjects-template-download', [TemplateController::class, 'subjectsTemplateDownload'])->name('subjects-template-download');
    Route::get('/school-classes-template-download', [TemplateController::class, 'schoolClassesTemplateDownload'])->name('school-classes-template-download');
    Route::post('/student-grades-template-download/{student}', [TemplateController::class, 'studentGradesTemplateDownload'])->name('student-grades-template-download');
    // Route::get('/download-template', [TemplateController::class, 'downloadTemplate'])
    // ->name('download.template');

    // Route::middleware('auth')->group(function () {
    //     Route::get('api/grades/{studentId}/options', [ApiGradeController::class, 'getOptionsByStudent']);
    // });
});

Route::middleware(['role:admin,student_affairs_staff'])->group(function () {
    Route::get('manage-grades', [ManageGradeController::class, 'index'])->name('manage-grades.index');
    Route::get('manage-grades/majors/{entryYear}', [ManageGradeController::class, 'showMajors'])->name('manage-grades.majors');
    Route::get('manage-grades/school-classes/{entryYear}', [ManageGradeController::class, 'showSchoolClasses'])->name('manage-grades.school-classes');
    Route::get('manage-grades/students-by-major/{entryYear}/{major}', [ManageGradeController::class, 'showStudentsByMajorAndEntryYear'])->name('manage-grades.students-by-major');
    Route::get('manage-grades/students-by-class/{schoolClass}/{entryYear}/{major}', [ManageGradeController::class, 'showStudentsByClassMajorAndEntryYear'])->name('manage-grades.students-by-class');
    Route::get('/manage-grades/form/{schoolClassUniqid}/{entryYearUniqid}/{majorUniqid}', [ManageGradeController::class, 'showFormByClassEntryYearMajor'])->name('manage-grades.form');
    Route::get('/manage-grades/form/{majorUniqid}/{entryYearUniqid}', [ManageGradeController::class, 'showFormByMajor'])->name('manage-grades.form-by-major');
    Route::post('/manage-grades/store', [ManageGradeController::class, 'store'])->name('manage-grades.store');
    Route::get('students-exports', [StudentExportController::class, 'index'])->name('students.exports');
    Route::get('students-export-word', [StudentExportController::class, 'exportWord'])->name('students-export-word');
    Route::get('students-export-excel', [StudentExportController::class, 'exportExcel'])->name('students-export-excel');
    Route::post('students-export-pdf', [StudentExportController::class, 'mergeWordToPdf'])->name('merge-word-pdf');
    Route::post('/merge-word', [StudentExportController::class, 'mergeWordFiles'])->name('merge-word-files');
    Route::post('/merge', [StudentExportController::class, 'merge'])->name('merge');

    //import
    Route::post('/students/{student}/import-grades', [StudentController::class, 'importGrades'])->name('students.import-grades');
    Route::post('/students-grades-import', [ManageGradeController::class, 'import'])->name('students-grades-import');
    Route::post('/import/preview', [ManageGradeController::class, 'previewImport'])->name('students-grades-e-raport-preview-import');
    Route::get('/import-preview', [ManageGradeController::class, 'previewFile'])->name('students-grades-e-raport-preview-file');
    Route::post('/import/confirm', [ManageGradeController::class, 'confirmImport'])->name('students-grades-e-raport-confirm-import');
    Route::post('/import-cancel', [ManageGradeController::class, 'cancelImport'])->name('students-grades-e-raport-cancel-import');

    //export
    Route::get('/export-students-grades/{schoolClassId}/{entryYearId}', [TemplateController::class, 'studentsGradesTemplateDownload'])->name('export.students.grades');
    Route::get('/export-students-grades-by-major/{majorId}/{entryYearId}', [TemplateController::class, 'studentsGradesMajorTemplateDownload'])->name('export.major-students.grades');
});
