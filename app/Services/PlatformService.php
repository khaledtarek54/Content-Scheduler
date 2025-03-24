<?php

namespace App\Services;

use App\Models\Platform;
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
    public function getSuggestedTime($platformId)
    {
        $platform = Platform::find($platformId);

        return [
            'suggested_time' => $platform ? now()->addDays(1)->setTimeFromTimeString($platform->peak_hour) : now()->addHours(1)
        ];
    }
}
