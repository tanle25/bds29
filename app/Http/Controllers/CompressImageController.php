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
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CompressImageController extends Controller
{
    //
    public function moveImage()
    {
        # code...
        // dd('test');
        if(!Schema::hasTable('images')){
            Schema::create('images', function(Blueprint $table){
                $table->id();
                $table->tinyInteger('type')->after('id');
                $table->foreignIdFor(RealtyPost::class)->constrained()->cascadeOnDelete();
                $table->string('link');
                $table->string('title')->nullable();
                $table->string('alt')->nullable();
                $table->timestamps();
            });
        }
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
        return redirect()->back();
    }

    public function compressImage()
    {
        # code...

        // $this->moveImage();

            $images = Image::where('link', 'LIKE', '%.jpg')->limit(50)->get();

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
                    if (is_array($result)) {
                        $image->update([
                            'link' => $newImageLink
                        ]);
                    }
                }else{
                    $image->delete();
                }

                
            }
            return redirect()->back();
            
            // return view('customer.pages.compressimage',['result'=>$result,'total_compress'=>$totalCompressted,'total_image'=>$totalImage]);

    }

    public function emptyImage()
    {
        # code...
        Image::truncate();
        // return back();
    }

    public function showPage()
    {
        # code...
        $totalImage = Image::all()->count();
        $totalCompressted = Image::where('link', 'LIKE', '%.webp')->get()->count();
        return view('customer.pages.compressimage',['total_compress'=>$totalCompressted,'total_image'=>$totalImage]);
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
            $image->update([
                'profile_image_path' =>$newImageLink
            ]);
        }
    }

    public function resizeImage()
    {
        # code...
        $image = 'app/public/photos/1/du-an/20210202105549-824e_wm_mb.webp';
        ImageCompression::compress(storage_path($image),false,400);
    }

    public function createFolder()
    {
        # code...
        $files = Storage::disk('public')->files('image_uploads');

        foreach ($files as $file) {
            # code...
            if(pathinfo($file, PATHINFO_EXTENSION) == 'webp'){
                dd($file);
            }
        }
        $compress = new ImageCompression();
        $compress->createFolder();
        
    }

}
