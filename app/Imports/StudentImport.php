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
                ]);
            }else{
                $user = User::create([
                    'student_id' => $row['studentid'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => Hash::make($row['studentid']),
                ]);

                $user->addRole('student');
            }

 
            
        }
    }
}
