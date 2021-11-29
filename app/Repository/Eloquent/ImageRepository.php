<?php

namespace App\Repository\Eloquent;

use App\Repository\ImageRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{

    /**
     * @param $file
     * @return object
     */
    public function upload($file): object
    {
        /*Test*/
        exit('777');
        /*Testend*/
        $name = Str::random(10);
        $url = Storage::putFileAs('images', $file, $name . '.' . $file->extension());
        return $url;

    }

}
