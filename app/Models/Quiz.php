<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    public function teacher() {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function room () {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function questions () {
        return $this->hasMany(Question::class, 'quiz_id', 'id');
    }

    public function marks () {
        return $this->hasMany(Mark::class, 'quiz_id', 'id');
    }
}
