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
        return Product::all(['id','title','description','price','image']);
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
        $imageData = $request->get('image');
        if ($imageData) {
            $property['image'] = $this->file->storeFile($imageData);
        }

        $product->create($property);
    }

    public function update($data, $file, $model)
    {
        $property = $this->setter($data);
        $imageData = $file->get('image');
        if ($imageData) {
            $this->file->removeFile($model->image);
            $property['image'] = $this->file->storeFile($imageData);
        }
        $model->update($property);
    }

    public function destroy($model)
    {
        $model->delete();
    }

}