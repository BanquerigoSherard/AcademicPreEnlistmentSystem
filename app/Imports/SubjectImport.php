<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Prospectus;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubjectImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $counter = 0;
        foreach ($collection as $row) 
        { 
            $course = Course::where([ ['name', '=', $row['course'] ], ['abbreviation', '=', $row['courseabbreviation']] ])->first();
            $prospectus = Prospectus::where([ ['version', '=', $row['prospectusversion'] ], ['effectivity', '=', $row['prospectuseffectivitydate']] ])->first();
            $counter += 1;
            if($counter == 1){
                if($course){
                    // $course->update([
                    //     'name' => $row['course'],
                    //     'abbreviation' => $row['courseabbreviation'],
                    // ]);
                }else{
                    Course::create([
                        'name' => $row['course'],
                        'abbreviation' => $row['courseabbreviation'],
                    ]);
                }
                    
                if($prospectus){
                    // $prospectus->update([
                    //     'version' => $row['prospectusversion'],
                    //     'effectivity' => $row['prospectuseffectivitydate'],
                    // ]);
                }else{
                    Prospectus::create([
                        'version' => $row['prospectusversion'],
                        'effectivity' => $row['prospectuseffectivitydate'],
                    ]);
                }   
            }

            $subject = Subject::where('subject_code', $row['subjectcode'])->first();
            $course = Course::where([ ['name', '=', $row['course'] ], ['abbreviation', '=', $row['courseabbreviation']] ])->first();
            $prospectus = Prospectus::where([ ['version', '=', $row['prospectusversion'] ], ['effectivity', '=', $row['prospectuseffectivitydate']] ])->first();
            if($prospectus){
                $pros_id = $prospectus->id;
            }
            if($prospectus){
                $course_id = $course->id;
            }
            if($subject){
                $subject->update([
                    'prospectus_id' => $pros_id,
                    'course_id' => $course_id,
                    'description' => $row['description'],
                    'pre_requisites' => $row['prerequisites'],
                    'lec_units' => $row['lecunits'],
                    'lab_units' => $row['labunits'],
                    'year_lvl' => $row['yearlvl'],
                    'semester' => $row['semester'],
                ]);
            }else{
                Subject::create([
                    'prospectus_id' => $pros_id,
                    'course_id' => $course_id,
                    'subject_code' => $row['subjectcode'],
                    'description' => $row['description'],
                    'pre_requisites' => $row['prerequisites'],
                    'lec_units' => $row['lecunits'],
                    'lab_units' => $row['labunits'],
                    'year_lvl' => $row['yearlvl'],
                    'semester' => $row['semester'],
                ]);
            }
            
        }
    }
}
