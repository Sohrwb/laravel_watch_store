<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    //-----------------------------------------[  نمایش صفحه کتگوری مدنظر  ]-----------------------------------------------

    public function show(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->where('count', '>', 0) // فقط محصولات موجود
            ->paginate(12); // 12 محصول در هر صفحه

        return view('category.show', compact('category', 'products'));
    }


    //-----------------------------------------[  افزودن کتگوری  ]-----------------------------------------------

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'دسته‌بندی با موفقیت اضافه شد.');
    }
}
