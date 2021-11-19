<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        protected SluggerInterface $slugger,
        protected string $uploadPath,
    ) {
    }

    public function uploadFile(UploadedFile|File $file): File
    {
        $imageFilename = $this->slugger
            ->slug($this->getFilename($file))
            ->append('-' . microtime(true))
            ->append('.' . $file->guessExtension())
            ->toString();

        return $file->move($this->uploadPath, $imageFilename);
    }

    private function getFilename(UploadedFile|File $file): string
    {
        if ($file instanceof UploadedFile) {
            return pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        }

        return pathinfo($file->getFilename(), PATHINFO_FILENAME);
    }
}
