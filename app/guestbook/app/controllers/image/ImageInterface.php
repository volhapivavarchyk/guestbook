<?
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers\Image;

interface ImageInterface
{
    public function createImage();
    protected function resizeAndMoveImage(
        UploadedFile $fileImg,
        string $filename,
        string $path,
        int $max_width,
        int $max_height
    ): void;    
}
