<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CustomerPhotoManager extends FileManager
{
    public function uploadAndRemoveOld(UploadedFile $file, $customer)
    {
        $fileName = parent::upload($file);

        if (!$fileName) {
            return false;
        }

        $oldFilename = $customer->getPhoto();

        if ($oldFilename) {
            $this->remove($oldFilename);
        }

        return $fileName;
    }
}