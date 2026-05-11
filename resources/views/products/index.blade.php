@extends('layouts.app')

@section('title', 'Sản phẩm — TechXpress')

@push('styles')
    <style>
        body {
            background: #fff;
        }

        .page-hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 48px 0 36px;
            margin-bottom: 40px;
        }

        .page-hero h1 {
            font-family: 'Rajdhani', sans-serif;
            font-size: 2.4rem;
            font-weight: 700;
            color: #fff;
            margin: 0 0 8px;
        }

        .page-hero .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .page-hero .breadcrumb a {
            color: #ff4500;
            text-decoration: none;
        }

        .products-page-wrap {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px 60px;
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 32px;
            align-items: start;
        }

        /* Sidebar */
        .sidebar {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #f0eeeb;
            overflow: hidden;
            position: sticky;
            top: 20px;
        }

        .sidebar-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #aaa;
            padding: 16px 20px 10px;
            border-bottom: 1px solid #f5f4f2;
        }

        .sidebar-menu {
            list-style: none;
            margin: 0;
            padding: 6px 0 10px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 20px;
            font-size: 0.9rem;
            color: #555;
            text-decoration: none;
            transition: all 0.15s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            color: #ff4500;
            background: rgba(255, 69, 0, 0.04);
            border-left-color: #ff4500;
        }

        .sidebar-menu li a i {
            width: 16px;
            text-align: center;
            font-size: 0.8rem;
            color: #ccc;
        }

        .sidebar-menu li a.active i,
        .sidebar-menu li a:hover i {
            color: #ff4500;
        }

        .sidebar-count {
            margin-left: auto;
            font-size: 0.75rem;
            background: #f5f4f2;
            color: #aaa;
            padding: 1px 7px;
            border-radius: 20px;
        }

        .sidebar-menu li a.active .sidebar-count {
            background: rgba(255, 69, 0, 0.1);
            color: #ff4500;
        }

        /* Toolbar */
        .product-toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 12px 16px;
            background: #fff;
            border-radius: 12px;
            border: 1px solid #f0eeeb;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            flex-wrap: wrap;
        }

        .toolbar-right {
            font-size: 0.84rem;
            color: #aaa;
            white-space: nowrap;
        }

        .toolbar-row2 {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: #f5f4f2;
            border-radius: 8px;
            padding: 7px 12px;
            gap: 8px;
            min-width: 200px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.88rem;
            color: #333;
            width: 100%;
            font-family: 'Be Vietnam Pro', sans-serif;
        }

        .search-box i {
            color: #ccc;
            font-size: 0.8rem;
        }

        .filter-select {
            background: #f5f4f2;
            border: none;
            border-radius: 8px;
            padding: 7px 30px 7px 12px;
            font-size: 0.88rem;
            color: #555;
            cursor: pointer;
            outline: none;
            font-family: 'Be Vietnam Pro', sans-serif;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%23999' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
        }

        .btn-search {
            background: #ff4500;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 7px 16px;
            font-size: 0.88rem;
            font-family: 'Be Vietnam Pro', sans-serif;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.2s;
        }

        .btn-search:hover {
            background: #e03d00;
        }

        .btn-reset {
            background: transparent;
            color: #aaa;
            border: 1px solid #e8e8e8;
            border-radius: 8px;
            padding: 7px 12px;
            font-size: 0.88rem;
            font-family: 'Be Vietnam Pro', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-reset:hover {
            border-color: #ff4500;
            color: #ff4500;
        }

        /* Pagination */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            margin-top: 40px;
            gap: 5px;
        }

        .pagination-wrap .page-item a,
        .pagination-wrap .page-item span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-family: 'Be Vietnam Pro', sans-serif;
            text-decoration: none;
            color: #555;
            background: #fff;
            border: 1px solid #e8e8e8;
            transition: all 0.2s;
        }

        .pagination-wrap .page-item.active span {
            background: #ff4500;
            color: #fff;
            border-color: #ff4500;
        }

        .pagination-wrap .page-item a:hover {
            border-color: #ff4500;
            color: #ff4500;
        }

        .pagination-wrap .page-item.disabled span {
            color: #ddd;
        }

        /* Empty */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #ccc;
        }

        .empty-state i {
            font-size: 56px;
            display: block;
            margin-bottom: 16px;
        }

        .empty-state p {
            font-size: 0.95rem;
            color: #aaa;
            margin: 0;
        }

        /* Mobile toggle button — ẩn trên desktop */
        .cat-toggle-btn {
            display: none;
        }

        /* ══════════════════════
               TABLET ≤ 860px
            ══════════════════════ */
        @media (max-width: 860px) {
            .products-page-wrap {
                grid-template-columns: 1fr;
                gap: 16px;
                padding: 0 16px 40px;
            }

            .page-hero {
                padding: 32px 0 24px;
                margin-bottom: 24px;
            }

            .page-hero h1 {
                font-size: 1.8rem;
            }

            .sidebar {
                position: static;
            }

            /* Toggle button hiện */
            .cat-toggle-btn {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding: 13px 20px;
                background: none;
                border: none;
                cursor: pointer;
                font-family: 'Be Vietnam Pro', sans-serif;
                font-size: 0.9rem;
                font-weight: 600;
                color: #333;
            }

            .cat-toggle-btn .toggle-icon {
                transition: transform 0.25s;
                color: #aaa;
                font-size: 0.8rem;
            }

            .cat-toggle-btn.open .toggle-icon {
                transform: rotate(180deg);
            }

            /* Ẩn title static, dùng toggle thay */
            .sidebar-title {
                display: none;
            }

            /* Menu ẩn mặc định */
            .sidebar-menu {
                display: none;
                padding: 4px 0 8px;
                border-top: 1px solid #f5f4f2;
            }

            .sidebar-menu.open {
                display: block;
            }

            .product-toolbar {
                padding: 10px 12px;
                gap: 8px;
            }

            .search-box {
                min-width: unset;
                flex: 1;
            }
        }

        /* ══════════════════════
               MOBILE ≤ 480px
            ══════════════════════ */
        @media (max-width: 480px) {
            .products-page-wrap {
                padding: 0 12px 32px;
                gap: 12px;
            }

            .page-hero {
                padding: 24px 0 18px;
                margin-bottom: 16px;
            }

            .page-hero h1 {
                font-size: 1.4rem;
            }

            .page-hero .breadcrumb {
                font-size: 0.78rem;
                gap: 6px;
            }

            /* Toolbar 2 dòng */
            .product-toolbar {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }

            .toolbar-left {
                flex-wrap: wrap;
            }

            .search-box {
                flex: 1 1 100%;
            }

            .filter-select {
                flex: 1;
                min-width: 0;
                max-width: 100%;
            }

            .toolbar-right {
                text-align: right;
                font-size: 0.8rem;
            }

            /* Dòng 2: select + btn Lọc cùng hàng */
            .toolbar-row2 {
                display: flex;
                gap: 8px;
                width: 100%;
            }

            /* Grid 2 cột */
            .products-grid.col-4 {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
            }

            .card-img-wrap {
                height: 130px;
            }

            .card-body {
                padding: 8px 10px;
            }

            .card-name {
                font-size: 0.76rem;
            }

            .card-price {
                font-size: 0.82rem;
            }

            .card-category {
                font-size: 0.68rem;
            }

            .btn-cart {
                width: 28px;
                height: 28px;
                font-size: 0.72rem;
            }

            /* Pagination */
            .pagination-wrap {
                flex-wrap: wrap;
                gap: 4px;
            }

            .pagination-wrap .page-item a,
            .pagination-wrap .page-item span {
                min-width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
        }
    </style>
@endpush

@section('content')

    <div class="page-hero">
        <div style="max-width:1280px;margin:0 auto;padding:0 24px">
            <h1>Tất cả sản phẩm</h1>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Trang chủ</a>
                <i class="fa-solid fa-chevron-right" style="font-size:10px"></i>
                @if (request('category'))
                    <a href="{{ route('products.index') }}">Sản phẩm</a>
                    <i class="fa-solid fa-chevron-right" style="font-size:10px"></i>
                    <span>{{ request('category') }}</span>
                @else
                    <span>Sản phẩm</span>
                @endif
            </nav>
        </div>
    </div>

    <div class="products-page-wrap">

        {{-- SIDEBAR --}}
        <aside class="sidebar">

            {{-- Toggle (mobile only) --}}
            <button class="cat-toggle-btn" id="catToggleBtn" onclick="toggleCatMenu()">
                <span style="display:flex;align-items:center;gap:8px">
                    <i class="fa-solid fa-list" style="color:#ff4500;font-size:0.85rem"></i>
                    Danh mục
                    @if (request('category'))
                        <span
                            style="background:#ff4500;color:#fff;font-size:0.7rem;
                                     padding:1px 8px;border-radius:20px">
                            {{ request('category') }}
                        </span>
                    @endif
                </span>
                <i class="fa-solid fa-chevron-down toggle-icon"></i>
            </button>

            <div class="sidebar-title">Danh mục</div>

            <ul class="sidebar-menu" id="catMenu">
                <li>
                    <a href="{{ route('products.index', array_filter(request()->except('category', 'page'))) }}"
                        class="{{ !request('category') ? 'active' : '' }}">
                        <i class="fa-solid fa-fire"></i>
                        Tất cả
                        <span class="sidebar-count">{{ $totalCount }}</span>
                    </a>
                </li>
                @foreach ($categories as $cat)
                    <li>
                        <a href="{{ route('products.index', array_merge(request()->except('category', 'page'), ['category' => $cat])) }}"
                            class="{{ request('category') == $cat ? 'active' : '' }}">
                            <i class="fa-solid fa-circle" style="font-size:6px"></i>
                            {{ $cat }}
                            <span class="sidebar-count">{{ $categoryCounts[$cat] ?? 0 }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        {{-- MAIN --}}
        <div class="products-main">
            <form method="GET" action="{{ route('products.index') }}">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="product-toolbar">
                    <div class="toolbar-left">
                        <div class="search-box">
                            <i class="fa-solid fa-search"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Tìm kiếm sản phẩm..." />
                        </div>
                        <div class="toolbar-row2">
                            <select name="sort" class="filter-select" style="flex:1;min-width:0">
                                <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Mới nhất
                                </option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp →
                                    Cao</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao →
                                    Thấp</option>
                            </select>
                            <button type="submit" class="btn-search">
                                <i class="fa-solid fa-filter"></i> Lọc
                            </button>
                            @if (request()->hasAny(['search', 'sort']))
                                <a href="{{ route('products.index', request('category') ? ['category' => request('category')] : []) }}"
                                    class="btn-reset">
                                    <i class="fa-solid fa-xmark"></i> Xoá
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="toolbar-right">
                        <strong style="color:#ff4500">{{ $products->total() }}</strong> sản phẩm
                    </div>
                </div>
            </form>

            @if ($products->count() > 0)
                <div class="products-grid col-4">
                    @foreach ($products as $product)
                        <div class="product-card" onclick="window.location='{{ route('product.show', $product->slug) }}'"
                            style="cursor:pointer;">
                            <div class="card-img-wrap">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="card-product-img" />
                                @else
                                    <i class="fa-solid fa-laptop card-device-icon"></i>
                                @endif
                                @if ($product->badge)
                                    <span class="card-badge badge-hot">{{ $product->badge }}</span>
                                @elseif($product->price_old)
                                    <span class="card-badge badge-hot">
                                        -{{ round((1 - $product->price / $product->price_old) * 100) }}%
                                    </span>
                                @endif
                                <div class="card-actions">
                                    <button class="card-action-btn" onclick="event.stopPropagation()">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                    <button class="card-action-btn" onclick="event.stopPropagation()">
                                        <i class="fa-solid fa-code-compare"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-category">{{ $product->category }}</div>
                                <div class="card-name">{{ $product->name }}</div>
                                <div class="card-rating"><span class="stars">★★★★★</span></div>
                                <div class="card-price-row">
                                    <div>
                                        @if ($product->price_old)
                                            <span class="card-price-old">
                                                {{ number_format($product->price_old, 0, ',', '.') }}₫
                                            </span>
                                        @endif
                                        <span class="card-price">
                                            {{ number_format($product->price, 0, ',', '.') }}₫
                                        </span>
                                    </div>
                                    <form method="POST" action="{{ route('cart.add') }}" class="add-cart-form"
                                        onclick="event.stopPropagation()">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                        <button type="submit" class="btn-cart">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($products->hasPages())
                    <div class="pagination-wrap">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fa-solid fa-box-open"></i>
                    <p>Không tìm thấy sản phẩm nào phù hợp.</p>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function toggleCatMenu() {
            const menu = document.getElementById('catMenu');
            const btn = document.getElementById('catToggleBtn');
            menu.classList.toggle('open');
            btn.classList.toggle('open');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Tự mở accordion nếu đang lọc theo category
            if (window.innerWidth <= 860 && {{ request('category') ? 'true' : 'false' }}) {
                toggleCatMenu();
            }
        });
    </script>
@endpush
