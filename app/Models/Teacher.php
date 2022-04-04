<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public function rooms () {
        return $this->hasMany(Room::class, 'teacher_id', 'id');
    }

    public function quizzes () {
        return $this->hasMany(Quiz::class, 'teacher_id', 'id');
    }
}
