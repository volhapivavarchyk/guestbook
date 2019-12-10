<?php
declare(strict_types=1);

namespace Piv\Guestbook\Helpers\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileTxt
{
    protected $file;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file): void
    {
        $this->file = $file;
    }

    public function moveFileTo(string $filenameFrom): void
    {
        $this->file->move($filenameFrom, $this->file->getClientOriginalName());
    }
}
