<?php

namespace App\Http\Controllers;

use App\Models\AcademicTerm;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(){
        $yearLvl = Auth::user()->year_level; 
        $academicTerm = AcademicTerm::find(1);
        $allSubjects = Subject::all();
        $subjects = Subject::where([ ['year_lvl', '=', $yearLvl], ['semester', '=', $academicTerm->semester] ])->get();
        $grades = Grade::where([ ['student_id', '=', Auth::user()->id] ])->get();
        $course = Course::find(Auth::user()->course_id);
        
        $subj_ids = explode(',', Auth::user()->current_subjects);
        $selectedSubjIds = [];

        foreach ($subjects as $subject) {
            array_push($selectedSubjIds, $subject->id);
        }

        foreach ($allSubjects as $subject) {
            if(in_array($subject->id, $subj_ids)){
                if(in_array($subject->id, $selectedSubjIds)){
                    // Do Nothing
                }else{
                    $subjects->add($subject);
                }  
            }
        }

        if($subjects){
            return view('student.st-dashboard', compact('subjects', 'course', 'allSubjects', 'academicTerm', 'grades'));
        }
    }

    public function subjectsTaken(){
        $grades = Grade::where([
            ['student_id', '=', Auth::user()->id],
            ['status', '=', '1'],
        ])->get();

        $subjects = [];
        foreach ($grades as $grade) {
            $subject = Subject::find($grade->subject_id);
            array_push($subjects, $subject);
        }
        return view('student.subjects-taken', compact('subjects', 'grades'));
    }

    public function addsubject(Request $request){
        $user = Auth::user();
        $subj_ids = explode(',', $user->current_subjects);
        if($subj_ids[0] == ''){
            $subj_ids = [];
        }

        foreach($request->input('subjects') as $subjectID){
            array_push($subj_ids, $subjectID);
        }

        $user->current_subjects = implode(',', $subj_ids);
        $user->save();

        return response()->json([
            'status'=>200,
            'message'=>'Subject Added Successfully',
        ]);

    }

    public function savegrades(Request $request){
        $grades = $request->input('grades');
        $user = Auth::user();
        $subj_ids = $request->input('subjectIDs');
        $grade_checker = 0;
        $testCounter = 0;
        for($i=0; $i<count($grades); $i++) {
            $gradeCheck = Grade::where([
                ['student_id', '=', $user->id],
                ['subject_id', '=', $subj_ids[$i]],
            ])->first();

            if($grades[$i] != null){
                $grade_checker += 1;
                if($gradeCheck){
                    $gradeCheck->grade = $grades[$i];
                    $gradeCheck->save();
                }else{
                    $grade = new Grade;
                    $grade->student_id = $user->id;
                    $grade->subject_id = $subj_ids[$i];
                    $grade->grade = $grades[$i];
                    $grade->save();
                }  
            }

        }

        if($grade_checker == 0){
            return response()->json([
                'status'=>201,
                'message'=>'Please input your grades',
             ]);
        }else{
            return response()->json([
                'status'=>200,
                'message'=>'Grades Saved Successfully',
            ]);
        }
    }

    public function lockgrades(){
        $user = Auth::user();
        $grades = Grade::where([
            ['student_id', '=', $user->id],
            ['status', '=', '0'],
        ])->get();

        foreach ($grades as $grade) {
            $updateGrade = Grade::find($grade->id);
            $updateGrade->status = "1";
            $updateGrade->update();
        }

        $user->current_subjects = '';
        $user->current_subjects_status = 3;
        $user->save();
        return response()->json([
            'status'=>200,
            'message'=>'Grades locked successfully',
        ]);


    }
}
