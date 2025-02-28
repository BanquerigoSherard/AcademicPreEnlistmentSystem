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
            'schoolyear'=>'required',
            'semester'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $academicTerm = AcademicTerm::where('id', 1)->first();
            if($academicTerm){
                $academicTerm->school_year = htmlspecialchars($request->input('schoolyear'));
                $academicTerm->semester = htmlspecialchars($request->input('semester'));

                $users = User::all();

                foreach ($users as $user) {
                    $selectedUser = User::find($user->id);
                    $selectedUser->current_subjects_status = 0;
                    $selectedUser->update();
                }
    
                $academicTerm->update();
    
                return response()->json([
                    'status'=>200,
                    'message'=>'Academic Term Updated Successfully',
                ]);
            }else{
                return response()->json([
                   'status'=>404,
                   'message'=>'Academic Term not found',
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
