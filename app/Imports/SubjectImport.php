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

    private $pros_id;
    private $course_id;

    public function __construct($pros_id, $course_id)
    {
        $this->pros_id = $pros_id;
        $this->course_id = $course_id;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) 
        { 

            $subject = Subject::where('subject_code', $row['subjectcode'])->first();

            if($subject){
                $subject->update([
                    'prospectus_id' => $this->pros_id,
                    'course_id' => $this->course_id,
                    'description' => $row['description'],
                    'pre_requisites' => $row['prerequisites'],
                    'lec_units' => $row['lecunits'],
                    'lab_units' => $row['labunits'],
                    'year_lvl' => $row['yearlvl'],
                    'semester' => $row['semester'],
                ]);
            }else{
                Subject::create([
                    'prospectus_id' => $this->pros_id,
                    'course_id' => $this->course_id,
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
