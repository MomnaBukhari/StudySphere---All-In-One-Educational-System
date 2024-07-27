<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'title',
        'overview',
        'start_date',
        'end_date',
        'resources',
        'banner_image',
        'teacher_id',
    ];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function performances()
    {
        return $this->hasMany(Performance::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'student_id');
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'course_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'user_id');
    }
}
