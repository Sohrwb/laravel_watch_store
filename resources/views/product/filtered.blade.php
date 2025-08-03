@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-md-3 bg-white p-3 border-end" id="sidebarFilter">
                @include('partials._product_filters')
            </div>

            {{-- Button for mobile --}}
            <button class="btn btn-secondary d-md-none m-2" id="openFilter">فیلتر محصولات</button>

            {{-- Product List --}}
            <div class="col-md-9">
                <div class="row"> <!-- اضافه کردن این ردیف -->
                    {{-- نمایش محصولات فیلترشده --}}
                    @forelse ($products as $product)
                        @php
                            $hasDiscount = $product->discount_percent > 0;
                            $finalPrice = $hasDiscount
                                ? $product->price - ($product->price * $product->discount_percent) / 100
                                : $product->price;
                        @endphp

                        <div class="col-md-3 mb-4"> <!-- این کلاس صحیح است -->
                            <div class="card h-100">
                                @if ($hasDiscount)
                                    <span class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-bottom-end discount-badge">
                                        {{ $product->discount_percent }}٪ تخفیف
                                    </span>
                                @endif

                                <img src="{{ asset('images/products/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>

                                    @if ($hasDiscount)
                                        <p class="text-danger text-decoration-line-through mb-1">
                                            قیمت اصلی: {{ number_format($product->price) }} تومان
                                        </p>
                                        <p class="text-success mb-1">
                                            قیمت با تخفیف: {{ number_format($finalPrice) }} تومان
                                        </p>
                                    @else
                                        <p class="text-primary">
                                            {{ number_format($product->price) }} تومان
                                        </p>
                                    @endif
                                </div>

                                <div class="card-footer bg-white">
                                    @if ($product->count > 0)
                                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary w-100">مشاهده محصول</a>
                                    @else
                                        <button class="btn btn-secondary w-100" disabled>موجود نمی‌باشد</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="col-12">
                            <p class="text-center">هیچ محصولی یافت نشد.</p>
                        </div>
                    @endforelse
                </div> <!-- بستن ردیف -->
            </div>
        </div>
    </div>

    {{-- JavaScript برای باز و بسته کردن سایدبار در موبایل --}}
    <script>
        document.getElementById('openFilter').addEventListener('click', function() {
            document.getElementById('sidebarFilter').style.display = 'block';
        });

        document.getElementById('toggleFilter').addEventListener('click', function() {
            document.getElementById('sidebarFilter').style.display = 'none';
        });
    </script>
@endsection
