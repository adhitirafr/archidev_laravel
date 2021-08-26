<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;

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

        return response()->json(CategoryResource::collection($categories), 200);
    }

    public function show(Request $request)
    {
        $category = Category::findOrFail($request->category);

        return response()->json(new CategoryResource($category));
    }

    public function store(CategoryRequest $request)
    {
        $store = Category::create([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        if($store) {
            return response()->json([
                'message' => 'Kategori berhasil dibuat'
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'Kategori gagal dibuat'
            ], 500);
        }
    }

    public function update(CategoryRequest $request)
    {
        $category = Category::findOrFail($request->category);

        $update = $category->update([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        if($update) {
            return response()->json([
                'message' => 'Kategori berhasil diubah'
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'Kategori gagal diubah'
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->category);

        $delete = $category->delete();

        if($delete) {
            return response()->json([
                'message' => 'Kategori berhasil dihapus'
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'Kategori gagal dihapus'
            ], 500);
        }
    }
}
