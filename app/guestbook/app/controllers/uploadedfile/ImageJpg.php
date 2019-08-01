<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers\UploadedFile;

class ImageJpeg extends AImage
{

    protected function createImageFromFile(string $filename)
    {
        return imagecreatefromjpeg($filename);
    }

    protected function createFileFromImage($newImage, string $filename): void
    {
        imagejpeg($newImage, $filename);
    }
}
