<?
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers\Image;

interface ImageFactory
{
    protected $image;

    public function __constract($image)
    {
        $this->image = $image;
    }

    public function createJpegImage()
    {
        return new JpegImage($this->image);
    }

    public function createPngImage()
    {
        return new PngImage($this->image);
    }

    public function createGifImage()
    {
        return new GifImage($this->image);
    }

}
