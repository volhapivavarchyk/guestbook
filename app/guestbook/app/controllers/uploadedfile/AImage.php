<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers\UploadedFile;

use \Zend\Diactoros\UploadedFile;

abstract class AImage
{

  protected $image;

  public function __construct(UploadedFile $image)
  {
      $this->image = $image;
  }

  public function getImage(): UploadedFile
  {
      return $this->image;
  }

  public function setImage(UploadedFile $image): void
  {
      $this->image = $image;
  }

  public function moveImageTo(string $filenameFrom): void
  {
      $this->image->moveTo($filenameFrom.$this->image->getClientFilename());
  }

  public function createImage(
      string $filenameFrom,
      string $filenameTo,
      int $widthMax,
      int $heightMax
  ) {
    $filename = $filenameFrom.$this->image->getClientFilename();
    list($width, $height, $type) = getimagesize($filename);
    if (($width > $widthMax) || ($height > $heightMax)) {
        $indexW = $widthMax / $width;
        $indexH = $heightMax / $height;
        $newWidth = $indexW > $indexH ? $width * $indexH : $width * $indexW;
        $newHeight = $indexW > $indexH ? $height * $indexH : $height * $indexW;
    } else {
        $newWidth = $width;
        $newHeight = $height;
    }

    $newImage = imagecreatetruecolor((int)$newWidth, (int)$newHeight);
    $image = $this->createImageFromFile($filename);
    imagecopyresampled(
        $newImage,
        $image,
        0,
        0,
        0,
        0,
        (int)$newWidth,
        (int)$newHeight,
        $width,
        $height
    );
    $this->createFileFromImage($newImage, $filename);
  }

  abstract protected function createImageFromFile(string $filename);
  abstract protected function createFileFromImage($newImage, string $filename): void;
}
