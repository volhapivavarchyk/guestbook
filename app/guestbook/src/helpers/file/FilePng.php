<?php
declare(strict_types=1);

namespace Piv\Guestbook\Helpers\File;

class FilePng extends AFilePicture
{

    /**
     * @param string $filename
     * @return false|resource
     */
    protected function createImageFromFile(string $filename)
    {
        return imagecreatefrompng($filename);
    }

    /**
     * @param $newImage
     * @param string $filename
     */
    protected function createFileFromImage($newImage, string $filename): void
    {
        imagepng($newImage, $filename);
    }
}
