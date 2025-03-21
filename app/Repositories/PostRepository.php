<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class PostRepository
{

    public function getUserPosts($filters = [])
    {
        return Post::where('user_id', Auth::id())
            ->with(['platforms' => function ($query) {
                $query->select('platforms.id', 'platforms.name')->without('pivot');
            }])
            ->when(isset($filters['status']), fn($q) => $q->where('status', $filters['status']))
            ->when(isset($filters['date']), fn($q) => $q->whereDate('scheduled_time', $filters['date']))
            ->get();
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
        return Auth::user()->posts()->create($data);
    }

    public function updatePost($post, $data)
    {
        $post->update($data);
        return $post;
    }

    public function deletePost($post)
    {
        return $post->delete();
    }
}
