<?php

namespace App\Http\Controllers;

use Tinify\Tinify;
use App\Models\Image;
use App\Models\RealtyPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use File;

class CompressImageController extends Controller
{
    //
    public function moveImage()
    {
        # code...
        // dd('test');
        $realties = RealtyPost::whereStatus(3)->get();
        foreach ($realties as $realty) {
            # code...
            $images = explode(',',$realty->realty->house_image);
            foreach ($images as $image) {
                # code...
                // dd($image);
                $realty->images()->create([
                    'link'=>$image,
                    'title'=>$realty->title,
                    'alt'=>$realty->title
                ]);
            }
        }
       
    }

    public function compress()
    {
        # code...
        $images = Image::all();
        Tinify::setKey('Frq70zfjY2T5fCf1cFCrn0bZyHpNhsDz');
        foreach ($images as $img) {
            # code...
            $image = $img->link;
            $ex = pathinfo($image,PATHINFO_EXTENSION);
            if($ex != 'webp'){
                $path = Str::replace($ex,'webp',$image);
                $source = \Tinify\fromFile(public_path($image));
                $resized = $source->resize([
                    "method" => "scale",
                    "width" => 825 
                ]);
                $resized->toFile(public_path($path));
                $img->link = $path;
                $img->save();
                File::delete(public_path($image));
            }
        }
    }

    public function compressThumb()
    {
        # code...
        Tinify::setKey('Frq70zfjY2T5fCf1cFCrn0bZyHpNhsDz');
        $images = Image::all();
        foreach ($images as $image) {
            # code...
            $thumb = Str::replaceLast('/', '/thumbs/', $image->link);
            $thumb_ext = Str::replace('webp','jpg',$thumb);
            $source = \Tinify\fromFile(public_path($thumb_ext));
            $source->toFile(public_path($thumb));
            File::delete(public_path($thumb_ext));
        }

    }

    public function cropBlurImage()
    {
        # code...
        Tinify::setKey('Frq70zfjY2T5fCf1cFCrn0bZyHpNhsDz');
        $images = Image::all();
        foreach ($images as $image) {
            $thumb = Str::replaceLast('/', '/thumbs/', $image->link);
            $source = \Tinify\fromFile(public_path($thumb));
            $coverImage = $source->resize(array(
                "method" => "cover",
                "width" => 360,
                "height" => 203
            ));
        
        }
    }
}
