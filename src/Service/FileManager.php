<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{
    protected $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            return null;
        }

        return $fileName;
    }

    public function remove($fileName) {
        $filePath = $this->getTargetDirectory() . $fileName;

        try {
            if (file_exists($filePath)) {
                unlink($filePath);
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}