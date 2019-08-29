<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Helpers\File;

class FilePng extends AFilePicture
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
