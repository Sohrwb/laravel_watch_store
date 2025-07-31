@extends('layouts.app')

@section('content')
    <div class="container bg-secondary p-2 border rounded">
        <h2>مدیریت محصولات</h2>

        {{-- فرم افزودن محصول --}}
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="row g-3 mb-5">
            @csrf
            <div class="col-md-4">
                <label>نام محصول</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
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
                <textarea name="description" class="form-control" value="{{old('description')}}" required></textarea>
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
                <input type="number" name="price" class="form-control" value="{{old('price')}}" required id="price">
            </div>

            <div class="col-md-3">
                <label>درصد تخفیف</label>
                <input type="number" name="discount_percent" class="form-control" value="{{old('discount_percent')}}" required id="discount">
            </div>

            <div class="col-md-3">
                <label>قیمت با تخفیف</label>
                <input type="number" class="form-control" id="discount_price" readonly>
            </div>

            <div class="col-md-3">
                <label>تعداد</label>
                <input type="number" name="count" class="form-control" value="{{old('count')}}" required>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success">افزودن محصول</button>
            </div>
        </form>

        {{-- لیست محصولات --}}
        <table class="table table-bordered">
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
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->count }}</td>
                        <td>{{ number_format($product->discount_price) }} تومان</td>
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
