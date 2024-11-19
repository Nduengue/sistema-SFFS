<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseContent extends Model
{
    use HasFactory;
    protected $table = 'course_contents';

    protected $fillable = [
        'course_id',
        'contents',
        'observations',
    ];

    protected $casts = [
        'contents' => 'array',
    ];

    // Definir a relação com o modelo Curso
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
