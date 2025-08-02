<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('cartItems.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.invoices', compact('invoices'));
    }

    public function destroy($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->with('cartItems.product')
            ->findOrFail($id);

        // بازگرداندن موجودی محصولات
        foreach ($invoice->cartItems as $item) {
            if ($item->product) {
                $item->product->count += $item->count;
                $item->product->save();
            }

            $item->delete(); // حذف آیتم سبد خرید
        }

        $invoice->delete(); // حذف خود فاکتور

        return redirect()->back()->with('success', 'فاکتور حذف شد و موجودی کالاها به انبار بازگردانده شد.');
    }
}
