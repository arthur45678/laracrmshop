<?php

namespace App\Repository;

interface ImageRepositoryInterface
{
    public function upload($file): object;
}
