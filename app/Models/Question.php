<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        "quiz_id",
        "question",
        "file",
        "image",
        "active",
    ];
    public function item()
    {
      return $this->hasMany(ItemQuestion::class);
    }
    public function quizzes()
    {
      return $this->belongsToMany(Quiz::class,"quiz_id");
    }
}
