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
}
