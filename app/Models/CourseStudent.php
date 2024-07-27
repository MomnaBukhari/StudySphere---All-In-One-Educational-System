<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    use HasFactory;

    protected $table = 'course_student'; // Specify table name if different

    protected $fillable = [
        'course_id',
        'student_id',
    ];

    /**
     * Get the course associated with this enrollment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Get the student associated with this enrollment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id'); // Assuming 'users' table for students
    }

    /**
     * Get the contents associated with this enrollment's course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function contents()
    {
        return $this->course->contents();
    }

    /**
     * Get the assessments associated with this enrollment's course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function assessments()
{
    return $this->hasMany(Assessment::class, 'course_id');
}
public function users()
{
    return $this->belongsToMany(User::class, 'course_student');
}

}
