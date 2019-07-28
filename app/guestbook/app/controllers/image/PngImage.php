<?
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers\Image;

class PngImage implements ImageInterface
{

    public function createImageFromFile(string $filename): resource
    {
        return imagecreatefrompng($filename);
    }

    public function createFileFromImage(resource $new_image, string $path, string $filename): void
    {
        imagepng($new_image, $path . $fileImg->getClientFilename());
    }

}
