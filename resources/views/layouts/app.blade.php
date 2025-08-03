<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'فروشگاه')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e0f7fa);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.3rem;
        }

        .card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
        }

        .nav-link {
            font-size: 0.95rem;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>


<body class="d-flex flex-column min-vh-100" >



    <!-- هدر -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <!-- لوگو سمت راست -->
            <a class="navbar-brand" href="{{ url('/') }}">🕒 فروشگاه</a>
            @auth
                @if (auth()->user()->is_admin)
                    <a class="navbar-brand" href="{{ route('admin.products.index') }}">ورود به پنل مدیریت</a>
                @endif
            @endauth
            <!-- دکمه تاگل در موبایل -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- آیتم‌های وسط و چپ -->
            <div class="collapse navbar-collapse justify-content-between" id="mainNavbar">

                <!-- وسط: دسته‌بندی و درباره ما -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <!-- Dropdown دسته‌بندی -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            دسته‌بندی‌ها
                        </a>
                        <ul class="dropdown-menu text-end">
                            @php
                                $categories = App\Models\Category::all();
                            @endphp
                            @foreach ($categories as $category)
                                <li><a class="dropdown-item"
                                        href="{{ route('category.show', $category) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>

                    <!-- لینک درباره ما -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('about')}}">درباره ما</a>
                    </li>
                </ul>

                <!-- سمت چپ: ورود/ثبت‌نام یا نام کاربر -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">ورود</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">ثبت‌نام</a>
                        </li>
                    @else
                        <link rel="stylesheet"
                            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

                        <div class="relative p-2">
                            @php
                                $userId = Auth::id();

                                $cartCount = DB::table('cart_items')
                                    ->where('user_id', $userId)
                                    ->whereNull('invoice_id')
                                    ->sum('count');

                            @endphp
                            <a style="all: unset; cursor: pointer;" href="{{ route('profile') }}">
                                <i class="fas fa-shopping-cart text-xl text-gray-700"></i>
                                @if ($cartCount > 0)
                                    <span
                                        class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded bg-danger px-1">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </div>


                        <li class="nav-item">
                            <span class="nav-link text-secondary">{{ Auth::user()->name }}</span>
                        </li>
                        <li class="nav-item">

                            <a href="{{ route('logout') }}" class="btn btn-danger"> خروج </a>

                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @if (session('success'))
        <div class="alert alert-success mt-3 text-center">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mt-3 text-center">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-3 text-center">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    <!-- محتوای صفحات -->
    <main class="container-fluid py-4 flex-grow-1">

        @yield('content')
    </main>

    <!-- اسکریپت بوت‌استرپ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <footer class="bg-dark text-white  mt-5 pt-4 pb-3">
        <div class="container">
            <div class="row">

                <!-- درباره فروشگاه -->
                <div class="col-md-6 mb-3 mb-md-0">
                    <h5>درباره فروشگاه</h5>
                    <p class="small">
                        ما در فروشگاه ساعت، بهترین برندهای ساعت مچی را با کیفیت عالی و قیمت مناسب به شما ارائه می‌دهیم.
                        هدف ما رضایت شماست.
                    </p>
                </div>

                <!-- راه‌های ارتباطی -->
                <div class="col-md-6">
                    <h5>ارتباط با ما</h5>
                    <ul class="list-unstyled small">
                        <li><i class="bi bi-telephone-fill me-1"></i> تلفن: 021-12345678</li>
                        <li><i class="bi bi-envelope-fill me-1"></i> ایمیل: info@example.com</li>
                        <li><i class="bi bi-geo-alt-fill me-1"></i> آدرس: تهران، خیابان ولیعصر، پلاک 100</li>
                    </ul>
                    <div class="mt-2">
                        <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-telegram fs-5"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-whatsapp fs-5"></i></a>
                    </div>
                </div>

            </div>
            <hr class="border-light mt-4">
            <p class="text-center small mb-0">© {{ now()->year }} تمامی حقوق این وبسایت محفوظ است.</p>
        </div>
    </footer>

</body>

</html>
