<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $list = Category::all();
        return response()->json($list,200);
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $category = Category::create($input);
        return response()->json($category);
    }
}
