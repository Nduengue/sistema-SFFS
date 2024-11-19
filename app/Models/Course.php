<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';

    protected $fillable = [
        'course_name',
        'description',
        'duration',
        'level',
        'price',
        'price_registration',
        'prerequisites',
        'observations',
    ];

     // Definir como os campos JSON devem ser manipulados
     protected $casts = [
        'prerequisites' => 'array',
    ];

     /**
     * Get the user that owns the phone.
     */
    public function CourseContent(): HasOne
    {
        return $this->hasOne(CourseContent::class, 'course_id');
    }
}
