@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h2>درگاه پرداخت</h2>
    <p>شماره فاکتور: <strong>{{ $invoice->invoice_number }}</strong></p>
    <p>مبلغ قابل پرداخت: <strong>{{ number_format($invoice->total_price) }} تومان</strong></p>

    <form action="{{ route('payment.confirm', $invoice->id) }}" method="POST" style="display: inline-block;">
        @csrf
        <button type="submit" class="btn btn-success">پرداخت کردن</button>
    </form>

    <form action="{{ route('payment.cancel', $invoice->id) }}" method="POST" style="display: inline-block; margin-left: 10px;">
        @csrf
        <button type="submit" class="btn btn-danger">منصرف شدم</button>
    </form>
</div>
@endsection
