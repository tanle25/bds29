<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use Str;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $save_path = storage_path('app/public/image_uploads');
            $image_name = Str::random(15) . '.jpg';
            if (!file_exists($save_path)) {
                mkdir($save_path, 777, true);
            }

            Image::make($request->file('file'))->save(storage_path('app/public/image_uploads/' . $image_name));
            if (!file_exists($save_path . '/thumbs')) {
                mkdir($save_path . '/thumbs', 777, true);
            }
            Image::make($request->file('file'))
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/image_uploads/thumbs/' . $image_name));

            return [
                'path' => Storage::url('image_uploads/' . $image_name),
                'storage_path' => 'image_uploads/' . $image_name,
                'thumb' => $this->getThumb('image_uploads/' . $image_name),
            ];
        }
    }

    public function destroy(Request $request)
    {
        Storage::delete('public/' . $request->storage_path);
        Storage::delete('public/' . $this->getThumb($request->storage_path));

    }

    private function getThumb($string)
    {
        return Str::replaceLast('/', '/thumbs/', $string);
    }
}