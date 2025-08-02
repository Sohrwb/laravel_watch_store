@extends('layouts.app')

@section('content')
<div class="container">
    <h4>ویرایش آیتم سبد خرید</h4>

    <div class="card p-3">
        <div class="d-flex align-items-center mb-3">
            <img src="{{ asset('images/products/' . $item->product->image) }}"
                 alt="{{ $item->product->name }}"
                 style="width: 100px; height: 100px; object-fit: cover;"
                 class="me-3 rounded border">

            <div>
                <h5>{{ $item->product->name }}</h5>
                <div><strong>دسته‌بندی:</strong> {{ $item->product->category->name ?? '---' }}</div>
                <div><strong>رنگ:</strong> {{ $item->product->color->name  ?? '---' }}</div>
                <div><strong>سایز:</strong> {{ $item->product->size->name  ?? '---' }}</div>
                <div class="text-muted mt-1" style="max-width: 400px;">
                    {{ $item->product->description }}
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('cart-item.update', $item->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>تعداد</label>
                <input type="number" name="count" class="form-control" value="{{ $item->count }}" min="1">
            </div>

            <button type="submit" class="btn btn-primary">ذخیره</button>
            <a href="{{ route('profile') }}" class="btn btn-secondary">بازگشت</a>
        </form>
    </div>
</div>
@endsection
