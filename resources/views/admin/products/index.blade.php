@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')

@section('content')

    {{-- ══ PAGE HEADER ══ --}}
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title"><i class="fa-solid fa-box"></i> Sản phẩm</h1>
            <p class="page-subtitle">Quản lý toàn bộ sản phẩm trên cửa hàng</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-primary-admin">
            <i class="fa-solid fa-plus"></i> Thêm sản phẩm
        </a>
    </div>

    {{-- ══ STATS ROW ══ --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff0ec; color:#ff4500;">
                <i class="fa-solid fa-box"></i>
            </div>
            <div class="stat-info">
                <div class="stat-num">{{ $products->total() }}</div>
                <div class="stat-label">Tổng sản phẩm</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f5e9; color:#2e7d32;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-num">{{ $products->where('is_active', true)->count() }}</div>
                <div class="stat-label">Đang hiển thị</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff8e1; color:#f59e0b;">
                <i class="fa-solid fa-fire"></i>
            </div>
            <div class="stat-info">
                <div class="stat-num">{{ $products->where('is_featured', true)->count() }}</div>
                <div class="stat-label">Nổi bật</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce4ec; color:#c62828;">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-num">{{ $products->where('is_flash_sale', true)->count() }}</div>
                <div class="stat-label">Flash Sale</div>
            </div>
        </div>
    </div>

    {{-- ══ FILTER + SEARCH ══ --}}
    <div class="table-toolbar">
        <form method="GET" action="{{ route('admin.products.index') }}" class="toolbar-search">
            <div class="search-field">
                <i class="fa-solid fa-search"></i>
                <input type="text" name="search" placeholder="Tìm tên sản phẩm..." value="{{ request('search') }}" />
            </div>
            <select name="category" class="filter-select">
                <option value="">Tất cả danh mục</option>
                <option value="Laptop Gaming" {{ request('category') == 'Laptop Gaming' ? 'selected' : '' }}>Laptop Gaming
                </option>
                <option value="Laptop Văn phòng"{{ request('category') == 'Laptop Văn phòng' ? 'selected' : '' }}>Laptop Văn
                    phòng</option>
                <option value="PC Gaming" {{ request('category') == 'PC Gaming' ? 'selected' : '' }}>PC Gaming
                </option>
                <option value="Điện thoại" {{ request('category') == 'Điện thoại' ? 'selected' : '' }}>Điện thoại
                </option>
                <option value="Máy tính bảng" {{ request('category') == 'Máy tính bảng' ? 'selected' : '' }}>Máy tính bảng
                </option>
                <option value="Màn hình" {{ request('category') == 'Màn hình' ? 'selected' : '' }}>Màn hình</option>
                <option value="Phụ kiện" {{ request('category') == 'Phụ kiện' ? 'selected' : '' }}>Phụ kiện</option>
            </select>
            <select name="status" class="filter-select">
                <option value="">Tất cả trạng thái</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang hiển thị</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Đã ẩn</option>
                <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Nổi bật</option>
                <option value="flash" {{ request('status') == 'flash' ? 'selected' : '' }}>Flash Sale</option>
            </select>
            <button type="submit" class="btn-filter">
                <i class="fa-solid fa-filter"></i> Lọc
            </button>
            @if (request()->hasAny(['search', 'category', 'status']))
                <a href="{{ route('admin.products.index') }}" class="btn-clear">
                    <i class="fa-solid fa-xmark"></i> Xoá lọc
                </a>
            @endif
        </form>
    </div>

    {{-- ══ TABLE ══ --}}
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:60px">Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá bán</th>
                    <th>Tồn kho</th>
                    <th>Trạng thái</th>
                    <th>Nhãn</th>
                    <th style="width:130px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        {{-- Ảnh --}}
                        <td>
                            <div class="product-thumb">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" />
                                @else
                                    <div class="thumb-placeholder">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </div>
                        </td>

                        {{-- Tên --}}
                        <td>
                            <div class="product-name-cell">
                                <span class="product-name">{{ $product->name }}</span>
                                <span class="product-slug">{{ $product->slug }}</span>
                            </div>
                        </td>

                        {{-- Danh mục --}}
                        <td><span class="category-chip">{{ $product->category }}</span></td>

                        {{-- Giá --}}
                        <td>
                            <div class="price-cell">
                                <span class="price-main">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                @if ($product->price_old)
                                    <span
                                        class="price-old-sm">{{ number_format($product->price_old, 0, ',', '.') }}₫</span>
                                @endif
                            </div>
                        </td>

                        {{-- Tồn kho --}}
                        <td>
                            <span
                                class="stock-badge {{ $product->stock > 10 ? 'stock-ok' : ($product->stock > 0 ? 'stock-low' : 'stock-out') }}">
                                {{ $product->stock > 0 ? $product->stock . ' cái' : 'Hết hàng' }}
                            </span>
                        </td>

                        {{-- Trạng thái --}}
                        <td>
                            <div class="status-badges">
                                <span class="status-dot {{ $product->is_active ? 'dot-green' : 'dot-gray' }}">
                                    {{ $product->is_active ? 'Hiển thị' : 'Đã ẩn' }}
                                </span>
                                @if ($product->is_featured)
                                    <span class="status-dot dot-orange">Nổi bật</span>
                                @endif
                                @if ($product->is_flash_sale)
                                    <span class="status-dot dot-red">Flash Sale</span>
                                @endif
                            </div>
                        </td>

                        {{-- Badge --}}
                        <td>
                            @if ($product->badge)
                                <span class="badge-chip">{{ $product->badge }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- Thao tác --}}
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.products.edit', $product) }}" class="action-btn btn-edit"
                                    title="Sửa">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="{{ route('product.show', $product->slug) }}" class="action-btn btn-view"
                                    title="Xem" target="_blank">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                    onsubmit="return confirm('Xoá sản phẩm này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete" title="Xoá">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fa-solid fa-box-open"></i>
                            <p>Chưa có sản phẩm nào. <a href="{{ route('admin.products.create') }}">Thêm ngay</a></p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($products->hasPages())
        <div class="pagination-wrap">
            {{ $products->withQueryString()->links() }}
        </div>
    @endif

@endsection
