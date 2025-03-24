<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlatformService;
use Illuminate\Routing\Controller;

class PlatformController extends Controller
{
    protected $platformService;

    public function __construct(PlatformService $platformService)
    {
        $this->platformService = $platformService;
    }

    public function index()
    {
        return response()->json($this->platformService->listPlatforms());
    }

    public function togglePlatform(Request $request, $platformId)
    {
        return response()->json($this->platformService->togglePlatform($platformId));
    }
    public function getSuggestedTime($platformId)
    {
        return response()->json($this->platformService->getSuggestedTime($platformId));
    }
}
