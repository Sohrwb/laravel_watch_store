@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="row no-gutters">
                        <div class="col-md-5">
                            <img src="{{ asset('images/products/' . $product->image) }}" class="card-img"
                                alt="{{ $product->name }}">
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h3 class="card-title">{{ $product->name }}</h3>
                                <p class="card-text text-muted">{{ $product->description }}</p>
                                <h4 class="text-primary mb-4 text-decoration-line-through">قیمت:
                                    {{ number_format($product->price) }} تومان</h4>
                                <h4 class="text-danger mb-4"> قیمت با تخفیف : {{ number_format($product->discount_price) }}
                                    تومان
                                </h4>

                                @auth
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-flex flex-column">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        <div class="input-group mb-3" style="max-width: 150px;">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="changeCount(-1)">-</button>
                                            <input type="number" name="count" id="count" class="form-control text-center"
                                                value="1" min="1">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="changeCount(1)">+</button>
                                        </div>
                                        <button type="submit" class="btn btn-success">افزودن به سبد خرید</button>
                                    </form>
                                @else
                                    <div class="alert alert-warning mt-4">
                                        لطفاً <a href="{{ route('login') }}">وارد حساب کاربری</a> خود شوید تا بتوانید خرید کنید.
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
            let countInput = document.getElementById('count');
            let current = parseInt(countInput.value);
            let newCount = current + change;
            if (newCount >= 1) {
                countInput.value = newCount;
            }
        }
    </script>
@endsection
