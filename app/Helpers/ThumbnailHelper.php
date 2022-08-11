<?php

use Illuminate\Support\Str;
function getThumbnail($image)
{
    # code...
    return Str::replaceLast('/', '/thumbs/', $image);
}