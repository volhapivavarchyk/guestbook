<?
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers\Image;

class PngImage implements ImageInterface
{
    protected $image;

    public function __construct($image)
    {
        $this->image = $image;
    }

    public function createImage()
    {
      $filename = Config::DIR_PUBLIC . "upload/temp/" . $fileImg->getClientFilename();
      $fileImg->moveTo($filename);
      $this->resizeAndMoveImage($fileImg, $filename, Config::DIR_PUBLIC . "upload/img/", 320, 240);
      $this->resizeAndMoveImage($fileImg, $filename, Config::DIR_PUBLIC . "upload/img/small/", 60,
          50);
      unlink($filename);
    }

    protected function resizeAndMoveImage(
        UploadedFile $fileImg,
        string $filename,
        string $path,
        int $max_width,
        int $max_height
    ): void {
        list($width, $height, $type) = getimagesize($filename);
        if (($width > $max_width) || ($height > $max_height)) {
            $w_index = $max_width / $width;
            $h_index = $max_height / $height;
            $new_width = $w_index > $h_index ? $width * $h_index : $width * $w_index;
            $new_height = $w_index > $h_index ? $height * $h_index : $height * $w_index;
        } else {
            $new_width = $width;
            $new_height = $height;
        }

        $new_image = imagecreatetruecolor((int)$new_width, (int)$new_height);
        $image = imagecreatefrompng($filename);
        imagecopyresampled(
            $new_image,
            $image,
            0,
            0,
            0,
            0,
            (int)$new_width,
            (int)$new_height,
            $width, $height
        );
        imagepng($new_image, $path . $fileImg->getClientFilename());
    }

}
