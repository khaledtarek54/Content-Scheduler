<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{
    protected $fillable = ['name', 'type'];
    protected $hidden = ['pivot'];
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'user_platforms')->withTimestamps();
    }
    public function posts(): BelongsToMany {
        return $this->belongsToMany(Post::class, 'post_platforms')
                    ->withPivot('platform_status')
                    ->withTimestamps();
    }
}
