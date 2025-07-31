@extends('layouts.app')

@section('title', 'صفحه اصلی')

@section('content')


    <style>
        .card-img-top {
            height: 150px;
            object-fit: cover;
            border-radius: 12px;
        }

        .product-price {
            font-size: 0.85rem;
            color: #e16f6f;
            margin-bottom: 0.5rem;
        }
    </style>



    <div class="container py-5 ">
        <h2 class="mb-4 text-center text-black">محصولات ما</h2>

        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner ">
                @foreach ($products->chunk(3) as $chunkIndex => $productChunk)
                    <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($productChunk as $product)
                                @php
                                    $discount_percent =
                                        (($product->price - $product->discount_price) / $product->price) * 100;
                                @endphp
                                <div class="col-md-4">
                                    <div class="card mb-3 bg-dark shadow-sm">
                                        <div class="d-flex justify-content-center p-2">
                                            <img src="{{ asset('images/products/' . $product->image) }}"
                                                class="img-fluid w-50  border rounded" alt="{{ $product->name }}">
                                        </div>
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-white">{{ $product->name }}</h5>
                                            @if (!$discount_percent <= 0)
                                                <h6 class="product-price text-decoration-line-through">
                                                    {{ number_format($product->price) }} تومان</h6>
                                                <p class="text-primary mb-4"> قیمت با تخفیف :
                                                    {{ number_format($product->discount_price) }} تومان
                                                @else
                                                 <p class="text-primary mb-4"></p>

                                                <h6 class="product-price text-white">
                                                    {{ number_format($product->price) }} تومان</h6>
                                            @endif


                                            @if (!$product->count <= 0)
                                                <a href="{{ route('product.show', $product) }}"
                                                    class="btn btn-primary">مشاهده</a>
                                            @else
                                                <button class="btn btn-secondary" disabled> اتمام موجودی </button>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev " type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded " aria-hidden="true"></span>
                <span class="visually-hidden">قبلی</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded " aria-hidden="true"></span>
                <span class="visually-hidden">بعدی</span>
            </button>
        </div>
    </div>
@endsection
