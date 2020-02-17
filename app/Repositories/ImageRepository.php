<?php

namespace App\Repositories;

use App\Image;
use App\Repositories\Interfaces\ImageRepositoryInterface;

class ImageRepository implements ImageRepositoryInterface
{
    public function store($input)
    {
        return Image::create($input);
    }
}