<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentSetting extends Model
{
    use HasFactory;
    protected $fillable=[
        "school_name",
        "county",
        "qr_code",
        "district",
        "name_director",
        "number_school",
        "status_school",
        "background_document",
    ];
}
