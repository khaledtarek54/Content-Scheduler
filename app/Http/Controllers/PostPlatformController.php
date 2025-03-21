<?php

namespace App\Http\Controllers;

use App\Models\PostPlatform;
use Illuminate\Http\Request;
use App\Services\PostPlatformService;
use App\Http\Requests\PostPlatformRequest;

class PostPlatformController extends Controller
{
    protected $postPlatformService;

    public function __construct(PostPlatformService $postPlatformService)
    {
        $this->postPlatformService = $postPlatformService;
    }

    public function attachPlatforms(PostPlatformRequest $request, $postId)
    {
        

        return response()->json($this->postPlatformService->assignPlatformsToPost($postId, $request->platforms));
    }
}
