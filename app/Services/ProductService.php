<?php


namespace App\Services;


use App\Models\Product;
use App\Services\FileService;

class ProductService
{
    protected $file;

    public function __construct(FileService $file)
    {
        $this->file = $file;
    }
    public function store($data,$request)
    {
        $product = new Product();
        $product->title = $data['title'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $product->image = $this->file->storeFile($request->file('image'));
            }
        }
        $product->save();
    }
}