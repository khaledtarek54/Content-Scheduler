<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PlatformRepository;
use App\Repositories\PostPlatformRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;

class PostService
{
    protected $postRepo;
    protected $platformRepo;

    public function __construct(PostRepository $postRepo,PostPlatformRepository $platformRepo)
    {
        $this->postRepo = $postRepo;
        $this->platformRepo = $platformRepo;
    }
    public function fetchUserPosts($filters)
    {
        return $this->postRepo->getUserPosts($filters);
    }
    public function fetchPostById($filters)
    {
        return $this->postRepo->getPostById($filters);
    }

    public function storePost($data)
    {
        $platform = $data['platform'];
        unset($data['platform']);
        $post =  $this->postRepo->createPost($data);
        $this->platformRepo->attachPlatformsToPost($post->id, $platform);
    }
    

    public function updatePost($postId, $data)
    {
        $post = Post::where('user_id', Auth::id())->find($postId);
        if(!$post)
        {
            return false;
        }
        return $this->postRepo->updatePost($post, $data);
    }

    public function destroyPost($postId)
    {
        $post = Post::where('user_id', Auth::id())->find($postId);
        if(!$post)
        {
            return false;
        }
        return $this->postRepo->deletePost($post);
    }
}
