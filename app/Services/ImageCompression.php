<?php

namespace App\Services;

use File;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class ImageCompression{
    
    static function compress($imagePath, $removeFile = false, $width = 0, $height = 0){
        $isExists = File::exists($imagePath);
        if($isExists){
                $ext = pathinfo($imagePath,PATHINFO_EXTENSION);
                $outputPath = Str::replace($ext,'webp',$imagePath);
                $resize = "-resize $width $height";
    
                $shellCommand = "cwebp -preset photo -alpha_q 80 -m 6 -segments 4 -psnr 42 -f 40 -sharpness 3 -nostrong $resize -partition_limit 50 -pass 6 -mt -alpha_filter best -alpha_cleanup -q 100 -print_ssim  $imagePath -o $outputPath";
                shell_exec($shellCommand);
                $inputFileSize = File::size($imagePath);
                $outputFileSize = File::size($outputPath);
                if($removeFile){
                    File::delete($imagePath);
                }
                $result = [$inputFileSize, $outputFileSize];
                return $result;
            
        }else{
            Log::info('file not found');
            return 440;
        }
        
    }
}