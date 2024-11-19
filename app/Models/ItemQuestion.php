<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        "question_id",
        "file",
        "response",
        "status",
        "active",
    ];
    protected $hidden = [
        'status',
        'active',
    ];
    public function question()
    {
      return $this->belongsToMany(Question::class,"question_id");
    }
}
