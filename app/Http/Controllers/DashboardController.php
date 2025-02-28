<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function dashboard(){
        if(Auth::check()){
            if(Auth::user()->hasrole('teacher') || Auth::user()->hasrole('superadministrator')){
                $teachers = User::whereHasRole('teacher')->get();
                $students = User::whereHasRole('student')->get();
    
                $totalTeachers = count($teachers);
                $totalStudents = count($students);
    
                return view('teacher.dashboard', compact('totalTeachers','totalStudents'));
            }else{
                return redirect()->route('st-dashboard');
            }
        }else{
            return redirect()->route('/');
        }
        
        

        
    }
}
