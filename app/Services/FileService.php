<?php


namespace App\Services;


class FileService
{
    public function storeFile($data)
    {
        $fileName = time() . '.' . $data->getClientOriginalExtension();
        $data->move(public_path() . '/image', $fileName);
        return 'image/' . $fileName;
    }

    public function removeFile($filePath)
    {
        unlink(public_path("$filePath"));
    }
}