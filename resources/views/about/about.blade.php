@extends('layouts.app')

@section('title', 'درباره ما')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="mb-4 text-center">درباره فروشگاه ما</h2>
                <p class="lead text-justify">
                    ما در فروشگاه ساعت با هدف ارائه بهترین برندهای ساعت، فعالیت خود را آغاز کرده‌ایم. کیفیت بالا، قیمت مناسب و پشتیبانی کامل از مشتریان، اولویت‌های اصلی ما هستند.
                </p>
                <p class="text-muted text-justify">
                    این فروشگاه با بهره‌گیری از تیمی متخصص، تلاش دارد تجربه‌ای متفاوت از خرید آنلاین را برای شما فراهم کند. ما متعهد به ارسال سریع، ضمانت اصل‌بودن کالا و خدمات پس از فروش هستیم.
                </p>
                <hr>
                <h5 class="text-primary">اطلاعات تماس</h5>
                <ul class="list-unstyled">
                    <li><i class="bi bi-telephone-fill me-2"></i> 021-12345678</li>
                    <li><i class="bi bi-envelope-fill me-2"></i> info@example.com</li>
                    <li><i class="bi bi-geo-alt-fill me-2"></i> تهران، خیابان ولیعصر، پلاک 100</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
