<?php

namespace App\Services;

use App\Repositories\PostPlatformRepository;

class PostPlatformService
{
    protected $postPlatformRepository;

    public function __construct(PostPlatformRepository $postPlatformRepository)
    {
        $this->postPlatformRepository = $postPlatformRepository;
    }

    public function assignPlatformsToPost($postId, $platformIds)
    {
        return $this->postPlatformRepository->attachPlatformsToPost($postId, $platformIds);
    }
}
