@extends('layouts.app')

@section('title', 'Trang chủ — TechXpress')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/banner.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
@endpush

@section('content')
    <main>

        {{-- ══ BANNER SLIDER ══ --}}
        <section class="banner" id="banner">
            <div class="slides" id="slides">

                {{-- Slide 1: Laptop --}}
                <div class="slide slide-1">
                    <div class="slide-content">
                        <div class="slide-tag">Mới nhất 2025</div>
                        <h2 class="slide-title">
                            Laptop Gaming<br /><em>Hiệu năng đỉnh</em>
                        </h2>
                        <p class="slide-desc">
                            Intel Core i9 · RTX 4080 · 32GB RAM · Màn hình 240Hz QHD — Chinh
                            phục mọi tựa game.
                        </p>
                        <div class="slide-price-row">
                            <span class="price-new">45.990.000₫</span>
                            <span class="price-old">52.000.000₫</span>
                            <span class="price-badge">-12%</span>
                        </div>
                        <div class="slide-actions">
                            <a href="#" class="btn-primary">
                                <i class="fa-solid fa-bag-shopping"></i> Mua ngay
                            </a>
                            <a href="#" class="btn-secondary">
                                <i class="fa-solid fa-eye"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                    <div class="slide-visual">
                        <img src="{{ asset('img/bannerlaptop.png') }}" alt="Laptop Gaming" />
                    </div>
                </div>

                {{-- Slide 2: Phone --}}
                <div class="slide slide-2">
                    <div class="slide-content">
                        <div class="slide-tag">Ra mắt hôm nay</div>
                        <h2 class="slide-title">
                            Flagship Phone<br /><em>Camera 200MP</em>
                        </h2>
                        <p class="slide-desc">
                            Snapdragon 8 Gen 3 · Pin 5000mAh · Sạc 120W · IP68 chống nước —
                            Siêu phẩm năm 2025.
                        </p>
                        <div class="slide-price-row">
                            <span class="price-new">22.490.000₫</span>
                            <span class="price-old">26.000.000₫</span>
                            <span class="price-badge">-13%</span>
                        </div>
                        <div class="slide-actions">
                            <a href="#" class="btn-primary">
                                <i class="fa-solid fa-bag-shopping"></i> Mua ngay
                            </a>
                            <a href="#" class="btn-secondary">
                                <i class="fa-solid fa-eye"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                    <div class="slide-visual">
                        <img src="{{ asset('img/bannerphone.png') }}" alt="Flagship Phone" />
                    </div>
                </div>

                {{-- Slide 3: Gaming PC --}}
                <div class="slide slide-3">
                    <div class="slide-content">
                        <div class="slide-tag">Build sẵn · Ship ngay</div>
                        <h2 class="slide-title">
                            PC Gaming<br /><em>RTX 4090 Beast</em>
                        </h2>
                        <p class="slide-desc">
                            AMD Ryzen 9 7950X · RTX 4090 · 64GB DDR5 · SSD 2TB NVMe — Máy
                            chiến không đối thủ.
                        </p>
                        <div class="slide-price-row">
                            <span class="price-new">89.990.000₫</span>
                            <span class="price-old">105.000.000₫</span>
                            <span class="price-badge">-14%</span>
                        </div>
                        <div class="slide-actions">
                            <a href="#" class="btn-primary">
                                <i class="fa-solid fa-bag-shopping"></i> Mua ngay
                            </a>
                            <a href="#" class="btn-secondary">
                                <i class="fa-solid fa-eye"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                    <div class="slide-visual">
                        <img src="{{ asset('img/bannerpc.png') }}" alt="PC Gaming" />
                    </div>
                </div>

            </div>

            {{-- Controls --}}
            <button class="banner-prev" id="prev">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button class="banner-next" id="next">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
            <div class="banner-dots" id="dots">
                <button class="dot active" data-index="0"></button>
                <button class="dot" data-index="1"></button>
                <button class="dot" data-index="2"></button>
            </div>
            <div class="banner-progress" id="progress"></div>
        </section>

        {{-- ══ SẢN PHẨM NỔI BẬT ══ --}}
        <section style="background: #f5f4f2">
            <div class="section">
                <div class="section-header">
                    <div>
                        <div class="section-label">Được chọn nhiều nhất</div>
                        <h2 class="section-title">Sản phẩm nổi bật</h2>
                    </div>
                    <a href="{{ route('products.index') }}" class="section-link">
                        Xem tất cả <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                {{-- Filter chips --}}
                <div class="cat-chips">
                    <a href="#" class="cat-chip active"><i class="fa-solid fa-fire"></i> Tất cả</a>
                    <a href="#" class="cat-chip"><i class="fa-solid fa-laptop"></i> Laptop</a>
                    <a href="#" class="cat-chip"><i class="fa-solid fa-gamepad"></i> PC Gaming</a>
                    <a href="#" class="cat-chip"><i class="fa-solid fa-mobile-screen"></i> Điện thoại</a>
                    <a href="#" class="cat-chip"><i class="fa-solid fa-keyboard"></i> Phụ kiện</a>
                </div>

                <div class="products-grid col-4">
                    @forelse($featured as $product)
                        <div class="product-card">
                            <a href="{{ route('product.show', $product->slug) }}"
                                style="display:block; text-decoration:none; color:inherit;">
                                <div class="card-img-wrap">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="card-product-img" />
                                    @else
                                        <i class="fa-solid fa-laptop card-device-icon"></i>
                                    @endif
                                    @if ($product->badge)
                                        <span class="card-badge badge-hot">{{ $product->badge }}</span>
                                    @endif
                                    <div class="card-actions">
                                        <button class="card-action-btn"><i class="fa-regular fa-heart"></i></button>
                                        <button class="card-action-btn"><i class="fa-solid fa-code-compare"></i></button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="card-category">{{ $product->category }}</div>
                                    <div class="card-name">{{ $product->name }} </div>
                                    <div class="card-rating">
                                        <span class="stars">★★★★★</span>
                                    </div>
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
                            </a>
                        </div>
                    @empty
                        <p style="color:#999; padding:20px">Chưa có sản phẩm nổi bật.</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- ══ FLASH SALE ══ --}}
        <section class="flash-sale-section">
            <div class="section">
                <div class="flash-header">
                    <div class="flash-title-wrap">
                        <div class="flash-icon">⚡</div>
                        <div>
                            <div class="flash-title">Flash Sale</div>
                            <div class="flash-subtitle">Ưu đãi có giới hạn — Nhanh tay kẻo hết!</div>
                        </div>
                    </div>
                    <div class="countdown">
                        <span class="countdown-label">Kết thúc sau:</span>
                        <div class="time-unit" id="cd-h">05<small>Giờ</small></div>
                        <span class="time-sep">:</span>
                        <div class="time-unit" id="cd-m">42<small>Phút</small></div>
                        <span class="time-sep">:</span>
                        <div class="time-unit" id="cd-s">30<small>Giây</small></div>
                    </div>
                    <a href="{{ route('products.index') }}" class="section-link">
                        Xem tất cả <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="flash-grid">
                    @forelse($flashSale as $product)
                        <div class="flash-card">
                            <a href="{{ route('product.show', $product->slug) }}"
                                style="display:block; text-decoration:none; color:inherit;">
                                <div class="flash-card-img">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            style="width:100%;height:100%;object-fit:contain;padding:12px" />
                                    @else
                                        <i class="fa-solid fa-box"></i>
                                    @endif
                                    @if ($product->price_old)
                                        <span class="flash-discount-badge">
                                            -{{ round((1 - $product->price / $product->price_old) * 100) }}%
                                        </span>
                                    @endif
                                </div>

                                <div class="flash-progress-wrap">
                                    <div class="flash-progress-bar">
                                        <div class="flash-progress-fill"
                                            style="width: {{ $product->flash_sale_total > 0 ? round(($product->flash_sale_sold / $product->flash_sale_total) * 100) : 0 }}%">
                                        </div>
                                    </div>
                                    <div class="flash-progress-text">
                                        Đã bán {{ $product->flash_sale_sold }}/{{ $product->flash_sale_total }}
                                    </div>
                                </div>
                                <div class="flash-card-body">
                                    <div class="card-category">{{ $product->category }}</div>
                                    <div class="card-name">{{ $product->name }} </div>
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
                            </a>
                        </div>
                    @empty
                        <p style="color:#999; padding:20px">Chưa có sản phẩm flash sale.</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- ══ SẢN PHẨM MỚI NHẤT ══ --}}
        <section style="background: #f5f4f2">
            <div class="section">
                <div class="section-header">
                    <div>
                        <div class="section-label">Vừa về hàng</div>
                        <h2 class="section-title">Sản phẩm mới nhất</h2>
                    </div>
                    <a href="{{ route('products.index') }}" class="section-link">
                        Xem tất cả <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="products-grid col-4">
                    @forelse($newest as $product)
                        <div class="product-card" onclick="window.location='{{ route('product.show', $product->slug) }}'"
                            style="cursor:pointer;">
                            <div class="card-img-wrap" style="height:200px">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="card-product-img" />
                                @else
                                    <i class="fa-solid fa-laptop card-device-icon" style="font-size:72px"></i>
                                @endif
                                <span class="card-badge badge-new">Mới về</span>
                                <div class="card-actions">
                                    <button class="card-action-btn"><i class="fa-regular fa-heart"></i></button>
                                    <button class="card-action-btn"><i class="fa-solid fa-code-compare"></i></button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="card-category">{{ $product->category }}</div>
                                <div class="card-name">{{ $product->name }} </div>
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
                    @empty
                        <p style="color:#999; padding:20px">Chưa có sản phẩm mới.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
@endsection
