<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
protected $guarded = [];

    public function uploader()
{
    return $this->belongsTo(User::class, 'uploaded_by');
}

public function course()
{
    return $this->belongsTo(Course::class);
}

}
