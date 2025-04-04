<?php

namespace App\Http\Controllers;
use App\Models\AcademicTerm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcademicTermController extends Controller
{
    public function index() {
        // Fetch all academic terms from the database
        $academicTerm = AcademicTerm::find(1);

        return view('admin.academicterm', compact('academicTerm'));
    }

    public function set(Request $request){
        $validator = Validator::make($request->all(), [
            'semester' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $academicTerm = AcademicTerm::where('id', 1)->first();
            if ($academicTerm) {
                $studentsWithPendingGrades = User::whereHasRole('student')->where('current_subjects_status', '!=', 3)->get();
    
                if ($studentsWithPendingGrades->isNotEmpty()) {
                    return response()->json([
                        'status' => 403,
                        'message' => 'Failed to set academic term. Some students have not submitted their grades yet.',
                        'students' => $studentsWithPendingGrades,
                    ]);
                }
    
                if ($request->input('schoolyear') != "") {
                    $schoolyear = $request->input('schoolyear') . "-" . strval((int)$request->input('schoolyear') + 1);
                    if($academicTerm->school_year != $request->input('schoolyear') . "-" . strval((int)$request->input('schoolyear') + 1)){
                        $academicTerm->semester = '1';
                    }else{
                        $academicTerm->semester = htmlspecialchars($request->input('semester'));
                    }
                    $academicTerm->school_year = $schoolyear;
                }else{
                    $academicTerm->semester = htmlspecialchars($request->input('semester'));
                }
                
                $academicTerm->grade_status = "Deactivated";
    
                $users = User::all();
    
                foreach ($users as $user) {
                    $user->current_subjects_status = 0;
                    $user->personality_trait_score_status = 0;
                    $user->update();
                }
    
                $academicTerm->update();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Academic Term Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Academic Term not found',
                ]);
            }
        }
    }
    
    public function activateGrade(){
        // Fetch all academic terms from the database
        $academicTerm = AcademicTerm::find(1);

        if($academicTerm){
            $academicTerm->grade_status = "Activated";

            $academicTerm->update();

            return response()->json([
                'status'=>200,
                'message'=>'Grade Input Activated Successfully',
            ]);
        }

    }

    public function deactivateGrade(){
        // Fetch all academic terms from the database
        $academicTerm = AcademicTerm::find(1);

        if($academicTerm){
            $academicTerm->grade_status = "Deactivated";

            $academicTerm->update();

            return response()->json([
                'status'=>200,
                'message'=>'Grade Input Deactivated Successfully',
            ]);
        }

    }
}
