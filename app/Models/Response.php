<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    protected $fillable = [
        "classroom_id",
        "course_id",
        "user_id",
        "question_id",
        "response_id", //ItemQuiz
        "response",
        "status",
    ];
    public function question()
    {
      return $this->belongsTo(Question::class,"question_id");
    }
    public function item()
    {
      return $this->belongsTo(ItemQuestion::class,"response_id");
    }
}
