<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        \Gate::authorize('view', 'products');
        $products = Product::paginate(15);
        return ProductResource::collection($products);
    }

    public function show($id)
    {
        \Gate::authorize('view', 'products');
        return new ProductResource(Product::find($id));
    }

    public function store(ProductCreateRequest $request)
    {
        \Gate::authorize('edit', 'products');
        $product = Product::create($request->only('title', 'image', 'description', 'price'));
        return response($product, 201);
    }

    public function update(Request $request, $id)
    {
        \Gate::authorize('edit', 'products');
        $product = Product::find($id);
        $product->update($request->only('title', 'image', 'description', 'price'));
        return response($product, 202);
    }

    public function destroy($id)
    {
        \Gate::authorize('edit', 'products');
        Product::destroy($id);
        return response(null, 204);
    }
}
