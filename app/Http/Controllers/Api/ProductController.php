<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResourse;
use App\Interfaces\ProductRepositoryInterface;
use App\Services\ApiResponseClass;

class ProductController extends Controller
{
    protected $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index()
    {
        $products = $this->productRepository->all();
        return ApiResponseClass::sendResponse(ProductResourse::collection($products), '', 200);
    }

    public function show($productId)
    {
        $product = $this->productRepository->find($productId);
        return ApiResponseClass::sendResponse(new ProductResourse($product), '', 200);

    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productRepository->create($request->all());
        return ApiResponseClass::sendResponse(new ProductResourse($product), 'Product Create Successful', 200);

    }
    public function update(UpdateProductRequest $request, $productId)
    {
        $product = $this->productRepository->update($request->all(), $productId);
        return ApiResponseClass::sendResponse('Product Update Successful', "", 200);

    }

    public function destroy($productId)
    {
        $product = $this->productRepository->delete($productId);
        return ApiResponseClass::sendResponse('Product Delete Successful', '', 200);
    }
}
