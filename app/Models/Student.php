<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'birth_date',
        'id_type',
        'id_number',
        'email',
        'phone_number',
        'address',
        'profile_picture',
        'observations',
        'documents',
        'user_id',
        'student_status',
    ];

    protected $casts = [
        'documents' => 'array', // Faz o casting para array quando a coluna é um JSON
    ];

    // Relacionamento com o modelo StudentDocument
    public function studentDocuments(): HasMany
    {
        return $this->hasMany(StudentDocument::class, 'student_id');
    }
}
