<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        "name",
        "file_path",
        "file_type",
        "course_id",
    ];
}
