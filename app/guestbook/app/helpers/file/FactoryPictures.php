<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Helpers\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FactoryPictures
{

    protected $typeImage = [];

    public function __construct()
    {
        $this->typeImage['gif'] = 'Piv\Guestbook\App\Helpers\File\FileGif';
        $this->typeImage['jpeg'] = 'Piv\Guestbook\App\Helpers\File\FileJpeg';
        $this->typeImage['png'] = 'Piv\Guestbook\App\Helpers\File\FilePng';
    }

    public function createImage(UploadedFile $image): AFilePicture
    {
        $className = $this->typeImage[$image->guessClientExtension()];
        return new $className($image);
    }

}
