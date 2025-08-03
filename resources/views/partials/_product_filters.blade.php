<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <span>فیلتر محصولات</span>
        <button class="btn btn-sm btn-light d-md-none" id="toggleFilter">×</button>
    </div>
    <div class="card-body">
        <form action="{{ route('products.index') }}" method="GET">
            {{-- جستجو --}}
            <div class="mb-3">
                <label class="form-label">جستجو</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                    placeholder="نام محصول">
            </div>

            {{-- دسته‌بندی --}}
            <div class="mb-3">
                <label class="form-label">دسته‌بندی</label>
                @foreach ($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}"
                            {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>

            {{-- رنگ --}}
            <div class="mb-3">
                <label class="form-label">رنگ</label>
                @foreach ($colors as $color)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="colors[]" value="{{ $color->id }}"
                            {{ in_array($color->id, request('colors', [])) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $color->name }}</label>
                    </div>
                @endforeach
            </div>

            {{-- سایز --}}
            <div class="mb-3">
                <label class="form-label">سایز</label>
                @foreach ($sizes as $size)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sizes[]" value="{{ $size->id }}"
                            {{ in_array($size->id, request('sizes', [])) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $size->name }}</label>
                    </div>
                @endforeach
            </div>

            {{-- قیمت --}}
            <div class="mb-3">
                <label class="form-label">محدوده قیمت (تومان)</label>
                <div class="d-flex gap-2">
                    <input type="number" name="min_price" class="form-control" placeholder="حداقل"
                        value="{{ request('min_price') }}">
                    <input type="number" name="max_price" class="form-control" placeholder="حداکثر"
                        value="{{ request('max_price') }}">
                </div>
            </div>

            {{-- دکمه فیلتر --}}
            <button type="submit" class="btn btn-outline-primary w-100">اعمال فیلتر</button>
        </form>
    </div>
</div>
