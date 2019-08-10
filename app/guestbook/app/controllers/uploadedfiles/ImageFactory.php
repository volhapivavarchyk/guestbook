<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers\UploadedFiles;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageFactory
{

    protected $typeImage = [];

    public function __construct()
    {
        $this->typeImage['gif'] = 'Piv\Guestbook\App\Controllers\UploadedFiles\ImageGif';
        $this->typeImage['jpeg'] = 'Piv\Guestbook\App\Controllers\UploadedFiles\ImageJpeg';
        $this->typeImage['png'] = 'Piv\Guestbook\App\Controllers\UploadedFiles\ImagePng';
    }

    public function createImage(UploadedFile $image): AImage
    {
        $className = $this->typeImage[$image->guessClientExtension()];
        return new $className($image);
    }

}
