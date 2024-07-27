<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $guarded = [];


    // Relations

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_chats');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}
