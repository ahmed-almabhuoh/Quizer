<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public function teacher () {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function quizzes () {
        return $this->hasMany(Quiz::class, 'room_id', 'id');
    }

    public function getRoomStatusAttribute () {
        return $this->active ? 'Active' : 'In-Active';
    }
}
