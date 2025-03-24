<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $fillable = [
        'prospectus_id',
        'course_id',
        'subject_code',
        'description',
        'pre_requisites',
        'lec_units',
        'lab_units',
        'year_lvl',
        'semester',
        'is_core_subject',
    ];
}
