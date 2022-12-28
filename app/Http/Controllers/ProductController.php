<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::latest()->get();
        return response()->json([
            'data' => ProductResource::collection($product),
            'message' => 'Fetch all product',
            'success' => true
        ]);
    }

     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'quantity' => 'required',
            'uom' => 'required',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $product = Product::create([
            'name' => $request->get('name'),
            'quantity' => $request->get('quantity'),
            'uom' => $request->get('uom'),
            'price' => $request->get('price'),
        ]);

        return response()->json([
            'data' => new ProductResource($product),
            'message' => 'Post created successfully.',
            'success' => true
        ]);
    }

    public function show(Product $product)
    {
        return response()->json([
            'data' => new ProductResource($product),
            'message' => 'Data post found',
            'success' => true
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'quantity' => 'required',
            'uom' => 'required',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $product->update([
            'price' => $request->get('price'),
            'quantity' => $request->get('quantity'),
            'uom' => $request->get('uom'),
            'price' => $request->get('price'),
        ]);

        return response()->json([
            'data' => new ProductResource($product),
            'message' => 'Post updated successfully',
            'success' => true
        ]);
    }

     public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'data' => [],
            'message' => 'Post deleted successfully',
            'success' => true
        ]);
    }

}
