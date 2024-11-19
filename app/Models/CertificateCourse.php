<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateCourse extends Model
{
    use HasFactory;
    protected $fillable =[
        "student_id",
        "term1",
        "name_teachers",
        "name_projects",
        "start",
        "end",
        "hours",
        "date_start",
        "date",
        "active",
        "academic_year",
    ];


    /**
     * Get the certificate_course_grade associated with the CertificateCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function certificate_course_grade()
    {
        return $this->hasOne(CertificateCourseGrade::class);
    }
}
