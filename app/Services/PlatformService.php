<?php

namespace App\Services;

use App\Repositories\PlatformRepository;

class PlatformService
{
    protected $platformRepository;

    public function __construct(PlatformRepository $platformRepository)
    {
        $this->platformRepository = $platformRepository;
    }

    public function listPlatforms()
    {
        return $this->platformRepository->getAllPlatforms();
    }

    public function togglePlatform($platformId)
    {
        return $this->platformRepository->toggleUserPlatform($platformId);
    }
}
