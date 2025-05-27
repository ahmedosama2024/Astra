<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $products = $category->products()->with('categories', 'prices')->paginate(10);
        
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request, Category $category)
    {
        $product = $request->storeProduct();

        return response([
            'message' => __('products.store'),
            'product' => new ProductResource($product),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, Product $product)
    {
        return response([
            'product' => new ProductResource($product),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Category $category, Product $product)
    {
        $product = $request->updateProduct();

        return response([
            'message' => __('products.update'),
            'product' => new ProductResource($product),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->remove();

        return response([
            'message' => __('products.delete'),
        ]);
    }
}
