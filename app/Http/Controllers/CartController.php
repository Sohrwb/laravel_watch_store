<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\CartItem;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // افزودن محصول به سبد خرید
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'count'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = Auth::user();

        if ($product->discount_price <= 0) {
            $total = $product->price * $request->count;
        }
        $total = $product->discount_price * $request->count;

        CartItem::create([
            'user_id'     => $user->id,
            'product_id'  => $product->id,
            'count'    => $request->count,
            'total_price' => $total,
            'invoice_id'  => null,
        ]);

        return back()->with('success', 'محصول به سبد خرید اضافه شد.');
    }

    // ساخت فاکتور و هدایت به درگاه فرضی
    public function checkout()
    {
        $user = Auth::user();
        $items = CartItem::where('user_id', $user->id)->whereNull('invoice_id')->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'سبد خرید شما خالی است.');
        }

        $total = $items->sum('total_price');
        $invoiceNumber = $this->generateInvoiceNumber();

        $invoice = Invoice::create([
            'user_id'        => $user->id,
            'invoice_number' => $invoiceNumber,
            'total_price'    => $total,
            'status'         => 'pending',
            'payment_date'   => null,
        ]);



        return redirect()->route('payment.gateway', $invoice->id);
    }

    // نمایش درگاه فرضی
    public function showGateway($id)
    {
        $invoice = Invoice::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('payment_gateway', compact('invoice'));
    }

    // تأیید پرداخت
    public function confirmPayment($id)
    {
        $invoice = Invoice::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $invoice->update([
            'status' => 'paid',
            'payment_date' => now(),
        ]);

        $user = Auth::user();
        $items = CartItem::where('user_id', $user->id)->whereNull('invoice_id')->get();

        CartItem::where('user_id', Auth::id())->whereNull('invoice_id')->update([
            'invoice_id' => $invoice->id,
        ]);

        return redirect()->route('profile', $invoice->id)->with('success', 'پرداخت با موفقیت انجام شد.');
    }

    // لغو پرداخت
    public function cancelPayment($id)
    {
        $invoice = Invoice::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        CartItem::where('user_id', Auth::id())->whereNull('invoice_id')->update([
            'invoice_id' => $invoice->id,
        ]);

        return redirect()->route('home')->with('info', 'پرداخت لغو شد.');
    }

    // تولید شماره فاکتور براساس تاریخ و ترتیب
    private function generateInvoiceNumber()
    {
        $today = Carbon::now()->format('Ymd');
        $countToday = Invoice::whereDate('created_at', Carbon::today())->count() + 1;
        return $today . '-' . str_pad($countToday, 5, '0', STR_PAD_LEFT);
    }
}
