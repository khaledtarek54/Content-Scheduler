<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class PostRepository
{

    public function getUserPosts($filters = [])
    {
        $cacheKey = 'user_posts_' . Auth::id();
        Cache::forget($cacheKey);
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($filters) {
            return Post::where('user_id', Auth::id())
                ->with(['platforms' => function ($query) {
                    $query->select('platforms.id', 'platforms.name')->without('pivot');
                }])
                ->when(isset($filters['status']), fn($q) => $q->where('status', $filters['status']))
                ->when(isset($filters['date']), fn($q) => $q->whereDate('scheduled_time', $filters['date']))
                ->get();
        });
    }

    public function getPostById($id)
    {
        return Post::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();
    }

    public function createPost($data)
    {
        if (request()->hasFile('image_url')) {
            $data['image_url'] = request()->file('image_url')->store('images', 'public');
        }

        $post =  Auth::user()->posts()->create($data);
        Cache::forget('user_posts_' . Auth::id());
        return $post;
    }

    public function updatePost($post, $data)
    {
        Cache::forget('user_posts_' . Auth::id());
        $post->update($data);
        return $post;
    }

    public function deletePost($post)
    {
        Cache::forget('user_posts_' . Auth::id());
        return $post->delete();
    }
}
