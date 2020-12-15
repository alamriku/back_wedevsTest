<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;



class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->allProduct();
        return response()->json(['products' => $products]);
    }

    public function store(ProductRequest $request)
    {
        if ($request->expectsJson()) {
            try {
                $this->productService->store($request->all(), $request);
            } catch (\Exception $e) {
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return response()->json(['success' => true, 'message' => 'saved']);
        }
    }

    public function edit(Product $product)
    {
        return response()->json(['product' => $product]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        if ($request->expectsJson()) {
            try {
                $this->productService->update($request->all(), $request, $product);
            } catch (\Exception $e) {
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return response()->json(['success' => true, 'message' => 'updated']);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $this->productService->destroy($product);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
        return response()->json(['success' => true, 'message' => 'deleted']);
    }
}
