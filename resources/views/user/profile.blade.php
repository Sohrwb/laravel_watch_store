@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border bg-white shadow-lg rounded p-2 m-1 ">
            <a href="{{ route('user.invoices') }}" class="btn btn-primary">فاکتور های من</a>

            <h4 class="mb-3">سبد خرید شما</h4>
            @php $cartTotal = 0; @endphp
            @forelse($cartItems as $item)
                @php
                    $price = $item->product->price;
                    $discountPercent = $item->product->discount_percent ?? 0;
                    $finalPrice = $discountPercent > 0 ? $price - ($price * $discountPercent) / 100 : $price;
                    $itemTotal = $finalPrice * $item->count;
                    $cartTotal += $itemTotal;
                @endphp

                <div class="d-flex align-items-center border rounded p-2 mb-2 shadow-sm bg-light">
                    {{-- تصویر محصول --}}
                    <img src="{{ asset('images/products/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                        style="width: 80px; height: 80px; object-fit: cover;" class="me-3 rounded">

                    {{-- اطلاعات محصول --}}
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $item->product->name }}</h6>
                        <div>
                            تعداد: {{ $item->count }} |
                            قیمت واحد:
                            {{ number_format($finalPrice) }} تومان
                        </div>
                    </div>

                    {{-- دکمه‌ها --}}
                    <div class="d-flex flex-column gap-1">
                        <a href="{{ route('cart-item.edit', $item->id) }}" class="btn btn-sm btn-primary">ویرایش</a>
                        <form action="{{ route('cart-item.destroy', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>سبد خرید شما خالی است.</p>
            @endforelse

            @if ($cartItems->count())
                <div class="text-first fw-bold mt-3">
                    جمع کل سبد خرید: {{ number_format($cartTotal) }} تومان
                </div>

                <form action="{{ route('cart.checkout') }}" method="POST" class="p-2 mx-auto">
                    @csrf
                    <button class="btn btn-success">پرداخت سبد خرید</button>
                </form>
            @endif
        </div>

        <hr class="my-5">

        {{-- 📄 فاکتورهای در انتظار پرداخت --}}
        <h4 class="mb-3">فاکتورهای در انتظار پرداخت</h4>
        @forelse($pendingInvoices as $invoice)
            <div class="card mb-4 border-warning border-2">
                <div class="card-header d-flex justify-content-between align-items-center bg-warning bg-opacity-25">
                    <div>
                        فاکتور شماره: {{ $invoice->invoice_number }} <br>
                        تاریخ: {{ \Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d') }}
                    </div>
                    <div class="fw-bold">جمع کل: {{ number_format($invoice->total_price) }} تومان</div>
                </div>
                <div class="card-body">
                    @foreach ($invoice->cartItems as $item)
                        @php
                            $price = $item->product->price;
                            $discountPercent = $item->product->discount_percent ?? 0;
                            $finalPrice = $discountPercent > 0 ? $price - ($price * $discountPercent) / 100 : $price;
                            $itemTotal = $finalPrice * $item->count;
                        @endphp

                        <div class="d-flex align-items-center border rounded p-2 mb-2 bg-white">
                            <img src="{{ asset('images/products/' . $item->product->image) }}"
                                alt="{{ $item->product->name }}" style="width: 60px; height: 60px; object-fit: cover;"
                                class="me-3 rounded">

                            <div>
                                <div class="fw-bold">{{ $item->product->name }}</div>
                                <div>تعداد: {{ $item->count }} | قیمت کل:
                                    {{ number_format($itemTotal) }} تومان</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer d-flex justify-content-end gap-2">
                    <form method="get" action="{{ route('payment.gateway', $invoice->id) }}">
                        @csrf
                        <button class="btn btn-success btn-sm">پرداخت</button>
                    </form>
                    <form method="POST" action="{{ route('invoice.destroy', $invoice->id) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">حذف فاکتور</button>
                    </form>
                </div>
            </div>
        @empty
            <p>هیچ فاکتور در انتظاری وجود ندارد.</p>
        @endforelse
    </div>
@endsection
