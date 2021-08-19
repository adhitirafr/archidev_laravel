<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderByDesc('created_at');

        if($request->search)
        {
            $categories = $categories->where('name', '%LIKE%', $request->search);
        }

        $categories = $categories->get();

        return response()->json(new CategoryResource($categories), 200);
    }
}
