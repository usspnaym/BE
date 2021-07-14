<?php

namespace App\Http\Controllers;

use App\Helpers\FormatResponse;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        if(!Auth::guard('sanctum')->check()) {
            return response()->json(FormatResponse::error(403, 'login'));
        }

        $cat = Category::create($request->all());
        return $cat;
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        if(!Auth::guard('sanctum')->check()) {
            return response()->json(FormatResponse::error(403, 'login'));
        }

        $cat = $category->update($request->all());
        return $cat;
    }
}
