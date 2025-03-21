<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Prospectus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManageStudentController extends Controller
{
    public function index(){
        $prospectus = Prospectus::all();
        $courses = Course::all();
        return view('teacher.students', compact('courses', 'prospectus'));
    } 

    public function import(Request $request){
        $validator = Validator::make($request->all(), [
            'course'=>'required',
            'importFile'=>'required|file',
        ]);

        if($request->hasFile('importFile')){
            $course_id = htmlspecialchars($request->input('course'));
            $prospectus_id = htmlspecialchars($request->input('prospectus'));

            $file = $request->file('importFile');
            Excel::import(new StudentImport($course_id, $prospectus_id), $file);filePath: 

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

    public function save(Request $request){

        $validator = Validator::make($request->all(), [
            'student_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'prospectus' => ['required', 'string', 'max:255'],
            'course' => ['required', 'string', 'max:255'],
            'year_lvl' => ['required', 'string', 'max:255'],
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{

            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $password = array();
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $password[] = $alphabet[$n];
            }
            
            $user = User::create([
                'student_id' => $request->student_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(implode($password)),
                'prospectus_id' => $request->prospectus,
                'course_id' => $request->course,
                'year_level' => $request->year_lvl,
            ]);
    
            $user->addRole('student');
            
            return response()->json([
                'status'=>200,
                'message'=>'Student Added successfully',
                'password'=>implode($password)
             ]);
        }


    }

    public function edit($id){
        $student = User::find($id);
        $courses = Course::all();
        $prospectus = Prospectus::all();
        $grades = Grade::where([ ['student_id', '=', $id] ])->orderBy('id', 'DESC')->get();
        $subjects = [];
        foreach ($grades as $grade) {
            $subject = Subject::find($grade->subject_id);
            array_push($subjects, $subject);
        }
        if($student){
            return response()->json([
                'status'=>200,
                'student'=>$student,
                'courses'=>$courses,
                'subjects'=>$subjects,
                'grades'=>$grades,
                'prospectus'=>$prospectus,
            ]);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'student_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'prospectus' => ['required', 'string', 'max:255'],
            'course' => ['required', 'string', 'max:255'],
            'year_lvl' => ['required', 'string', 'max:255'],
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $id = $request->input('studentIdEdit');
            $student = User::find($id); 

            if($student){
                $student->student_id = htmlspecialchars($request->input('student_id'));
                $student->name = htmlspecialchars($request->input('name'));
                $student->email = htmlspecialchars($request->input('email'));
                $student->prospectus_id = htmlspecialchars($request->input('prospectus'));
                $student->course_id = htmlspecialchars($request->input('course'));
                $student->year_level = htmlspecialchars($request->input('year_lvl'));

                $student->update();

                return response()->json([
                    'status'=>200,
                    'message'=>'Student Updated Successfully',
                ]);
            }

        }
    }

    public function delete($id){
        $student = User::find($id);

        if($student){
            $student->delete();
            return response()->json([
                'status'=>200,
                'message'=> "Student Deleted Successfully",
            ]);
        }
    }


}
