<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Course;
use App\Models\AcademicTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (Auth::check()) {
            if (Auth::user()->hasrole('teacher') || Auth::user()->hasrole('superadministrator')) {
                // Fetch Teachers & Students
                $totalTeachers = User::whereHasRole('teacher')->count();
                $totalStudents = User::whereHasRole('student')->count();

                // Fetch Total Subjects
                $totalSubjects = Subject::count();

                // Enlistment Status
                $studentsEnlisted = User::whereHasRole('student')->where('current_subjects_status', '>=', 2)->count();
                $studentsNotEnlisted = User::whereHasRole('student')->where('current_subjects_status', '=', [0,1])->count();
                $pending = User::whereHasRole('student')->where('current_subjects_status', '=', 1)->count();

                // Student Distribution Per Year Level
                $yearLevelCounts = [
                    User::whereHasRole('student')->where('year_level', '=', '1')->count(),
                    User::whereHasRole('student')->where('year_level', '=','2')->count(),
                    User::whereHasRole('student')->where('year_level', '=','3')->count(),
                    User::whereHasRole('student')->where('year_level', '=','4')->count(),
                ];

                $academicTerm = AcademicTerm::find(1);
                $courses = Course::all();

                $schoolYears = Grade::select('school_year')
                        ->distinct()
                        ->get()
                        ->pluck('school_year');

                return view('teacher.dashboard', compact(
                    'totalTeachers', 'totalStudents', 'totalSubjects',
                    'yearLevelCounts', 'academicTerm', 'studentsEnlisted', 'studentsNotEnlisted', 'courses', 'pending', 'schoolYears'
                ));
            } else {
                return redirect()->route('st-dashboard');
            }
        } else {
            return redirect()->route('/');
        }
    }

    public function passfail(){
        $subjects = Subject::select('id', 'subject_code')->get();

        // Calculate passed and failed students per subject
        $subjects = $subjects->map(function ($subject) {
            $subject->passed = Grade::where('subject_id', $subject->id)
            ->whereRaw("CAST(grade AS DECIMAL(10,2)) <= 3.0")
            ->count();

            $subject->failed = Grade::where('subject_id', $subject->id)
                ->whereRaw("CAST(grade AS DECIMAL(10,2)) > 3.0")
                ->count();
            $subject->total = $subject->passed + $subject->failed;
            return $subject;
        });
    
        return response()->json($subjects);
    }

    public function fetchEnlistmentData(Request $request) {
        $yearLevel = $request->input('year_level');
        $courseId = $request->input('course_id');

        $baseQuery = User::whereHas('roles', function ($q) {
            $q->where('name', 'student');
        });
    
        if ($yearLevel !== "all") {
            $baseQuery->where('year_level', $yearLevel);
        }
    
        if ($courseId !== "all") {
            $baseQuery->where('course_id', $courseId);
        }
    
        $studentsEnlisted = (clone $baseQuery)->where('current_subjects_status', 2)->count();
        $studentsNotEnlisted = (clone $baseQuery)->whereIn('current_subjects_status', [0, 1])->count();
    
        return response()->json([
            'studentsEnlisted' => $studentsEnlisted,
            'studentsNotEnlisted' => $studentsNotEnlisted
        ]);
    }

    public function fetchYearLevelData(Request $request) {
        $courseId = $request->input('course_id');
    
        $query = User::whereHas('roles', function ($q) {
            $q->where('name', 'student');
        });
    
        if ($courseId !== "all") {
            $query->where('course_id', $courseId);
        }
    
        $yearLevelCounts = [
            'First Year'  => (clone $query)->where('year_level', 1)->count(),
            'Second Year' => (clone $query)->where('year_level', 2)->count(),
            'Third Year'  => (clone $query)->where('year_level', 3)->count(),
            'Fourth Year' => (clone $query)->where('year_level', 4)->count(),
        ];
    
        return response()->json(['yearLevelCounts' => array_values($yearLevelCounts)]);
    }

    public function getEnlistedStudents(Request $request) {
        $schoolYear = $request->input('schoolYear');
        $semester = $request->input('semester');
        
        // Query to get the count of students per school year and semester
        $studentsData = Grade::when($semester !== 'all', function ($query) use ($semester) {
                return $query->where('semester', $semester);
            })
            ->select('student_id', 'school_year', 'semester') // Select student_id, school_year, and semester
            ->distinct()
            ->get()
            ->groupBy('school_year'); // Group by school year
        
        // Process the grouped data to count the students per school year
        $studentsCount = $studentsData->map(function($group) {
            return $group->count();
        });
        
        // Prepare labels and data for the chart
        $labels = $studentsCount->keys()->toArray(); // School years as labels (for y-axis)
        $data = $studentsCount->values()->toArray(); // Counts as data (for x-axis)
        
        // Return the data as a JSON response
        return response()->json([
            'labels' => $labels, // School years
            'data' => $data,     // Number of students
        ]);
    }
    
    


    public function downloadReports(){
        if (Auth::check()) {
            if (Auth::user()->hasrole('teacher') || Auth::user()->hasrole('superadministrator')) {
                // Fetch Teachers & Students
                $totalTeachers = User::whereHasRole('teacher')->count();
                $totalStudents = User::whereHasRole('student')->count();

                // Fetch Total Subjects
                $totalSubjects = Subject::count();

                // Enlistment Status
                $studentsEnlisted = User::whereHasRole('student')->where('current_subjects_status', '>=', 2)->count();
                $studentsNotEnlisted = User::whereHasRole('student')->where('current_subjects_status', '=', [0,1])->count();
                $pending = User::whereHasRole('student')->where('current_subjects_status', '=', 1)->count();

                // Student Distribution Per Year Level
                $yearLevelCounts = [
                    User::whereHasRole('student')->where('year_level', '=', '1')->count(),
                    User::whereHasRole('student')->where('year_level', '=','2')->count(),
                    User::whereHasRole('student')->where('year_level', '=','3')->count(),
                    User::whereHasRole('student')->where('year_level', '=','4')->count(),
                ];

                $academicTerm = AcademicTerm::find(1);
                $courses = Course::all();

                return view('teacher.reports', compact(
                    'totalTeachers', 'totalStudents', 'totalSubjects',
                    'yearLevelCounts', 'academicTerm', 'studentsEnlisted', 'studentsNotEnlisted', 'courses', 'pending'
                ));
            }
        }
    }
    
}
