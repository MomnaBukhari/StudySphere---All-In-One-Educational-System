<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mystudents extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student');
    }

    // Optional relationship for assessments (if applicable)
    public function assessments()
    {
        return $this->hasManyThrough(Assessment::class, Course::class, 'course_student', 'course_id', 'id');
    }



}
