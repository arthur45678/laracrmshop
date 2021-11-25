<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Repository\BaseRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    protected $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function upload(ImageUploadRequest $request)
    {
        $file = $request->file('image');

        $url = $this->repository->upload($file);

        return [
            'url' => env('APP_URL') . '/' . $url
        ];
    }
}
