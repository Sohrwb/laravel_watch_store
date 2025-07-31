@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>پروفایل و سبد خرید شما</h2>


        @if ($cartItems->isEmpty())
            <p>سبد خرید شما خالی است.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>عکس</th>
                        <th>نام محصول</th>
                        <th>تعداد</th>
                        <th>قیمت واحد</th>
                        <th>قیمت کل</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($cartItems as $item)
                        @php
                            if ($item->product->discount_price <= 0) {
                                $itemTotal = $item->product->price * $item->count;
                            }
                            $itemTotal = $item->product->discount_price * $item->count;
                            $total += $itemTotal;
                        @endphp
                        <tr>

                            <td style="width: 80px;">
                                <img src="{{ asset('images/products/' . $item->product->image) }}"
                                    alt="{{ $item->product->name }}"
                                    style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
                            </td>


                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->count }}</td>
                            <td>{{ number_format($item->product->discount_price) }} تومان</td>
                            <td>{{ number_format($itemTotal) }} تومان</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">ویرایش</a>
                                <form action="#" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('آیا مطمئن هستید؟')">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-end"><strong>جمع کل:</strong></td>
                        <td colspan="2"><strong>{{ number_format($total) }} تومان</strong></td>
                    </tr>
                </tbody>
            </table>

            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-lg">پرداخت</button>
            </form>
        @endif

    </div>
@endsection
