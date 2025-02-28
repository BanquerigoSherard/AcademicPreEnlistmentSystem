<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;

class ManageStudentController extends Controller
{
    public function index(){
        return view('teacher.students');
    }

    public function import(Request $request){
        $validator = Validator::make($request->all(), [
            'importFile'=>'required|file',
        ]);

        if($request->hasFile('importFile')){

            $file = $request->file('importFile');
            Excel::import(new StudentImport, $file);filePath: 

            return response()->json([
                'status'=>200,
                'message'=>'Students imported successfully',
             ]);
        }

    }

    public function fetch(){

        $students = User::all();

        if($students){
            return response()->json([
                'status'=>200,
                'students'=>$students,
            ]);
        }

    }


}
