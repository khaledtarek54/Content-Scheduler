<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessScheduledPosts
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        Log::info("Processing scheduled posts...");
        $posts = Post::where('status', 'scheduled')
            ->where('scheduled_time', '<=', now())
            ->get();

        foreach ($posts as $post) {
            Log::info("Processing post ID: {$post->id}");
            foreach ($post->platforms as $platform) {
                Log::info("Updating platform ID: {$platform->id} for post ID: {$post->id}");


                $post->platforms()->updateExistingPivot($platform->id, [
                    'platform_status' =>  'published'
                ]);
            }

            $post->update(['status' => 'published']);
            Log::info("Post ID: {$post->id} marked as published.");
        }
    }
}
