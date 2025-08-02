@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">{{ $category->name }}</h1>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('images/products/' . $product->image) }}" class="card-img-top"
                            alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">
                                @if (!$product->discount_price <= 0)
                                    <h6 class="text-danger product-price text-decoration-line-through">
                                       قیمت اصلی : {{ number_format($product->price) }} تومان</h6>
                                    <p class="text-success mb-4"> قیمت با تخفیف :
                                        {{ number_format($product->discount_price) }} تومان
                                    @else
                                    <p class="text-primary mb-4"></p>

                                    <h6 class="product-price text-white">
                                        {{ number_format($product->price) }} تومان</h6>
                                @endif

                            </p>
                        </div>
                        <div class="card-footer bg-white">
                            @if ($product->count > 0)
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary w-100">مشاهده
                                    محصول</a>
                            @else
                                <button class="btn btn-secondary w-100" disabled>موجود نمی‌باشد</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- دکمه See More (Pagination) -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
