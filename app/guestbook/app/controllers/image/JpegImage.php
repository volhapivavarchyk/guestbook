<?
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers\Image;

class JpegImage implements ImageInterface
{

    public function createImageFromFile(string $filename): resource
    {
        return imagecreatefromjpeg($filename);
    }

    public function createFileFromImage(resource $new_image, string $path, string $filename): void
    {
        imagejpeg($new_image, $path . $fileImg->getClientFilename());
    }
}
