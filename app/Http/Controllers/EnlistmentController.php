<?php

namespace App\Http\Controllers;
use App\Models\AcademicTerm;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EnlistmentController extends Controller
{
    public function index(){
        $academicTerm = AcademicTerm::find(1);
        $allSubjects = Subject::all();
        $courses = Course::all();
        return view('teacher.enlistment', compact('allSubjects', 'academicTerm', 'courses'));
    } 
    public function fetchSubjects($id){

        $student = User::find($id);

        $subj_ids = explode(',', $student->current_subjects);
        $subjects = array();

        foreach ($subj_ids as $subj_id) {
            $subject = Subject::find($subj_id);
            array_push($subjects, $subject);
        }

        return response()->json([
            'status'=>200,
            'subjects'=>$subjects,
            'student'=>$student,
        ]);

    }

    public function savesubjects(Request $request, $id){
        $subject_ids = $request->subjectsSelected;

        $student = User::find($id);

        $currentSubjects = "";
        if($subject_ids != null){
            $counter = 0;
            $count = count($subject_ids);
            foreach($subject_ids as $subject_id){
                $counter += 1;
                if($count == $counter){
                    $currentSubjects .= $subject_id;
                }else{
                    $currentSubjects .= $subject_id.",";
                }
            }

            if(Auth::user()->hasRole('student')){
                $student->current_subjects_status = 1;
            }elseif(Auth::user()->hasRole('superadministrator') || Auth::user()->hasRole('teacher')){
                $student->current_subjects_status = 2;
            }

        }else{
            $student->current_subjects_status = 0;
        }
        
        $student->current_subjects = $currentSubjects;
        $student->update();
        return response()->json([
            'status'=>200,
            'message'=>"Saved Successfully",
        ]);
    }
}
