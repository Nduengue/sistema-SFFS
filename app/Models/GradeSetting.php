<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeSetting extends Model
{
    use HasFactory;
    protected $fillable=[
        "min",
        "med",
        "max",
        "term",
        "active",
    ];
}
