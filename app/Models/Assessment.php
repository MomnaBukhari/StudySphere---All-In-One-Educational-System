<?php

namespace App\Models;
use App\Models\Answer;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'type', 'instructions', 'file'
    ];

    public function getFilePathAttribute()
    {
        return asset('uploads/'. $this->file);
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function performances()
    {
        return $this->hasMany(Performance::class);
    }

public function answers()
{
    return $this->hasMany(Answer::class);
}

}
