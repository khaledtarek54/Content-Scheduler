<?php

namespace App\Repositories;

use App\Models\Platform;
use Illuminate\Support\Facades\Auth;

class PlatformRepository
{
    public function getAllPlatforms()
    {
        return Platform::all();
    }

    public function toggleUserPlatform($platformId)
    {
        $user = Auth::user();
        $user->platforms()->toggle($platformId);
        return $user->platforms;
    }
}
