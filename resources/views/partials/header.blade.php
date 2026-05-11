<header>
  <nav class="navbar">
    <div class="navbar-logo">
      <a href="{{ route('home') }}">
        <div class="logo-icon">T<span style="font-size:12px">X</span></div>
        <div class="logo-text">Tech<span>Xpress</span></div>
      </a>
    </div>

    <div class="navbar-links">
      <ul class="main-menu">
        <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
          <a href="{{ route('home') }}">Trang chủ</a>
        </li>
        <li class="dropdown {{ request()->routeIs('product*') ? 'active' : '' }}">
          <a href="#">Sản phẩm</a>
          <ul class="dropdown-menu">
            <li>
              <a href="{{ route('product.category', 'laptop') }}">
                <span class="menu-icon"><i class="fa-solid fa-laptop"></i></span>
                Máy laptop
              </a>
            </li>
            <li>
              <a href="{{ route('product.category', 'gaming') }}">
                <span class="menu-icon"><i class="fa-solid fa-gamepad"></i></span>
                PC - Gaming
              </a>
            </li>
            <li>
              <a href="{{ route('product.category', 'mobile') }}">
                <span class="menu-icon"><i class="fa-solid fa-mobile-alt"></i></span>
                Thiết bị di động
              </a>
            </li>
            <li>
              <a href="{{ route('product.category', 'accessory') }}">
                <span class="menu-icon"><i class="fa-solid fa-keyboard"></i></span>
                Phụ kiện &amp; Ngoại vi
              </a>
            </li>
          </ul>
        </li>
        <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
          <a href="{{ route('about') }}">Giới thiệu</a>
        </li>
        <li class="{{ request()->routeIs('service') ? 'active' : '' }}">
          <a href="{{ route('service') }}">Dịch vụ</a>
        </li>
      </ul>
    </div>

    <div class="navbar-user">
      <div class="search-wrap">
        <input type="text" id="search-input" placeholder="Tìm kiếm sản phẩm..." />
        <button id="search-btn"><i class="fa-solid fa-search"></i></button>
      </div>
      <a href="{{ route('cart.index') }}" class="icon-btn" title="Giỏ hàng">
        <i class="fa-solid fa-shopping-cart"></i>
        <span class="badge">{{ session('cart_count', 0) }}</span>
      </a>
      @auth
        <a href="{{ route('profile') }}" class="login-btn">
          <i class="fa-solid fa-user"></i>
          {{ auth()->user()->name }}
        </a>
      @else
        <a href="{{ route('login') }}" class="login-btn">
          <i class="fa-solid fa-user"></i>
          Đăng nhập
        </a>
      @endauth
    </div>
  </nav>
</header>