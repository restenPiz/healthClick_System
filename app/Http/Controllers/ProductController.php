<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get()->map(function ($product) {
            $product->image_base64 = 'data:image/jpeg;base64,' . base64_encode(Storage::get($product->product_file));
            return $product;
        });

        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }
}
