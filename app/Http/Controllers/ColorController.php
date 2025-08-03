<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;

class ColorController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Color::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'دسته‌بندی با موفقیت اضافه شد.');
    }
}
