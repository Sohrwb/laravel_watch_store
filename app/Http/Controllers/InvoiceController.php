<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    //-----------------------------------------[   لیست فاکتورهای کاربر  ]-----------------------------------------------

    public function index()
    {
        $invoices = Invoice::with(['cartItems.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.invoices', compact('invoices'));
    }

    //-----------------------------------------[  حذف فاکتور در انتظار پرداخت  ]-----------------------------------------------

    public function destroy($id)
    {
        $invoice = Invoice::with('cartItems.product')
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        foreach ($invoice->cartItems as $item) {
            if ($item->product) {
                $item->product->increment('count', $item->count);
            }

            $item->delete();
        }

        $invoice->delete(); 

        return redirect()->back()->with('success', '✅ فاکتور حذف شد و موجودی محصولات بازگردانده شد.');
    }
}
