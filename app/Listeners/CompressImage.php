<?php

namespace App\Listeners;

use App\Services\ImageCompression;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompressImage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        $path = $event->path();
        $thumb = Str::replaceLast('/','/thumbs/',$path);
        // Log::alert($thumb);
        ImageCompression::compress($path,true);
        ImageCompression::compress($thumb,true);
        
    }
}
