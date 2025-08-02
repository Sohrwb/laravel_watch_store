<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    // نمایش فرم ویرایش
    public function edit($id)
    {
        $item = CartItem::with('product')->where('user_id', Auth::id())->findOrFail($id);
        return view('cart.edit', compact('item'));
    }

    // ذخیره تغییرات
    public function update(Request $request, $id)
    {
        $request->validate([
            'count' => 'required|integer|min:1',
        ]);
        $cartItem = CartItem::findOrFail($id);
        $product = Product::findOrFail($cartItem->product_id);

        $totalcount = $request->count - $cartItem->count;

        if ($product->count  < $totalcount) {
            return redirect()->back()->with('error', 'موجودی کافی نیست.');
        }

        $item = CartItem::where('user_id', Auth::id())->findOrFail($id);
        $item->count = $request->count;
        $item->save();

        $product->count -= $totalcount;
        $product->save();

        return redirect()->route('profile')->with('success', 'آیتم با موفقیت ویرایش شد.');
    }

    // حذف آیتم
    public function destroy($id)
    {
        $item = CartItem::where('user_id', Auth::id())->findOrFail($id);


        if ($item->product) {
            $item->product->count += $item->count;
            $item->product->save();
        }


        $item->delete();

        return redirect()->back()->with('success', 'آیتم از سبد خرید حذف شد.');
    }
}
