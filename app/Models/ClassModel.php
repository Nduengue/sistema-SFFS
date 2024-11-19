<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    protected $table = 'classes';
    
    // Defina os campos que podem ser preenchidos
    protected $fillable = [
        'class_name',
        'course_id', 
        'user_id', 
        'start_date', 
        'end_date', 
        'vacancies', // ou 'slots' se for este o nome final
        'shift_id', 
        'obs',
        'status',
    ];

    // Evento para gerar automaticamente o nome da turma
    protected static function boot()
    {
        parent::boot();

        // Evento de criação
        static::creating(function ($class) {
            $class->class_name = 'SFFS' . str_pad(self::max('id') + 1, 5, '0', STR_PAD_LEFT);
        });
    }

    // Relacionamentos (caso aplicável)
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id')->where('user_type', 3);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

}
