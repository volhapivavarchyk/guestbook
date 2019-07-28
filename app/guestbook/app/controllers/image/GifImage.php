<?
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers\Image;

class GifImage implements ImageInterface
{

    public function createImageFromFile(string $filename): resource
    {
        return imagecreatefromgif($filename);
    }

    public function createFileFromImage(resource $new_image, string $path, string $filename): void
    {
        imagegif($new_image, $path . $fileImg->getClientFilename());
    }

}
