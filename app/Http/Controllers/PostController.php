<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\Http\Requests\PostRequest;
use Illuminate\Routing\Controller;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $posts = $this->postService->fetchUserPosts($request->only('status', 'date'));
        return response()->json($posts);
    }
    public function fetchPostById($id)
    {
        $post = $this->postService->fetchPostById($id);
        if(!$post)
        {
            return response()->json(['message' => 'Post not found'], 404);
        }
        return response()->json($post);
    }
    
    public function store(PostRequest $request)
    {
        $this->postService->storePost($request->validated());
        return response()->json(201);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $post = $this->postService->updatePost($id, $request->validated());
        if(!$post)
        {
            return response()->json(['message' => 'Post not found'], 404);
        }
        return response()->json($post);
    }

    public function destroy($id)
    {
        $result = $this->postService->destroyPost($id);
        if(!$result)
        {
            return response()->json(['message' => 'Post not found'], 404);
        }
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
