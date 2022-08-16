<?php

namespace App\Http\Controllers;

use File;
use Tinify\Tinify;
use App\Models\Image;
use App\Models\RealtyPost;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ImageCompression;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CompressImageController extends Controller
{
    //
    public function moveImage()
    {
        # code...
        // dd('test');
        $realties = RealtyPost::whereStatus(3)->doesntHave('images')->get();
        foreach ($realties as $realty) {
            # code...
            $images = explode(',', $realty->realty->house_image);
            // dd($ima)
            foreach ($images as $image) {
                $realty->images()->create([
                    'link' => $image,
                    'title' => $realty->title,
                    'alt' => $realty->title,
                    'type' => 1
                ]);
            }
            if ($realty->realty->house_design_image != null) {
                $designImages = explode(',', $realty->realty->house_design_image);

                foreach ($designImages as $image) {
                    # code...
                    $realty->images()->create([
                        'link' => $image,
                        'title' => $realty->title,
                        'alt' => $realty->title,
                        'type' => 2
                    ]);
                }
            }
        }
    }

    public function compressImage()
    {
        # code...

        $this->moveImage();

            $images = Image::where('link', 'LIKE', '%.jpg')->limit(50)->get();
            // dd($images);
            $before = 0;
            $after = 0;
            $thumb_before = 0;
            $thumb_after = 0;
            foreach ($images as $image) {
                # code...
                $url = $image->link;
                $fileName = pathinfo($url, PATHINFO_FILENAME);
                $ext = pathinfo($url, PATHINFO_EXTENSION);
                $newImageLink = Str::replace($ext, 'webp', $url);
                $fileExists = \File::exists(storage_path('app/public/image_uploads/' . $fileName . '.' . $ext));
                // dd($fileExists, $fileName);
                if($fileExists){
                    $result = ImageCompression::compress(storage_path('app/public/image_uploads/' . $fileName . '.' . $ext), true);
                    $thumbResult = ImageCompression::compress(storage_path('app/public/image_uploads/thumbs/' . $fileName . '.' . $ext), true);
                    if (is_array($thumbResult)) {
                        $thumb_before += $thumbResult[0];
                        $thumb_after += $thumbResult[1];
                    }
    
                    if (is_array($result)) {
                        $before += $result[0];
                        $after += $result[1];
                        $image->update([
                            'link' => $newImageLink
                        ]);
                    }
                }
                
            }
            $imageSavedByte = $before - $after;
            $imageSaved = $imageSavedByte / $before;
            $thumbSavedByte = $thumb_before - $thumb_after;
            $thumbSaved = $thumbSavedByte / $thumb_before;
            $totalImage = Image::all()->count();
            $totalCompressted = Image::where('link', 'LIKE', '%.webp')->get()->count();

            $result = [
                'image_before' => $before,
                'image_after' => $after,
                'image_saved_byte' => $imageSavedByte,
                'image_saved_percent' => $imageSaved,
                'thumb_before' => $thumb_before,
                'thumb_after' => $thumb_after,
                'thumb_saved_byte' => $thumbSavedByte,
                'thumb_saved_percent' => $thumbSaved,
                'total_image' => $totalImage,
                'total_compress' => $totalCompressted
            ];
            return view('customer.pages.compressimage',['result'=>$result]);

    }

    public function compressAvata()
    {
        # code...
        $images = User::whereNotNull('profile_image_path')->get();
        // dd($images);
        foreach ($images as $image) {
            # code...
            $url = $image->profile_image_path;
            $fileName = pathinfo($url, PATHINFO_FILENAME);
            $ext = pathinfo($url, PATHINFO_EXTENSION);
            $newImageLink = Str::replace($ext, 'webp', $url);
            // $fileExists = \File::exists(storage_path('app/public/user_avatar/' . $fileName . '.' . $ext));
            // if($fileExists){
            //     $result = ImageCompression::compress(storage_path('app/public/user_avatar/' . $fileName . '.' . $ext), true);
            //     $thumb = ImageCompression::compress(storage_path('app/public/user_avatar/thumbs/' . $fileName . '.' . $ext), true,60);
            // }
            $image->update([
                'profile_image_path' =>$newImageLink
            ]);
        }
    }

}
