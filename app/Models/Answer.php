<?php

namespace App\Models;
use App\Models\Assessment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = ['assessment_id', 'answer_file'];

    public function assessment()
    {

        return $this->belongsTo(Assessment::class);
    }
    public function student()
{
    return $this->belongsTo(User::class, 'tudent_id');
}
}
