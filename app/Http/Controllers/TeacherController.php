<?php

namespace App\Http\Controllers;
use App\Mail\SendNewPassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\SendUserCredentials;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function index(){
        return view('teacher.teacher-accounts');
    } 

    public function fetch()
    {
        $teachers = User::whereHasRole('teacher')->get();

        if($teachers) {
            return response()->json([
                'status' => 200,
                'teachers' => $teachers,
            ]);
        }
    }
 
    // Save a new teacher
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $password = array();
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $password[] = $alphabet[$n];
            }

            $teacher = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(implode($password)),
            ]);

            $teacher->addRole('teacher');

            $password = implode($password);

            // Send credentials
            Mail::to($teacher->email)->send(new SendUserCredentials($teacher, $password));

            return response()->json([
                'status' => 200,
                'message' => 'Teacher Added successfully',
                'password' => $password
            ]);
        }
    }

    // Edit a teacher's details
    public function edit($id)
    {
        $teacher = User::find($id);

        if ($teacher) {
            return response()->json([
                'status' => 200,
                'teacher' => $teacher,
            ]);
        }
    }

    // Update teacher information
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $id = $request->input('teacher_id');
            $teacher = User::find($id);

            if ($teacher) {
                $teacher->name = htmlspecialchars($request->input('name'));
                $teacher->email = htmlspecialchars($request->input('email'));

                $teacher->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Teacher Updated Successfully',
                ]);
            }
        }
    }

    // Delete a teacher
    public function destroy($id)
    {
        $teacher = User::find($id);

        if ($teacher) {
            $teacher->delete();
            return response()->json([
                'status' => 200,
                'message' => "Teacher Deleted Successfully",
            ]);
        }
    }


    public function changePass(Request $request){
        $request->validate([
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        try {
            $teacher = User::find($request->idTeacher);
            $teacher->password = Hash::make($request->password);
            $teacher->save();

            // Send credentials
            Mail::to($teacher->email)->send(new SendNewPassword($teacher, $request->password));

            return response()->json([
                'message' => 'Password changed successfully!',
                'password' => $request->password
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while changing password.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
