<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\AnalyticsService;
use Illuminate\Routing\Controller;

class AnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function getPostAnalytics(): JsonResponse
    {
        return response()->json($this->analyticsService->getAnalytics());
    }
}
