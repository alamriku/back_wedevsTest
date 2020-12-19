<?php


namespace App\Services;
use Image;

class FileService
{
    public function storeFile($data)
    {
        $imageData = $data;
        $fileName = uniqid().'.'.explode('/',
                explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
        Image::make($imageData)->save('image/'.$fileName);
        return 'image/' . $fileName;
    }

    public function removeFile($filePath)
    {
        unlink(public_path("$filePath"));
    }
}