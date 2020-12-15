<?php


namespace App\Services;


use App\Models\Product;

class ProductService
{
    protected $file;
    public function __construct(FileService $file)
    {
        $this->file = $file;
    }

    public function allProduct()
    {
        return Product::all();
    }

    public function setter($value)
    {
        $data = [
            'title' => $value['title'],
            'description' => $value['description'],
            'price' => $value['price'],
        ];
        return $data;
    }

    public function store($data, $request)
    {
        $product = new Product();
        $property = $this->setter($data);
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $property['image'] = $this->file->storeFile($request->file('image'));
            }
        }

        $product->create($property);
    }

    public function update($data, $file, $model)
    {
        $property = $this->setter($data);
        if ($file->hasFile('image')) {
            if ($file->file('image')->isValid()) {
                $property['image'] = $this->file->storeFile($file->file('image'));
            }
        }

        $model->update($property);
    }

}