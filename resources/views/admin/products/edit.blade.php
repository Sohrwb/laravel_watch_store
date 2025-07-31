@extends('layouts.app')

@section('content')
    <style>
        .card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
        }

        .product-image {
            object-fit: cover;
            height: 60%;
            width: 100%;
        }
    </style>

    @php
        $discount_percent = (($product->price - $product->discount_price) / $product->price) * 100;
    @endphp

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="row g-0">
                        <!-- تصویر محصول -->
                        <div class="col-md-5">
                            <img src="{{ asset('images/products/' . $product->image) }}" class="product-image"
                                alt="{{ $product->name }}">
                        </div>

                        <!-- فرم ویرایش -->
                        <div class="col-md-7 p-4">
                            <h4 class="mb-4 text-center">ویرایش محصول</h4>

                            <form method="POST" action="{{ route('admin.products.update', $product->id) }}"
                                enctype="multipart/form-data" class="row g-3">
                                @csrf
                                @method('PUT')

                                <div class="col-12">
                                    <label class="form-label">تصویر جدید</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">نام محصول</label>
                                    <input type="text" name="name" class="form-control" value="{{ $product->name }}"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">دسته‌بندی</label>
                                    <select name="category" class="form-select" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">توضیحات</label>
                                    <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">سایز</label>
                                    <select name="size" class="form-select" required>
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->id }}"
                                                {{ $product->size_id == $size->id ? 'selected' : '' }}>
                                                {{ $size->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">رنگ</label>
                                    <select name="color" class="form-select" required>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->id }}"
                                                {{ $product->color_id == $color->id ? 'selected' : '' }}>
                                                {{ $color->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">قیمت اصلی</label>
                                    <input type="number" name="price" class="form-control" value="{{ $product->price }}"
                                        required id="price">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">درصد تخفیف</label>
                                    <input type="number" name="discount_percent" class="form-control"
                                        value="{{ $discount_percent }}" required id="discount">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">قیمت با تخفیف</label>
                                    <input type="number" class="form-control" id="discount_price" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">تعداد موجودی</label>
                                    <input type="number" name="count" class="form-control" value="{{ $product->count }}"
                                        required>
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-success px-4">ذخیره تغییرات</button>

                                    <a href="{{ route('admin.products.index') }}" class="btn btn-danger"> برگشت </a>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function calculateDiscountPrice() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const discount = parseFloat(document.getElementById('discount').value) || 0;
            const discountedPrice = price - (price * discount / 100);
            document.getElementById('discount_price').value = discountedPrice.toFixed(0);
        }

        document.getElementById('price').addEventListener('input', calculateDiscountPrice);
        document.getElementById('discount').addEventListener('input', calculateDiscountPrice);
        window.addEventListener('load', calculateDiscountPrice);
    </script>
@endpush
