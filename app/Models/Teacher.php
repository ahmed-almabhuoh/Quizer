<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasFactory;

    public function rooms () {
        return $this->hasMany(Room::class, 'teacher_id', 'id');
    }

    public function quizzes () {
        return $this->hasMany(Quiz::class, 'teacher_id', 'id');
    }

    public function students () {
        return $this->hasMany(Student::class, 'teacher_id', 'id');
    }

    public function admin () {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
