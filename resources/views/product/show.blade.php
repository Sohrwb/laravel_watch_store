@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card shadow-sm">
                    <div class="row g-0">
                        <div class="col-12 col-md-5">
                            <img src="{{ asset('images/products/' . $product->image) }}" class="card-img img-fluid"
                                alt="{{ $product->name }}">
                        </div>
                        <div class="col-12 col-md-7">
                            <div class="card-body">
                                <h3 class="card-title">{{ $product->name }}</h3>
                                <p class="card-text text-muted">{{ $product->description }}</p>

                                <h4 class="text-primary mb-2 text-decoration-line-through">
                                    قیمت: {{ number_format($product->price) }} تومان
                                </h4>
                                @php
                                    $final_price =
                                        $product->price - ($product->price * $product->discount_percent) / 100;
                                @endphp
                                <h4 class="text-danger mb-4">
                                    قیمت با تخفیف: {{ number_format($final_price) }} تومان
                                </h4>

                                <div class="d-flex gap-3 mb-4 flex-wrap">
                                    @if ($product->size)
                                        <div class="border rounded px-3 py-2 flex-fill text-center"
                                            style="min-width:120px;">
                                            <strong class="d-block mb-1 fs-5">سایز</strong>
                                            <span class="fs-6">{{ $product->size->name }}</span>
                                        </div>
                                    @endif

                                    @if ($product->color)
                                        <div class="border rounded px-3 py-2 flex-fill text-center"
                                            style="min-width:120px;">
                                            <strong class="d-block mb-1 fs-5">رنگ</strong>
                                            <span class="fs-6">{{ $product->color->name }}</span>
                                        </div>
                                    @endif
                                </div>

                                <h3 class="mb-3">تعداد :</h3>
                                @if ($product->count < 3)
                                    <p class="text-danger mt-2">تنها {{ $product->count }} عدد دیگر مانده</p>
                                @endif

                                @auth
                                    <form action="{{ route('cart.add') }}" method="POST"
                                        class="d-flex flex-column flex-sm-row align-items-center gap-3">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        <div class="input-group" style="max-width: 140px;">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="changeCount(-1)">-</button>
                                            <input type="number" name="count" id="count" class="form-control text-center"
                                                value="1" min="1" style="max-width: 70px;">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="changeCount(1)">+</button>
                                        </div>

                                        <button type="submit" class="btn btn-success flex-grow-1 flex-sm-grow-0">افزودن به سبد
                                            خرید</button>
                                    </form>
                                @else
                                    <div class="alert alert-warning mt-4">
                                        لطفاً <a href="{{ route('login') }}">وارد حساب کاربری</a> شوید تا بتوانید خرید کنید.
                                    </div>
                                @endauth

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeCount(change) {
            const countInput = document.getElementById('count');
            let current = parseInt(countInput.value) || 1;
            let newCount = current + change;
            if (newCount >= 1) {
                countInput.value = newCount;
            }
        }
    </script>
@endsection
