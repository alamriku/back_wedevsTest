<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;

use \Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function store(ProductRequest $request)
    {

        if($request->expectsJson()){
            try{
                $this->productService->store($request->all(),$request);
            }catch (\Exception $e){
                return response()->json([
                    'exception'=>get_class($e),
                    'message'=>$e->getMessage(),
                    'trace'=>$e->getTrace(),
                ]);
            }
            return response()->json(['success'=>true,'message'=>'saved']);
        }
    }
}
