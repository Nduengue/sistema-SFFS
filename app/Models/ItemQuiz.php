<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemQuiz extends Model
{
    use HasFactory;
    protected $fillable = [
        "quiz_id",
        "file",
        "response",
        "status",
        "active",
    ];
    protected $hidden = [
        'status',
        'active',
    ];
    public function quizzes()
    {
      return $this->belongsToMany(Quiz::class,"quiz_id");
    }
}
