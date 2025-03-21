<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $guarded = [];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class, 'post_platforms')
            ->withPivot('platform_status')
            ->withTimestamps();
    }
}
