<?php

namespace App\Http\Helper;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageUpload{

    public static function store($file, $maxSize = 512): string{
        $filename   = Str::random(32).'.png';
        $manager = new ImageManager(new Driver());
        $image  = $manager->read($file->getRealPath());
        $imgSize = $image->size();

        if ($imgSize->isPortrait()){
            $image->scaleDown(height: $maxSize);
        }else{
            $image->scaleDown(width: $maxSize);
        }

        $imagedata = (string) $image->toPng();
        Storage::disk('public')->put($filename, $imagedata);

        return $filename;
    }
}
