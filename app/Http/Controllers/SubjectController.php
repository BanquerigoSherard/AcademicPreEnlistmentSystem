<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Prospectus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subject;
use App\Imports\SubjectImport;
use Maatwebsite\Excel\Facades\Excel;

class SubjectController extends Controller
{

    public function index(){
        $prospectus = Prospectus::all();
        $courses = Course::all();
        $subjects = Subject::all();
        return view('teacher.subjects', compact('prospectus', 'courses', 'subjects'));
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'prospectus'=>'required',
            'course'=>'required',
            'subject_code'=>['required','max:255', 'unique:'.Subject::class],
            'description'=>'required',
            'lec_units'=>'required',
            'lab_units'=>'required',
            'year_lvl'=>'required',
            'semester'=>'required',
        ]); 

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $preRequisites = "";
            foreach($request->input('pre_requisites') as $preRequisite){
                $preRequisites.= $preRequisite.",";
            }

            $subject = new Subject;
            $subject->prospectus_id = htmlspecialchars($request->input('prospectus'));
            $subject->course_id = htmlspecialchars($request->input('course'));
            $subject->subject_code = htmlspecialchars($request->input('subject_code'));
            $subject->description = htmlspecialchars($request->input('description'));
            $subject->lec_units = htmlspecialchars($request->input('lec_units'));
            $subject->lab_units = htmlspecialchars($request->input('lab_units'));
            $subject->pre_requisites = $preRequisites;
            $subject->year_lvl = htmlspecialchars($request->input('year_lvl'));
            $subject->semester = htmlspecialchars($request->input('semester'));

            $subject->save();

            return response()->json([
                'status'=>200,
                'message'=>'Subject Added Successfully',
            ]);

        }
    }

    public function fetch(){

        $subjects = Subject::all();

        if($subjects){
            return response()->json([
                'status'=>200,
                'subjects'=>$subjects,
            ]);
        }

    }
 
    public function edit($id){
        $subject = Subject::find($id);
        $prospectus = Prospectus::all();
        $courses = Course::all();
        $subjects = Subject::all();

        if($subject){
            return response()->json([
                'status'=>200,
                'subject'=>$subject,
                'prospectus'=>$prospectus,
                'courses'=>$courses,
                'subjects'=>$subjects,
            ]);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'prospectus'=>'required',
            'course'=>'required',
            'subject_code'=>['required','max:255'],
            'description'=>'required',
            'lec_units'=>'required',
            'lab_units'=>'required',
            'year_lvl'=>'required',
            'semester'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $id = $request->input('subject_id_edit');
            $subject = Subject::find($id); 

            if($subject){
                $preRequisites = "";
                foreach($request->input('pre_requisites') as $preRequisite){
                    $preRequisites.= $preRequisite.",";
                }

                $subject->prospectus_id = htmlspecialchars($request->input('prospectus'));
                $subject->course_id = htmlspecialchars($request->input('course'));
                $subject->subject_code = htmlspecialchars($request->input('subject_code'));
                $subject->description = htmlspecialchars($request->input('description'));
                $subject->lec_units = htmlspecialchars($request->input('lec_units'));
                $subject->lab_units = htmlspecialchars($request->input('lab_units'));
                $subject->pre_requisites = $preRequisites;
                $subject->year_lvl = htmlspecialchars($request->input('year_lvl'));
                $subject->semester = htmlspecialchars($request->input('semester'));

                $subject->update();

                return response()->json([
                    'status'=>200,
                    'message'=>'Subject Updated Successfully',
                ]);
            }

        }
    }

    public function delete($id){
        $subject = Subject::find($id);

        if($subject){
            $subject->delete();
            return response()->json([
                'status'=>200,
                'message'=> "Subject Deleted Successfully",
            ]);
        }
    }

    public function import(Request $request){
        $validator = Validator::make($request->all(), [
            'importFile'=>'required|file',
        ]);

        if($request->hasFile('importFile')){

            $file = $request->file('importFile');
            Excel::import(new SubjectImport, $file);

            

            return response()->json([
                'status'=>200,
                'message'=>'Subjects imported successfully',
             ]);
        }

    }
}
