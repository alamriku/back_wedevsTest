<?php


namespace App\Services;



class FileService
{
    public function storeFile($data)
    {

        $file = $data->file('image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path() . '/image', $fileName);
        return 'image/' . $fileName;

//        $fileName = uniqid().'.'.explode('/',
//                explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
//        Image::make($imageData)->save('image/'.$fileName);
//        return 'image/' . $fileName;
    }

    public function removeFile($filePath)
    {
        if(file_exists(public_path("$filePath"))){
            unlink(public_path("$filePath"));
        }

    }
}