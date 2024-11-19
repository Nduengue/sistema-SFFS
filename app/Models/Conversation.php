<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $fillable=[
        "name",
        "user_link1",
        "user_link2",
        "is_group",
    ];
    /**
     * The conversation that belong to the ConversationUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function conversation_users()
    {
        return $this->hasMany(ConversationUser::class);
    }
}
