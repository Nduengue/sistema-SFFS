<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'doc_type',
        'document',
        'emission_date',
        'expiration_date',
        'status',
    ];

    /* // Relacionamento com o modelo Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    } */
}
