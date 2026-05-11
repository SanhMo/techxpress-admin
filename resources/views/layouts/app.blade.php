<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TechXpress')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/banner.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;700&family=Be+Vietnam+Pro:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    @stack('styles')
</head>

<body>
    <header>
        <nav class="navbar">
            <!-- =============== Logo =============== -->
            <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleMobileMenu()">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="navbar-logo">
                <a href="#">
                    <div class="logo-icon">T<span style="font-size: 12px">X</span></div>
                    <div class="logo-text">Tech<span>Xpress</span></div>
                </a>
            </div>

            <!-- Main Navigation -->
            <div class="navbar-links">
                <ul class="main-menu">
                    <li class="active"><a href="{{ route('home') }}">Trang chủ</a></li>

                    <li class="dropdown">
                        <a href="#">Sản phẩm</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">
                                    <span class="menu-icon"><i class="fa-solid fa-laptop"></i></span>
                                    Máy laptop
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-icon"><i class="fa-solid fa-gamepad"></i></span>
                                    PC - Gaming
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-icon"><i class="fa-solid fa-mobile-alt"></i></span>
                                    Thiết bị di động
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-icon"><i class="fa-solid fa-keyboard"></i></span>
                                    Phụ kiện &amp; Ngoại vi
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#">Giới thiệu</a></li>
                    <li><a href="#">Dịch vụ</a></li>
                </ul>
            </div>

            <!-- Search + User -->
            <div class="navbar-user">
                <div class="search-wrap">
                    <input type="text" id="search-input" placeholder="Tìm kiếm sản phẩm..." />
                    <button id="search-btn"><i class="fa-solid fa-search"></i></button>
                </div>

                <a href="{{ route('cart.index') }}" class="cart-icon-wrap" style="position:relative">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @auth
                        @php $cartCount = Auth::user()->cartCount(); @endphp
                        @if ($cartCount > 0)
                            <span class="cart-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                        @endif
                    @endauth
                </a>

                @auth
                    <div class="user-menu" style="position:relative">

                        {{-- Nút trigger --}}
                        <button class="user-trigger" id="userTrigger"
                            style="display:flex;align-items:center;gap:8px;background:none;border:none;cursor:pointer;color:#fff;font-family:'Be Vietnam Pro',sans-serif;font-size:0.88rem;padding:6px 10px;border-radius:8px;transition:background 0.2s"
                            onclick="toggleUserMenu()">
                            <i class="fa-solid fa-user"></i>
                            {{ Auth::user()->name }}
                            <i class="fa-solid fa-chevron-down" style="font-size:0.7rem;transition:transform 0.2s"
                                id="chevronIcon"></i>
                        </button>

                        {{-- Dropdown --}}
                        <div class="user-dropdown" id="userDropdown"
                            style="display:none;position:absolute;right:0;top:calc(100% + 8px);width:200px;background:#fff;border-radius:12px;box-shadow:0 8px 32px rgba(0,0,0,0.15);border:1px solid #f0eeeb;overflow:hidden;z-index:999">

                            {{-- Header --}}
                            <div style="padding:14px 16px;border-bottom:1px solid #f5f4f2">
                                <div style="font-weight:600;color:#1a1a1a;font-size:0.9rem">{{ Auth::user()->name }}</div>
                                <div style="font-size:0.78rem;color:#999;margin-top:2px">{{ Auth::user()->email }}</div>
                            </div>

                            {{-- Menu items --}}
                            <div style="padding:6px 0">
                                <a href="{{ route('cart.index') }}"
                                    style="display:flex;align-items:center;gap:10px;padding:10px 16px;font-size:0.88rem;color:#444;text-decoration:none;transition:background 0.15s"
                                    onmouseover="this.style.background='#f5f4f2'" onmouseout="this.style.background='none'">
                                    <i class="fa-solid fa-shopping-cart" style="width:16px;color:#ff4500"></i>
                                    Giỏ hàng
                                    <span
                                        style="margin-left:auto;background:#ff4500;color:#fff;font-size:0.72rem;padding:1px 7px;border-radius:20px">
                                        {{ Auth::user()->cartCount() }}</span>
                                </a>

                                <a href="{{ route('profile.index') }}?tab=orders"
                                    style="display:flex;align-items:center;gap:10px;padding:10px 16px;font-size:0.88rem;color:#444;text-decoration:none;transition:background 0.15s"
                                    onmouseover="this.style.background='#f5f4f2'" onmouseout="this.style.background='none'">
                                    <i class="fa-solid fa-box" style="width:16px;color:#888"></i>
                                    Đơn hàng của tôi
                                </a>

                                <a href="{{ route('profile.index') }}"
                                    style="display:flex;align-items:center;gap:10px;padding:10px 16px;font-size:0.88rem;color:#444;text-decoration:none;transition:background 0.15s"
                                    onmouseover="this.style.background='#f5f4f2'" onmouseout="this.style.background='none'">
                                    <i class="fa-solid fa-user-pen" style="width:16px;color:#888"></i>
                                    Tài khoản
                                </a>

                                @if (Auth::user()->isAdmin())
                                    <a href="{{ route('admin.products.index') }}"
                                        style="display:flex;align-items:center;gap:10px;padding:10px 16px;font-size:0.88rem;color:#444;text-decoration:none;transition:background 0.15s"
                                        onmouseover="this.style.background='#f5f4f2'"
                                        onmouseout="this.style.background='none'">
                                        <i class="fa-solid fa-shield-halved" style="width:16px;color:#888"></i>
                                        Trang Admin
                                    </a>
                                @endif
                            </div>

                            {{-- Đăng xuất --}}
                            <div style="padding:6px 0;border-top:1px solid #f5f4f2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        style="display:flex;align-items:center;gap:10px;width:100%;padding:10px 16px;font-size:0.88rem;color:#dc2626;background:none;border:none;cursor:pointer;font-family:'Be Vietnam Pro',sans-serif;transition:background 0.15s"
                                        onmouseover="this.style.background='#fff5f5'"
                                        onmouseout="this.style.background='none'">
                                        <i class="fa-solid fa-right-from-bracket" style="width:16px"></i>
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Click outside để đóng --}}
                    <script>
                        function toggleUserMenu() {
                            const dropdown = document.getElementById('userDropdown');
                            const chevron = document.getElementById('chevronIcon');
                            const isOpen = dropdown.style.display === 'block';
                            dropdown.style.display = isOpen ? 'none' : 'block';
                            chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
                        }

                        document.addEventListener('click', function(e) {
                            const trigger = document.getElementById('userTrigger');
                            const dropdown = document.getElementById('userDropdown');
                            if (!trigger.contains(e.target) && !dropdown.contains(e.target)) {
                                dropdown.style.display = 'none';
                                document.getElementById('chevronIcon').style.transform = 'rotate(0deg)';
                            }
                        });
                    </script>
                @else
                    <a href="{{ route('login') }}" class="login-btn">
                        <i class="fa-solid fa-user"></i> Đăng nhập
                    </a>
                @endauth
            </div>
        </nav>
    </header>
    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-header">
            <button class="close-menu" onclick="toggleMobileMenu()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <ul class="mobile-menu-list">
            <li><a href="{{ route('home') }}">Trang chủ</a></li>

            <li class="mobile-product">
                <a href="#" onclick="toggleProductMenu(event)">
                    Sản phẩm <i class="fa-solid fa-chevron-down"></i>
                </a>

                <ul class="mobile-product-menu" id="productMenu">
                    <li><a href="#">Máy laptop</a></li>
                    <li><a href="#">PC Gaming</a></li>
                    <li><a href="#">Thiết bị di động</a></li>
                    <li><a href="#">Phụ kiện</a></li>
                </ul>
            </li>

            <li><a href="#">Giới thiệu</a></li>
            <li><a href="#">Dịch vụ</a></li>
        </ul>
    </div>
    @yield('content')
    <footer>
        <div class="footer-body">
            <div class="footer-body-inner">
                <!-- Brand -->
                <div class="footer-brand">
                    <a href="#" class="brand-logo">
                        <div class="logo-icon">
                            T<span style="font-size: 12px">X</span>
                        </div>
                        <div class="logo-text">Tech<span>Xpress</span></div>
                    </a>
                    <p class="brand-desc">
                        Hệ thống bán lẻ công nghệ hàng đầu Việt Nam — cam kết hàng chính
                        hãng, giá tốt nhất, giao hàng siêu tốc toàn quốc.
                    </p>

                    <ul class="footer-contact-list">
                        <li>
                            <i class="fa-solid fa-location-dot"></i> 567 Lê Duẩn, Phường EarKao, Trường đại học Tây
                            Nguyên
                        </li>
                        <li>
                            <i class="fa-solid fa-phone"></i> 0769576207 (Online ·
                            8:00–22:00)
                        </li>
                        <li>
                            <i class="fa-solid fa-envelope"></i> support@gmail.com
                        </li>
                    </ul>

                    <div class="footer-socials">
                        <a href="#" class="social-btn" title="Facebook"><i
                                class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="social-btn" title="Instagram"><i
                                class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-btn" title="YouTube"><i
                                class="fa-brands fa-youtube"></i></a>
                        <a href="#" class="social-btn" title="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#" class="social-btn" title="Zalo"><i
                                class="fa-solid fa-comment-dots"></i></a>
                    </div>
                </div>

                <!-- Sản phẩm -->
                <div class="footer-col">
                    <h4>Sản phẩm</h4>
                    <ul>
                        <li><a href="#">Laptop Gaming</a></li>
                        <li><a href="#">Laptop Văn phòng</a></li>
                        <li><a href="#">PC - Máy tính bộ</a></li>
                        <li><a href="#">Điện thoại</a></li>
                        <li><a href="#">Máy tính bảng</a></li>
                        <li><a href="#">Màn hình</a></li>
                        <li><a href="#">Phụ kiện & Ngoại vi</a></li>
                    </ul>
                </div>

                <!-- Hỗ trợ -->
                <div class="footer-col">
                    <h4>Hỗ trợ</h4>
                    <ul>
                        <li><a href="#">Tra cứu đơn hàng</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Bảo hành sản phẩm</a></li>
                        <li><a href="#">Hướng dẫn mua hàng</a></li>
                        <li><a href="#">Câu hỏi thường gặp</a></li>
                        <li><a href="#">Liên hệ hỗ trợ</a></li>
                    </ul>
                </div>

                <!-- Về chúng tôi -->
                <div class="footer-col">
                    <h4>Về TechXpress</h4>
                    <ul>
                        <li><a href="#">Giới thiệu công ty</a></li>
                        <li><a href="#">Hệ thống cửa hàng</a></li>
                        <li><a href="#">Tuyển dụng</a></li>
                        <li><a href="#">Tin tức công nghệ</a></li>
                        <li><a href="#">Chương trình đối tác</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Trust & Payment -->
        <div class="footer-trust">
            <div class="footer-trust-inner">
                <div class="trust-badges">
                    <span class="trust-label">Thanh toán:</span>
                    <span class="pay-badge"><i class="fa-brands fa-cc-visa"></i> Visa</span>
                    <span class="pay-badge"><i class="fa-brands fa-cc-mastercard"></i> Mastercard</span>
                    <span class="pay-badge"><i class="fa-solid fa-mobile-screen-button"></i> MoMo</span>
                    <span class="pay-badge"><i class="fa-solid fa-wallet"></i> ZaloPay</span>
                    <span class="pay-badge"><i class="fa-solid fa-money-bill-wave"></i> COD</span>
                    <span class="pay-badge"><i class="fa-solid fa-landmark"></i> Chuyển khoản</span>
                </div>
                <div class="trust-badges">
                    <span class="trust-label">Vận chuyển:</span>
                    <span class="pay-badge"><i class="fa-solid fa-truck-fast"></i> Giao hỏa tốc</span>
                    <span class="pay-badge"><i class="fa-solid fa-box"></i> Giao tiêu chuẩn</span>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom">
            <div class="footer-bottom-inner">
                <p class="footer-copy">
                    © 2025 <span>TechXpress</span>. Tất cả quyền được bảo lưu.
                </p>
                <div class="footer-bottom-links">
                    <a href="#">Điều khoản sử dụng</a>
                    <a href="#">Chính sách bảo mật</a>
                    <a href="#">Cookie</a>
                    <a href="#">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Back to top -->
    <button class="back-to-top" id="backToTop" title="Lên đầu trang">
        <i class="fa-solid fa-chevron-up"></i>
    </button>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/detail.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @stack('scripts')

    {{-- ── MINI CART OVERLAY + DRAWER ── --}}
    <div id="miniCartOverlay" onclick="closeMiniCart()"
        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:1000;backdrop-filter:blur(2px)">
    </div>

    <div id="miniCart"
        style="position:fixed;top:0;right:-400px;width:380px;height:100vh;background:#fff;z-index:1001;
            display:flex;flex-direction:column;
            box-shadow:-8px 0 40px rgba(0,0,0,0.15);
            transition:right 0.35s cubic-bezier(0.4,0,0.2,1)">

        {{-- Header --}}
        <div
            style="display:flex;align-items:center;justify-content:space-between;
                padding:20px 24px;border-bottom:1px solid #f5f4f2;flex-shrink:0">
            <div
                style="font-family:'Rajdhani',sans-serif;font-size:1.15rem;font-weight:700;color:#1a1a1a;
                    display:flex;align-items:center;gap:10px">
                <i class="fa-solid fa-cart-shopping" style="color:#ff4500"></i>
                Giỏ hàng
                <span id="miniCartCount"
                    style="background:#ff4500;color:#fff;font-size:0.78rem;
                         padding:1px 8px;border-radius:20px;font-family:'Be Vietnam Pro',sans-serif">0</span>
            </div>
            <button onclick="closeMiniCart()"
                style="width:32px;height:32px;border-radius:8px;border:1px solid #e8e8e8;
                       background:none;cursor:pointer;color:#888;font-size:0.9rem;
                       display:flex;align-items:center;justify-content:center;transition:all 0.2s"
                onmouseover="this.style.background='#f5f4f2'" onmouseout="this.style.background='none'">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div id="miniCartItems" style="flex:1;overflow-y:auto;padding:8px 0">
        </div>

        {{-- Footer --}}
        <div id="miniCartFooter" style="padding:20px 24px;border-top:1px solid #f5f4f2;flex-shrink:0;display:none">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
                <span style="font-size:0.9rem;color:#888">Tổng cộng:</span>
                <span id="miniCartTotal"
                    style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;color:#ff4500"></span>
            </div>
            <a href="{{ route('cart.index') }}"
                style="display:flex;align-items:center;justify-content:center;gap:8px;
                  width:100%;background:#ff4500;color:#fff;border-radius:12px;
                  padding:13px;font-size:0.95rem;font-weight:700;
                  font-family:'Be Vietnam Pro',sans-serif;text-decoration:none;
                  transition:all 0.2s;margin-bottom:10px"
                onmouseover="this.style.background='#e03d00';this.style.transform='translateY(-1px)'"
                onmouseout="this.style.background='#ff4500';this.style.transform='none'">
                <i class="fa-solid fa-lock"></i> Đặt hàng ngay
            </a>
            <a href="{{ route('products.index') }}"
                style="display:flex;align-items:center;justify-content:center;gap:6px;
                  width:100%;padding:10px;border:1px solid #e8e8e8;border-radius:10px;
                  font-size:0.88rem;color:#666;text-decoration:none;
                  font-family:'Be Vietnam Pro',sans-serif;transition:all 0.2s"
                onmouseover="this.style.borderColor='#ff4500';this.style.color='#ff4500'"
                onmouseout="this.style.borderColor='#e8e8e8';this.style.color='#666'">
                <i class="fa-solid fa-arrow-left"></i> Tiếp tục mua sắm
            </a>
        </div>
    </div>

    <style>
        /* Item trong mini cart */
        .mc-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 24px;
            transition: background 0.15s;
        }

        .mc-item:hover {
            background: #fafaf9;
        }

        .mc-thumb {
            width: 56px;
            height: 56px;
            border-radius: 8px;
            object-fit: cover;
            background: #f5f4f2;
            flex-shrink: 0;
        }

        .mc-thumb-placeholder {
            width: 56px;
            height: 56px;
            border-radius: 8px;
            background: #f5f4f2;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ddd;
            flex-shrink: 0;
        }

        .mc-info {
            flex: 1;
            min-width: 0;
        }

        .mc-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1a1a1a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 4px;
        }

        .mc-qty-price {
            font-size: 0.78rem;
            color: #aaa;
        }

        .mc-subtotal {
            font-size: 0.9rem;
            font-weight: 700;
            color: #ff4500;
            flex-shrink: 0;
        }

        .mc-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 40px 20px;
            text-align: center;
        }

        .mc-empty i {
            font-size: 48px;
            color: #e0dedd;
            margin-bottom: 12px;
        }

        .mc-empty p {
            font-size: 0.88rem;
            color: #aaa;
        }

        .mc-more {
            text-align: center;
            padding: 12px 24px;
            font-size: 0.82rem;
            color: #aaa;
        }

        .mc-more a {
            color: #ff4500;
            text-decoration: none;
        }

        /* Nút giỏ hàng có thể click để mở mini cart */
        .cart-icon-wrap {
            cursor: pointer;
        }
    </style>

    <script>
        @auth

        function openMiniCart() {
            fetch('{{ route('cart.mini') }}')
                .then(r => r.json())
                .then(data => {
                    renderMiniCart(data);
                    document.getElementById('miniCart').style.right = '0';
                    document.getElementById('miniCartOverlay').style.display = 'block';
                    document.body.style.overflow = 'hidden';
                });
        }

        function closeMiniCart() {
            document.getElementById('miniCart').style.right = '-400px';
            document.getElementById('miniCartOverlay').style.display = 'none';
            document.body.style.overflow = '';
        }

        function renderMiniCart(data) {
            const container = document.getElementById('miniCartItems');
            const footer = document.getElementById('miniCartFooter');
            const countEl = document.getElementById('miniCartCount');
            const totalEl = document.getElementById('miniCartTotal');

            countEl.textContent = data.count;

            if (!data.items || data.items.length === 0) {
                container.innerHTML = `
            <div class="mc-empty">
                <i class="fa-solid fa-cart-xmark"></i>
                <p>Giỏ hàng trống</p>
            </div>`;
                footer.style.display = 'none';
                return;
            }

            let html = '';
            data.items.forEach(item => {
                const price = parseInt(item.product.price).toLocaleString('vi-VN');
                const subtotal = (parseInt(item.product.price) * item.quantity).toLocaleString('vi-VN');
                const img = item.product.image ?
                    `<img class="mc-thumb" src="/storage/${item.product.image}" alt="${item.product.name}" />` :
                    `<div class="mc-thumb-placeholder"><i class="fa-solid fa-laptop"></i></div>`;

                html += `
        <div class="mc-item">
            ${img}
            <div class="mc-info">
                <div class="mc-name">${item.product.name}</div>
                <div class="mc-qty-price">${item.quantity} × ${price}₫</div>
            </div>
            <div class="mc-subtotal">${subtotal}₫</div>
        </div>`;
            });

            // Hiển thị "xem thêm" nếu > 5 items
            const totalItems = data.count;
            if (totalItems > data.items.length) {
                html += `<div class="mc-more">
            <a href="{{ route('cart.index') }}">Xem tất cả ${totalItems} sản phẩm →</a>
        </div>`;
            }

            container.innerHTML = html;

            const total = parseInt(data.total).toLocaleString('vi-VN');
            totalEl.textContent = total + '₫';
            footer.style.display = 'block';
        }

        // Click vào icon giỏ hàng → mở mini cart thay vì navigate
        document.querySelector('.cart-icon-wrap')?.addEventListener('click', function(e) {
            e.preventDefault();
            openMiniCart();
        });

        // ESC để đóng
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeMiniCart();
        });

        // Sau khi thêm SP vào giỏ (từ các trang khác), refresh mini cart nếu đang mở
        window.refreshMiniCart = function(count) {
            document.getElementById('miniCartCount')?.setAttribute('data-count', count);
        }
        // ========== reponsive ===========
        function toggleMobileMenu() {
            const menu = document.getElementById("mobileMenu");
            const overlay = document.getElementById("menuOverlay");
            menu.classList.toggle("active");
            overlay.classList.toggle("active");

        }

        function toggleProductMenu(e) {
            e.preventDefault();
            document
                .getElementById("productMenu")
                .classList.toggle("active");
        }
        @endauth
    </script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/684bf928e510fd190c855d94/1itkcaibg';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
    @auth
        <script>
            var Tawk_API = Tawk_API || {};
            Tawk_API.onLoad = function() {
                Tawk_API.setAttributes({
                    name: '{{ Auth::user()->name }}',
                    email: '{{ Auth::user()->email }}',
                }, function(error) {});
            };
        </script>
    @endauth
    <!--End of Tawk.to Script-->

    @auth
        <script>
            var Tawk_API = Tawk_API || {};

            // Gán thông tin user đang đăng nhập
            Tawk_API.onLoad = function() {
                Tawk_API.setAttributes({
                    name: '{{ Auth::user()->name }}',
                    email: '{{ Auth::user()->email }}',
                    userId: '{{ Auth::user()->id }}',
                }, function(error) {});
            };
        </script>
    @else
        <script>
            var Tawk_API = Tawk_API || {};

            // Khi chưa đăng nhập → reset session cũ
            Tawk_API.onLoad = function() {
                Tawk_API.endChat(); // kết thúc chat cũ
            };
        </script>
    @endauth

</body>

</html>
