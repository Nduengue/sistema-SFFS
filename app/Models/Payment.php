<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id', 
        'payment_method', 
        'amount', 
        'payment_proof', 
        'payment_date', 
        'status'
    ];

    // Definir relação com a tabela de inscrições
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
