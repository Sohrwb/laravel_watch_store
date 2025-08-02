<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $products = Product::where('category_id', $category->id)
        ->where('count', '>', 0) // فقط محصولات موجود
        ->paginate(12); // 12 محصول در هر صفحه

        return view('category.show', compact('category', 'products'));
    }
}
