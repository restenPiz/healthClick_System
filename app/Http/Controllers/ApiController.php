<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function category()
    {
        $categories = Category::all();

        return response()->json([
            'status' => true,
            'categories' => $categories
        ]);
    }
}
