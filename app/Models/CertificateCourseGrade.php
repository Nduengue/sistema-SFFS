<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateCourseGrade extends Model
{
    use HasFactory;
    protected $fillable = [
        "certificate_course_id",
        "student_id",
        "subject_id",
        "grade",
        "term",
        "academic_year",
    ];

    /**
     * Get the certificate_course that owns the CertificateCourseGrade
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function certificate_course()
    {
        return $this->belongsTo(CertificateCourse::class, 'certificate_course_id', 'id');
    }
}
