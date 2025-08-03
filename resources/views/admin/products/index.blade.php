@extends('layouts.app')

@section('content')
    <div class="container bg-secondary p-2 border rounded">
        <h2>مدیریت محصولات</h2>

        {{-- دکمه‌های افزودن سریع با Modal --}}
        <div class="mb-3 d-flex justify-content-end gap-2">
            <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                افزودن دسته‌بندی
            </button>
            <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#addColorModal">
                افزودن رنگ
            </button>
        </div>

        {{-- فرم افزودن محصول --}}
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="row g-3 mb-5">
            @csrf
            <div class="col-md-4">
                <label>نام محصول</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="col-md-2">
                <label>دسته بندی</label>
                <select name="category" class="form-select" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label>توضیحات</label>
                <textarea name="description" class="form-control" required>{{ old('description') }}</textarea>
            </div>

            <div class="col-md-3">
                <label>سایز</label>
                <select name="size" class="form-select" required>
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>تصویر محصول</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="col-md-3">
                <label>رنگ</label>
                <select name="color" class="form-select" required>
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>قیمت اصلی</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required
                    id="price">
            </div>

            <div class="col-md-3">
                <label>درصد تخفیف</label>
                <input type="number" name="discount_percent" class="form-control" value="{{ old('discount_percent') }}"
                    required id="discount">
            </div>

            <div class="col-md-3">
                <label>قیمت با تخفیف</label>
                <input type="number" class="form-control" id="discount_price" readonly>
            </div>

            <div class="col-md-3">
                <label>تعداد</label>
                <input type="number" name="count" class="form-control" value="{{ old('count') }}" required>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success">افزودن محصول</button>
            </div>
        </form>

        {{-- لیست محصولات --}}
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>نام</th>
                    <th>تعداد</th>
                    <th>قیمت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    @php
                        $final_price = $product->price - ($product->price * $product->discount_percent) / 100;
                    @endphp
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->count }}</td>
                        <td>{{ number_format($final_price) }} تومان</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="btn btn-sm btn-primary">ویرایش</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('حذف شود؟')">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal افزودن دسته‌بندی --}}
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.categories.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">افزودن دسته‌بندی</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>نام دسته</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">افزودن</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal افزودن رنگ --}}
    <div class="modal fade" id="addColorModal" tabindex="-1" aria-labelledby="addColorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.colors.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">افزودن رنگ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>نام رنگ</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">افزودن</button>
                </div>
            </form>
        </div>
    </div>

    {{-- اسکریپت محاسبه تخفیف --}}
    <script>
        const price = document.getElementById('price');
        const discount = document.getElementById('discount');
        const discountPrice = document.getElementById('discount_price');

        function updateDiscountPrice() {
            const p = parseInt(price.value) || 0;
            const d = parseInt(discount.value) || 0;
            const final = p - (p * d / 100);
            discountPrice.value = final;
        }

        price.addEventListener('input', updateDiscountPrice);
        discount.addEventListener('input', updateDiscountPrice);
    </script>
@endsection
