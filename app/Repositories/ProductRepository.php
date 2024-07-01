<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{

    public function all()
    {
        return Product::all();
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(array $data, $productId)
    {
        $product = Product::findOrFail($productId);
        return $product->update($data);

    }

    public function delete($product)
    {
        $product = Product::findOrFail($product);
        return $product->delete();

    }

    public function find($product)
    {
        return Product::findOrFail($product);
    }
}
