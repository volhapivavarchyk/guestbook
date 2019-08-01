<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers\UploadedFile;

class ImageGif extends AImage
{

    protected function createImageFromFile(string $filename)
    {
        return imagecreatefromgif($filename);
    }

    protected function createFileFromImage($newImage, string $filename): void
    {
        imagegif($newImage, $filename);
    }
}
