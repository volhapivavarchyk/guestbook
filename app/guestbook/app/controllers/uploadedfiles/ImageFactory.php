<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers\UploadedFiles;

class ImageFactory
{

    protected $typeImage = [];

    public function __construct()
    {
        $this->typeImage['image/gif'] = 'Piv\Guestbook\App\Controllers\UploadedFiles\ImageGif';
        $this->typeImage['image/jpeg'] = 'Piv\Guestbook\App\Controllers\UploadedFiles\ImageJpeg';
        $this->typeImage['image/png'] = 'Piv\Guestbook\App\Controllers\UploadedFiles\ImagePng';
    }

    public function createImage(\Zend\Diactoros\UploadedFile $image): AImage
    {
        $className = $this->typeImage[$image->getClientMediaType()];
        return new $className($image);
    }

}
