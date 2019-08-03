<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers\UploadedFiles;

class ImagePng extends AImage
{

    protected function createImageFromFile(string $filename)
    {
        return imagecreatefrompng($filename);
    }

    protected function createFileFromImage($newImage, string $filename): void
    {
        imagepng($newImage, $filename);
    }
}
