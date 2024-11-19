<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $fillable = [
        "user_id",
        "name",
        "action",
        "date",
        "time",
        "status",
    ];
}
