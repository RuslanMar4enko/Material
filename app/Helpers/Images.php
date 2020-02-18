<?php

namespace App\Helpers;

use Image;
use Illuminate\Support\Str;
class Images
{
    /**
     * @param $image
     * @return string
     */
    public function nameImage($image)
    {
        $pathToSaveImage = 'app/public/';
        $filename = Str::random(6) . $image->getClientOriginalName();
        $this->resizeImage($image, $filename, $pathToSaveImage, $with = null, $height = null);
        return 'storage/' . $filename;
    }

    /**
     * @param $image
     * @param $filename
     * @param $pathToSaveImage
     * @param null $with
     * @param null $height
     */
    public function resizeImage($image, $filename, $pathToSaveImage, $with = null, $height = null)
    {
        $image = Image::make($image->getRealPath());
        if ($with && $height) {
            $image->fit($with, $height);
        }
        $image->save(storage_path($pathToSaveImage . $filename));
    }

}