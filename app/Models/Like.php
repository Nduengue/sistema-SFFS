<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        "post_id",
        "user_id",
    ];

    // Relacionamento com o modelo Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * The post that belong to the Like
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function post()
    {
        return $this->belongsToMany(Post::class, 'post_id');
    }
}
