<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Helpers\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class AFilePicture
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

  public function moveImageTo(string $dirTo): void
  {
      $this->image->move($dirTo, $this->image->getClientOriginalName());
  }

  public function createImage(
      string $dirFrom,
      string $dirTo,
      int $widthMax,
      int $heightMax
  ) {
    $filename = $dirFrom.$this->image->getClientOriginalname();
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
    $this->createFileFromImage($newImage, $dirTo.$this->image->getClientOriginalname());
  }

  public function deleteFileFrom(string $dirFrom): void
  {
      unlink($dirFrom.$this->image->getClientOriginalname());
  }

  abstract protected function createImageFromFile(string $filename);
  abstract protected function createFileFromImage($newImage, string $filename): void;
}
