<?php

declare(strict_types=1);

namespace App\Service;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        protected SluggerInterface $slugger,
        protected Filesystem $articleFilesystem,
    ) {
    }

    /**
     * @throws FilesystemException
     */
    public function uploadFile(UploadedFile|File $file): string
    {
        $filename = $this->slugger
            ->slug($this->getFilename($file))
            ->append('-' . microtime(true))
            ->append('.' . $file->guessExtension())
            ->toString();

        if ($stream = fopen($file->getPathname(), 'rb')) {
            $this->articleFilesystem->writeStream($filename, $stream);
            fclose($stream);
        }

        return $filename;
    }

    /**
     * @throws FilesystemException
     */
    public function removeFile(string $filename): void
    {
        if ($this->articleFilesystem->fileExists($filename)) {
            $this->articleFilesystem->delete($filename);
        }
    }

    private function getFilename(UploadedFile|File $file): string
    {
        if ($file instanceof UploadedFile) {
            return pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        }

        return pathinfo($file->getFilename(), PATHINFO_FILENAME);
    }
}
