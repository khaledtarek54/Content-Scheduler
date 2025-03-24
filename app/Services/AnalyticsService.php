<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class AnalyticsService
{
    public function getAnalytics()
    {
        $userId = Auth::id();

        $totalPosts = Post::where('user_id', $userId)->count();
        $totalScheduled = Post::where('user_id', $userId)->where('status', 'scheduled')->count();
        $totalPublished = Post::where('user_id', $userId)->where('status', 'published')->count();

        $successRate = $totalPosts > 0 ? round(($totalPublished / $totalPosts) * 100, 2) : 0;


        $postsPerPlatform = Post::where('user_id', $userId)
            ->with('platforms')
            ->get()
            ->flatMap(fn($post) => $post->platforms->pluck('name'))
            ->countBy();

        return [
            'total_scheduled' => $totalScheduled,
            'total_published' => $totalPublished,
            'success_rate' => $successRate,
            'posts_per_platform' => $postsPerPlatform,
        ];
    }
}
