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
            if ($request->has('pre_requisites') && is_array($request->input('pre_requisites'))) {
                $preRequisites = implode(",", array_filter($request->input('pre_requisites')));
            }else{
                $preRequisites = "None";
            }

            // Handle core subject toggle
            $isCoreSubject = $request->has('is_core_subject') ? 1 : 0;

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
            $subject->is_core_subject = $isCoreSubject;

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
                if ($request->has('pre_requisites') && is_array($request->input('pre_requisites'))) {
                    $preRequisites = implode(",", array_filter($request->input('pre_requisites')));
                }else{
                    $preRequisites = "None";
                }

                // Handle core subject toggle
                $isCoreSubject = $request->has('is_core_subject') ? 1 : 0;

                $subject->pre_requisites = $preRequisites;
                $subject->prospectus_id = htmlspecialchars($request->input('prospectus'));
                $subject->course_id = htmlspecialchars($request->input('course'));
                $subject->subject_code = htmlspecialchars($request->input('subject_code'));
                $subject->description = htmlspecialchars($request->input('description'));
                $subject->lec_units = htmlspecialchars($request->input('lec_units'));
                $subject->lab_units = htmlspecialchars($request->input('lab_units'));
                $subject->pre_requisites = $preRequisites;
                $subject->year_lvl = htmlspecialchars($request->input('year_lvl'));
                $subject->semester = htmlspecialchars($request->input('semester'));
                $subject->is_core_subject = $isCoreSubject;

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
            'prospectus'=>'required',
            'course'=>'required',
            'importFile'=>'required|file',
        ]);

        if($request->hasFile('importFile')){
            $pros_id = htmlspecialchars($request->input('prospectus'));
            $course_id = htmlspecialchars($request->input('course'));

            $file = $request->file('importFile');
            Excel::import(new SubjectImport($pros_id, $course_id), $file);

            

            return response()->json([
                'status'=>200,
                'message'=>'Subjects imported successfully',
             ]);
        }

    }


    // Prospectus Functions
    public function fetchProspectus(){

        $prospectus = Prospectus::all();

        if($prospectus){
            return response()->json([
                'status'=>200,
                'prospectus'=>$prospectus,
            ]);
        }

    }

    public function savePros(Request $request){
        $validator = Validator::make($request->all(), [
            'pros_version'=>'required',
            'effectivity'=>'required',
        ]); 

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $pros_id = $request->input('pros_id');

            if($pros_id == "0"){
                $prospectus = new Prospectus;
                $prospectus->version = htmlspecialchars($request->input('pros_version'));
                $prospectus->effectivity = htmlspecialchars($request->input('effectivity'));
    
                $prospectus->save();
            }else{
                $prospectus = Prospectus::find($pros_id);
                $prospectus->version = htmlspecialchars($request->input('pros_version'));
                $prospectus->effectivity = htmlspecialchars($request->input('effectivity'));
    
                $prospectus->update();
            }

            return response()->json([
                'status'=>200,
                'message'=>'Prospectus Saved Successfully',
            ]);

        }
    }

    public function deletePros($id){
        $prospectus = Prospectus::find($id);

        if($prospectus){
            $prospectus->delete();
            return response()->json([
                'status'=>200,
                'message'=> "Prospectus Deleted Successfully",
            ]);
        }
    }

    // Courses Functions
    public function fetchCourses(){

        $courses = Course::all();

        if($courses){
            return response()->json([
                'status'=>200,
                'courses'=>$courses,
            ]);
        }

    }

    public function saveCourse(Request $request){
        $validator = Validator::make($request->all(), [
            'course_name'=>'required',
            'course_abbr'=>'required',
        ]); 

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $course_save_id = $request->input('course_save_id');

            if($course_save_id == "0"){
                $course = new Course;
                $course->name = htmlspecialchars($request->input('course_name'));
                $course->abbreviation = htmlspecialchars($request->input('course_abbr'));
    
                $course->save();
            }else{
                $course = Course::find($course_save_id);
                $course->name = htmlspecialchars($request->input('course_name'));
                $course->abbreviation = htmlspecialchars($request->input('course_abbr'));
    
                $course->update();
            }

            return response()->json([
                'status'=>200,
                'message'=>'Course Saved Successfully',
            ]);

        }
    }

    public function deleteCourse($id){
        $course = Course::find($id);

        if($course){
            $course->delete();
            return response()->json([
                'status'=>200,
                'message'=> "Course Deleted Successfully",
            ]);
        }
    }
    
}
