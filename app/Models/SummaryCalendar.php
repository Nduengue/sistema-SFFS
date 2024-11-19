<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryCalendar extends Model
{
    use HasFactory;
    protected $table = 'summary_calendar';
    protected $fillable = [
        'course_id',
        'class_id',
        'shift_id',
        'duration_months',
        'year',
        'status',
        'schedule',
    ];

    // Indica que o campo 'schedule' é do tipo JSON
    protected $casts = [
        'schedule' => 'json',
    ];

    // Relacionamentos com outras tabelas
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
