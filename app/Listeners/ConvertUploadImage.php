<?php

namespace App\Listeners;

use File;
use Tinify\Tinify;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConvertUploadImage
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    // protected $listen
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
        // \Tinify\setKey("EQOPlBHZ_G-LuIeEmGPYO973MmcEdhvt");
        $keys =[
            'N4ltLGqjkzMmWPg8VdvDByQdJBr9mYxT',
            'Sp8hFR04pNy6j33lg3zYgXHZ1XZ2lMkf',
            'FHmN1yg3lmkYQTjP8Q6rZWPJWn4ZRYfc'
        ];
        // Tinify::setKey($keys[0]);
        for($i =0 ; $i < count($keys); $i ++){
            Tinify::setKey($keys[$i]);
            \Tinify\validate();
            $compressionsThisMonth = \Tinify\compressionCount();
            if($compressionsThisMonth < 499){
                break;
            }
        }
        $save_path = public_path('images/webp');
        if(!file_exists($save_path)){
            mkdir($save_path,0777,true);
        }
        $path = $event->path();
        $ext = pathinfo($path,PATHINFO_EXTENSION);
        $source = \Tinify\fromFile($path);
        $filename = Str::replace($ext,'webp', $path);
        $source->toFile($filename);

        // $image = Image::make($path)->encode('webp',100)->save($filename);
        File::delete($path);
    }
}
