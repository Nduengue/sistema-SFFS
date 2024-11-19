<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationUser extends Model
{
    use HasFactory;
    protected $fillable = [
        "conversation_id",
        "user_id",
    ];
    /**
     * Get all of the conversations for the ConversationUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_id');
    }
}
