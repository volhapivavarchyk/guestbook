<?php
declare(strict_types=1);

namespace Piv\Guestbook\Helpers\File;

class FileGif extends AFilePicture
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
