<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'address',
        'cnic',
        'gender',
        'contact_number',
        'profile_picture',
        'bio',
        'course_specialization',
        'social_media_links',
        'show_profile',
        'show_courses',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Define role constants
     */
    const ROLE_STUDENT = 'student';
    const ROLE_GUARDIAN = 'guardian';
    const ROLE_TEACHER = 'teacher';

    /**
     * Relationships
     */

    public function students()
    {
        return $this->hasMany(User::class, 'guardian_id')->where('role', 'student');
    }

    public function guardian()
    {
        return $this->belongsTo(User::class, 'guardian_id');
    }

    public function performances()
    {
        return $this->hasMany(Performance::class, 'student_id');
    }

    public function followedCourses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id');
    }

    public function followedAssessments()
    {
        return $this->hasManyThrough(Assessment::class, Course::class, 'id', 'course_id', 'id', 'id')
            ->join('course_student', 'courses.id', '=', 'course_student.course_id')
            ->where('course_student.student_id', '=', $this->id);
    }

    public function contents()
    {
        return $this->hasMany(Content::class, 'uploaded_by');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
            ->withTimestamps();
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'student_id');
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'teacher_id');
    }

    public function taughtCourses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    // Chat relationships
    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'user_chats');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Role checking method
     */
    public function hasRole($role)
    {
        $allowedRoles = [self::ROLE_TEACHER, self::ROLE_STUDENT, self::ROLE_GUARDIAN];
        return in_array($role, $allowedRoles) && $this->role === $role;
    }

    /**
     * Get the user's role
     */
    public function getRoleAttribute()
    {
        return $this->attributes['role'];
    }

}


