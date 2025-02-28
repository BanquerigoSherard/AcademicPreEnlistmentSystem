<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicTerm extends Model
{
    use HasFactory;

    protected $table = 'academic_terms';
    protected $fillable = [
        'school_year',
        'semester',
        'grade_status',
    ];
}
