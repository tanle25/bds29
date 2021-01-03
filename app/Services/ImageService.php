<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Image;
use Str;

class ImageService
{
    /**
     * Input
     * @param $image
     */
    public function storeImage($image_file)
    {
        $save_path = storage_path('app/public/image_uploads');
        $image_name = Str::random(15) . '.jpg';
        if (!file_exists($save_path)) {
            mkdir($save_path, 777, true);
        }
        Image::make($image_file)->save(storage_path('app/public/image_uploads/' . $image_name));
        if (!file_exists($save_path . '/thumbs')) {
            mkdir($save_path . '/thumbs', 777, true);
        }
        Image::make($image_file)
            ->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/image_uploads/thumbs/' . $image_name));

        return [
            'path' => Storage::url('image_uploads/' . $image_name),
            'storage_path' => 'image_uploads/' . $image_name,
            'thumb' => $this->getThumb('image_uploads/' . $image_name),
        ];
    }

    /**
     * Input
     * @param Array $image_list array of file path
     *
     */
    public function delete($storage_path)
    {
        Storage::delete($storage_path);
        Storage::delete($this->getThumb($storage_path));
    }

    private function getThumb($string)
    {
        return Str::replaceLast('/', '/thumbs/', $string);
    }

}