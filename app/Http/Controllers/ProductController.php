<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class ProductController extends Controller
{

    public function about()
    {
        return view('about.about');
    }

    public function home()
    {
        $products = Product::all();
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('home', compact('products', 'categories', 'sizes', 'colors'));
    }



 

    public function filterProduct(Request $request)
    {
        $query = Product::query()->where('count', '>', 0);

        // جستجو
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // فیلتر دسته‌بندی
        if ($request->has('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        // فیلتر رنگ
        if ($request->has('colors')) {
            $query->whereIn('color_id', $request->colors);
        }

        // فیلتر سایز
        if ($request->has('sizes')) {
            $query->whereIn('size_id', $request->sizes);
        }

        // فیلتر قیمت
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->get();

        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('product.filtered', compact('products', 'categories', 'colors', 'sizes'));
    }




    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.products.index', compact(['products', 'sizes', 'colors', 'categories']));
    }

    public function show(Product $product)
    {
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('product.show', compact(['product', 'sizes', 'colors', 'categories']));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.products.edit', compact(['product', 'sizes', 'colors', 'categories']));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'color' => 'required',
            'count' => 'required',
            'size' => 'required',
            'price' => 'required|integer',
            'discount_percent' => 'required|integer',
            'category' => 'required|integer',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); // فقط نام بدون پسوند
            $extension = $image->getClientOriginalExtension(); // پسوند فایل
            $filename = $originalName . '_' . time() . '.' . $extension; // مثلاً: product_1722279420.jpg

            $request->file('image')->move(public_path('images/products'), $filename);
        } else {
            return redirect()->back()->with('error', 'محصول اضافه نشد.');
        }

        Product::create([

            'name' => $request->name,
            'count' => $request->count,
            'description' => $request->description,
            'color_id' => $request->color,
            'size_id' => $request->size,
            'category_id' => $request->category,
            'price' => $request->price,
            'discount_percent' => $request->discount_percent,
            'image' => $filename
        ]);

        return redirect()->back()->with('success', 'محصول با موفقیت اضافه شد.');
    }


    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|min:10',
            'description' => 'required|min:10',
            'color' => 'required',
            'count' => 'required',
            'size' => 'required',
            'price' => 'required|integer|min:5000',
            'discount_percent' => 'required|integer',
            'category' => 'required|integer',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {

            if ($product->image && file_exists(public_path('images/products' . $product->image))) {
                unlink(public_path('images/products' . $product->image));
            }

            // به‌روزرسانی رکورد با عکس جدید

            $image = $request->file('image');
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); // فقط نام بدون پسوند
            $extension = $image->getClientOriginalExtension(); // پسوند فایل
            $filename = $originalName . '_' . time() . '.' . $extension; // مثلاً: product_1722279420.jpg
            $product->image = $filename;

            $request->file('image')->move(public_path('images/products'), $filename);
        } else {
            $filename = $product->image;
        }

        $product->update([

            'name' => $request->name,
            'count' => $request->count,
            'description' => $request->description,
            'color_id' => $request->color,
            'size_id' => $request->size,
            'category_id' => $request->category,
            'price' => $request->price,
            'discount_percent' => $request->discount_percent,
            'image' => $filename
        ]);

        return redirect()->route('admin.products.index')->with('success', 'تغییرات با موفقیت اعمال شد.');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // Soft delete

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت حذف شد.');
    }
}
