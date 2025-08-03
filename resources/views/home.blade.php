@extends('layouts.app')

@section('title', 'صفحه اصلی')

@section('content')
    <style>
        .card-img-top {
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-price {
            font-size: 0.85rem;
            color: #e16f6f;
            margin-bottom: 0.5rem;
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #dc3545;
            /* قرمز بوت‌استرپ */
            color: white;
            padding: 3px 8px;
            font-size: 0.75rem;
            border-radius: 0.3rem;
            z-index: 10;
        }

        .category-product-card {
            border: 1px solid #dee2e6;
            /* خط دور کارت */
            border-radius: 8px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .category-product-card .card-body {
            flex-grow: 1;
            padding: 0.5rem 0.75rem;
            text-align: center;
        }

        .category-product-card .btn-view {
            margin: 0 0.75rem 0.75rem 0.75rem;
        }
    </style>

    <div class="container py-5">

        {{-- بخش محصولات تخفیف‌دار --}}
        <h2 class="mb-4 text-center text-black">محصولات تخفیف‌دار</h2>

        <div id="discountedProductCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @php
                    $discountedProducts = $products->filter(fn($p) => $p->discount_percent > 0);
                @endphp

                @foreach ($discountedProducts->chunk(3) as $chunkIndex => $productChunk)
                    <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($productChunk as $product)
                                @php
                                    $final_price =
                                        $product->price - ($product->price * $product->discount_percent) / 100;
                                @endphp
                                <div class="col-md-4">
                                    <div class="card mb-3 bg-dark shadow-sm position-relative">
                                        <span class="discount-badge">{{ $product->discount_percent }}٪ تخفیف</span>

                                        <div class="d-flex justify-content-center p-2">
                                            <img src="{{ asset('images/products/' . $product->image) }}"
                                                class="img-fluid w-50 border rounded" alt="{{ $product->name }}">
                                        </div>
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-white">{{ $product->name }}</h5>

                                            <h6 class="product-price text-decoration-line-through text-white">
                                                {{ number_format($product->price) }} تومان
                                            </h6>
                                            <p class="text-primary mb-4">
                                                قیمت با تخفیف: {{ number_format($final_price) }} تومان
                                            </p>

                                            @if ($product->count > 0)
                                                <a href="{{ route('product.show', $product) }}"
                                                    class="btn btn-primary">مشاهده</a>
                                            @else
                                                <button class="btn btn-secondary" disabled>اتمام موجودی</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#discountedProductCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded" aria-hidden="true"></span>
                <span class="visually-hidden">قبلی</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#discountedProductCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded" aria-hidden="true"></span>
                <span class="visually-hidden">بعدی</span>
            </button>
        </div>

        {{-- بخش محصولات دسته‌بندی‌ها --}}
        <h2 class="mb-4 text-center text-black">محصولات دسته‌بندی‌ها</h2>

        <div class="row">
            @foreach ($categories as $category)
                @php
                    // محصولات دسته بندی به صورت رندوم (مثلاً 4 محصول در دسترس)
                    $availableProducts = $category->products->where('count', '>', 0);
                    $randomProducts =
                        $availableProducts->count() > 4 ? $availableProducts->random(4) : $availableProducts;
                @endphp

                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $category->name }}</h5>
                            <a href="{{ route('category.show', $category->id) }}" class="btn btn-sm btn-outline-primary">
                                مشاهده بیشتر
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">
                                @foreach ($randomProducts as $product)
                                    @php
                                        $hasDiscount = $product->discount_percent > 0;
                                        $finalPrice = $hasDiscount
                                            ? $product->price - ($product->price * $product->discount_percent) / 100
                                            : $product->price;
                                    @endphp

                                    <div class="col-6">
                                        <div class="category-product-card">
                                            <img src="{{ asset('images/products/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="card-img-top">

                                            <div class="card-body">
                                                <h6 class="card-title mb-1" style="font-size: 0.9rem;">
                                                    {{ $product->name }}
                                                </h6>

                                                @if ($hasDiscount)
                                                    <p class="text-danger text-decoration-line-through mb-0"
                                                        style="font-size: 0.8rem;">
                                                        {{ number_format($product->price) }} تومان
                                                    </p>
                                                    <p class="text-success mb-2" style="font-size: 0.9rem;">
                                                        {{ number_format($finalPrice) }} تومان
                                                    </p>
                                                @else
                                                    <p class="text-primary mb-2" style="font-size: 0.9rem;">
                                                        {{ number_format($product->price) }} تومان
                                                    </p>
                                                @endif

                                                <a href="{{ route('product.show', $product->id) }}"
                                                    class="btn btn-primary btn-sm btn-view">
                                                    مشاهده
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
