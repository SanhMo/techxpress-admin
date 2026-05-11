<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin') — TechXpress</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600;700&family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
    @stack('styles')
</head>

<body>

    {{-- ══ TOP NAVBAR ══ --}}
    <nav class="admin-nav">
        <div class="admin-nav-left">
            <a href="{{ route('home') }}" class="admin-logo">
                <div class="logo-icon">T<span>X</span></div>
                <div class="logo-text">Tech<span>Xpress</span> <em>Admin</em></div>
            </a>
            <div class="admin-nav-links">
                <a href="{{ route('admin.products.index') }}"
                    class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box"></i> Sản phẩm
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt"></i> Đơn hàng
                </a>
                <a href="#" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i> Khách hàng
                </a>
            </div>
        </div>
        <div class="admin-nav-right">
            <a href="{{ route('home') }}" class="nav-btn" target="_blank" title="Xem trang web">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Xem web
            </a>
            <div class="admin-avatar">
                @auth
                    {{-- Đã đăng nhập --}}
                    <div class="user-dropdown">
                        <span style="color:#fff; font-size:0.88rem">
                            <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}" style="display:inline">
                            @csrf
                            <button type="submit" class="login-btn" style="background:none;border:none;cursor:pointer">
                                <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Chưa đăng nhập --}}
                    <a href="{{ route('login') }}" class="login-btn">
                        <i class="fa-solid fa-user"></i> Đăng nhập
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ══ MAIN CONTENT ══ --}}
    <main class="admin-main">

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ session('error') }}
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @stack('scripts')
</body>

</html>
