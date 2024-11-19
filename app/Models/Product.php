<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'price', 'tax', 'description', 'course_id',
    ];

    // Relacionamento com o modelo Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
