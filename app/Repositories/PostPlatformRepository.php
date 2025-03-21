<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostPlatformRepository
{
    public function attachPlatformsToPost($postId, $platformIds)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($postId);
        $post->platforms()->syncWithPivotValues($platformIds, ['platform_status' => 'pending']);
        return $post->platforms;
    }
}
