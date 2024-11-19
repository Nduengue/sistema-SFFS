<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishQuiz extends Model
{
    use HasFactory;
    protected $fillable = [
        "classroom_id",
        "course_id",
        "user_id",
        "quiz_id",
        "right",
        "wrong",
        "time",
    ];
}
