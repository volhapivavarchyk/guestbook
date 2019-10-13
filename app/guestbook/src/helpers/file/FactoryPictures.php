<?php
declare(strict_types=1);

namespace Piv\Guestbook\Helpers\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FactoryPictures
{
    protected $typeImage = [];

    public function __construct()
    {
        $this->typeImage['gif'] = 'Piv\Guestbook\Helpers\File\FileGif';
        $this->typeImage['jpeg'] = 'Piv\Guestbook\Helpers\File\FileJpg';
        $this->typeImage['png'] = 'Piv\Guestbook\Helpers\File\FilePng';
    }

    public function createImage(UploadedFile $image): AFilePicture
    {
        $className = $this->typeImage[$image->guessClientExtension()];
        return new $className($image);
    }
}
