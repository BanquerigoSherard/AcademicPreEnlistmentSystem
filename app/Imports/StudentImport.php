<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class StudentImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    private $course_id;
    private $prospectus_id;

    public function __construct($course_id, $prospectus_id)
    {
        $this->course_id = $course_id;
        $this->prospectus_id = $prospectus_id;
    }
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) 
        {

            $student = User::where('student_id', $row['studentid'])->first();

            if($student){
                $student->update([
                    'student_id' => $row['studentid'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'prospectus_id' => $this->prospectus_id,
                    'course_id' => $this->course_id,
                    'year_level' => $row['yearlvl'],
                ]);
            }else{
                $user = User::create([
                    'student_id' => $row['studentid'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'course_id' => $this->course_id,
                    'password' => Hash::make($row['studentid']),
                    'year_level' => $row['yearlvl'],
                ]);

                $user->addRole('student');
            }

 
            
        }
    }
}
