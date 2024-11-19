<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'class_id',
        'obs',
        'status',
    ];

    // Definindo as relações
    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
        //return $this->hasOne(Student::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function payment()
    {
    return $this->hasOne(Payment::class, 'registration_id')->withDefault([
        'payment_proof' => null, // Definir valores padrão para os campos do pagamento
    ]);
    }
    

  /*   // Relacionamento com o modelo StudentDocument
    public function classModel(): HasOne
    {
        return $this->hasOne(ClassModel::class, 'id');
    }  */
}
