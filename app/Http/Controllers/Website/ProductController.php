<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\ProductResource;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $products = $category->products()->with(['categories', 'prices'])->paginate(10);
        return ProductResource::collection($products);
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
}
