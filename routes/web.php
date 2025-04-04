<?php

use App\Http\Controllers\AcademicTermController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnlistmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ManageStudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
}); 

Route::group(['middleware' => ['auth', 'role:superadministrator']] ,function () {

    Route::get('/academicterm', [AcademicTermController::class, 'index'])->name('academicterm.index');
    Route::post('/academicyear/set-academicterm', [AcademicTermController::class, 'set'])->name('set.academicterm');
    Route::get('/academicterm/activate-grade', [AcademicTermController::class, 'activateGrade'])->name('activate.grade');
    Route::get('/academicterm/deactivate-grade', [AcademicTermController::class, 'deactivateGrade'])->name('deactivate.grade');
    
    
});

// Student routes
Route::group(['middleware' => ['auth', 'verified', 'role:student']] ,function () {
    
    Route::get('/st-dashboard', [StudentController::class, 'index'])->name('st-dashboard');
    Route::get('/subjects-taken', [StudentController::class, 'subjectsTaken'])->name('subjects-taken');
    Route::post('/student/add-subject', [StudentController::class, 'addsubject'])->name('student.addsubjects');
    Route::post('/student/save-grades', [StudentController::class, 'savegrades'])->name('student.savegrades');
    Route::get('/student/lock-grades', [StudentController::class, 'lockgrades'])->name('student.lockgrades');

    Route::get('/personality-test-results', [StudentController::class, 'personalitytest'])->name('personality-test-results');
    Route::post('/student/submit-test-score', [StudentController::class, 'submitscore'])->name('student.submitscore');

});
// Personality Trait View both for student and teacher
Route::get('/personality-test-results/get-test-results/{id}', [StudentController::class, 'getTestResults'])->name('get-test-results');
// Add Subject Both in student and teacher
Route::post('/student/add-subject', [StudentController::class, 'addsubject'])->name('student.addsubjects');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::group(['middleware' => ['auth', 'role:teacher||superadministrator']] ,function () {
    Route::get('/download-reports', [DashboardController::class, 'downloadReports'])->name('dashboard.downloadReports');
    Route::get('/pass-fail-data', [DashboardController::class, 'passfail'])->name('dashboard.passfail');
    Route::get('/fetch-enlistment-data', [DashboardController::class, 'fetchEnlistmentData'])->name('fetchEnlistmentData');
    Route::get('/chart/enlisted-students', [DashboardController::class, 'getEnlistedStudents'])->name('enlisted-students');

    Route::get('/fetch-year-level-data', [DashboardController::class, 'fetchYearLevelData'])->name('fetch.year.level.data');

 
    // CRUD routes for SUBJECT
    Route::get('/subjects', [SubjectController::class, 'index'])->name('index.subject');
    Route::post('/subjects/save-subject', [SubjectController::class, 'save'])->name('save.subject');
    Route::get('/subjects/fetch-subjects', [SubjectController::class, 'fetch'])->name('fetch.subject');
    Route::get('/subjects/edit-subject/{id}', [SubjectController::class, 'edit'])->name('edit.subject');
    Route::post('/subjects/update-subject', [SubjectController::class, 'update'])->name('update.subject');
    Route::get('/subjects/delete-subject/{id}', [SubjectController::class, 'delete'])->name('delete.subject');

    // Import Subjects
    Route::post('/subjects/import-subjects', [SubjectController::class, 'import'])->name('import.subjects');


    Route::get('/pre-requisites', function () {
        return view('teacher.pre-requisites');
    })->name('pre-requisites');
    

    // Manage Students Routes
    Route::get('/students', [ManageStudentController::class, 'index'])->name('index.student');
    // Import Students
    Route::post('/students/import-students', [ManageStudentController::class, 'import'])->name('import.students');
    Route::get('/students/fetch-students', [ManageStudentController::class, 'fetch'])->name('fetch.students');
    Route::post('/students/save-student', [ManageStudentController::class, 'save'])->name('students.save');
    Route::get('/students/edit-student/{id}', [ManageStudentController::class, 'edit'])->name('students.edit');
    Route::post('/students/update-student', [ManageStudentController::class, 'update'])->name('students.update');
    Route::get('/students/delete-student/{id}', [ManageStudentController::class, 'delete'])->name('students.delete');
    

    // Enlistment Routes
    Route::get('/enlistment', [EnlistmentController::class, 'index'])->name('enlistment');

    Route::get('/enlistment/fetch-subjects/{id}', [EnlistmentController::class, 'fetchSubjects'])->name('enlistment.fetchSubjects');
    
    // Prospectus Crud Routes
    Route::get('/subjects/fetch-prospectus', [SubjectController::class, 'fetchProspectus'])->name('subjects.fetchProspectus');
    Route::post('/subjects/save-pros', [SubjectController::class, 'savePros'])->name('subjects.savePros');
    Route::get('/subjects/delete-prospectus/{id}', [SubjectController::class, 'deletePros'])->name('subjects.deletePros');

    // Courses CRUD Routes
    Route::get('/subjects/fetch-courses', [SubjectController::class, 'fetchCourses'])->name('subjects.fetchCourses');
    Route::post('/subjects/save-course', [SubjectController::class, 'saveCourse'])->name('subjects.saveCourse');
    Route::get('/subjects/delete-course/{id}', [SubjectController::class, 'deleteCourse'])->name('subjects.deleteCourse');

    // Teacher Accounts Routes
    Route::get('/teachers', [TeacherController::class, 'index']);

    Route::get('/teachers/fetch-teachers', [TeacherController::class, 'fetch']);
    Route::post('/teachers/save-teacher', [TeacherController::class, 'save']);
    Route::get('/teachers/edit-teacher/{id}', [TeacherController::class, 'edit']);
    Route::post('/teachers/update-teacher', [TeacherController::class, 'update']);
    Route::delete('/teachers/delete-teacher/{id}', [TeacherController::class, 'destroy']);


});
// Save Subject
Route::post('/enlistment/save-subjects/{id}', [EnlistmentController::class, 'savesubjects'])->name('enlistment.savesubjects');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
