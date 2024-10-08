<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function marks () {
        return $this->hasMany(Mark::class, 'student_id', 'id');
    }

    public function teacher () {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
}
