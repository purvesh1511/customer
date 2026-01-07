<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use App\Events\PostCreated;

class PostObserver
{
    public function creating(Post $post): void
    {
        // Auto-generate slug if empty
        Log::info('Post creating', ['id' => $post]);
    }


    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        Log::info('Post created', ['id' => $post->id]);
        event(new PostCreated($post));
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        Log::info('Post updated', ['id' => $post->id]);
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        Log::info('Post deleted', ['id' => $post->id]);
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        Log::info('Post restored', ['id' => $post->id]);
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        Log::info('Post force deleted', ['id' => $post->id]);
    }
}
