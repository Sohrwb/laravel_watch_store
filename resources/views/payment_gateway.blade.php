@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <div class="border rounded shadow p-4 bg-light">
        <h2 class="mb-4">🧾 درگاه پرداخت</h2>

        <p class="fs-5">شماره فاکتور: <strong>{{ $invoice->invoice_number }}</strong></p>
        <p class="fs-5">مبلغ قابل پرداخت:
            <strong class="text-success">{{ number_format($invoice->total_price) }} تومان</strong>
        </p>

        <div class="mt-4">
            <form action="{{ route('payment.confirm', $invoice->id) }}" method="POST" style="display: inline-block;">
                @csrf
                <button type="submit" class="btn btn-success btn-lg px-4">پرداخت</button>
            </form>

            <form action="{{ route('payment.cancel', $invoice->id) }}" method="POST"
                  style="display: inline-block; margin-right: 15px;">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-lg px-4">انصراف</button>
            </form>
        </div>
    </div>
</div>
@endsection
