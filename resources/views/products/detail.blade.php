@extends('layouts.app')

@section('title', $product->name . ' — TechXpress')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}" />
@endpush

@section('content')
    <main class="pd-main">
        <!-- Breadcrumb -->
        <div class="breadcrumb-wrap">
            <div class="container">
                <nav class="breadcrumb">
                    <a href="{{ route('home') }}">Trang chủ</a>
                    <i class="fa-solid fa-chevron-right"></i>
                    <a href="#">{{ $product->category }}</a>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span>{{ $product->name }}</span>
                </nav>
            </div>
        </div>

        <!-- ══ PRODUCT TOP SECTION ══ -->
        <section class="pd-top">
            <div class="container">
                <div class="pd-grid">
                    <!-- LEFT: Gallery -->
                    <div class="pd-gallery">
                        <!-- Main image -->
                        <div class="gallery-main" id="galleryMain">
                            <div class="gallery-main-img">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        id="mainImg" />
                                @else
                                    <div
                                        style="display:flex;align-items:center;justify-content:center;height:400px;background:#f5f4f2;">
                                        <i class="fa-solid fa-laptop" style="font-size:120px;color:#ccc;"></i>
                                    </div>
                                @endif
                            </div>
                            <button class="gallery-zoom" title="Phóng to">
                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                            </button>
                            <div class="gallery-badge-wrap">
                                @if ($product->badge)
                                    <span class="gbadge gbadge-hot">{{ $product->badge }}</span>
                                @endif
                                @if ($product->price_old && $product->price_old > $product->price)
                                    <span class="gbadge gbadge-sale">
                                        -{{ round((1 - $product->price / $product->price_old) * 100) }}%
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Thumbnails (ảnh gallery) -->
                        <div class="gallery-thumbs" id="thumbs">
                            {{-- Ảnh chính luôn là thumb đầu tiên --}}
                            @if ($product->image)
                                <button class="thumb active" data-img="{{ asset('storage/' . $product->image) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" />
                                </button>
                            @endif

                            {{-- Ảnh gallery thêm --}}
                            @if ($product->images)
                                @foreach ($product->images as $img)
                                    <button class="thumb" data-img="{{ asset('storage/' . $img) }}">
                                        <img src="{{ asset('storage/' . $img) }}" alt="" />
                                    </button>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- RIGHT: Info -->
                    <div class="pd-info">
                        <!-- Category + SKU -->
                        <div class="pd-brand">
                            <span class="pd-sku">{{ $product->category }}</span>
                        </div>

                        <h1 class="pd-title">{{ $product->name }}</h1>

                        <!-- Rating row -->
                        <div class="pd-rating-row">
                            <div class="stars-lg">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half-stroke"></i>
                            </div>
                            <span class="rating-num">5.0</span>
                            <span class="pd-divider">|</span>
                            <span class="pd-sold">
                                <i class="fa-solid fa-circle-check"></i>
                                @if ($product->stock > 0)
                                    Còn {{ $product->stock }} sản phẩm
                                @else
                                    <span style="color:red">Hết hàng</span>
                                @endif
                            </span>
                        </div>

                        <!-- Price -->
                        <div class="pd-price-box">
                            <div class="pd-price-main">
                                {{ number_format($product->price, 0, ',', '.') }}₫
                            </div>
                            @if ($product->price_old && $product->price_old > $product->price)
                                <div class="pd-price-meta">
                                    <span class="pd-price-old">
                                        {{ number_format($product->price_old, 0, ',', '.') }}₫
                                    </span>
                                    <span class="pd-discount-pill">
                                        Tiết kiệm {{ number_format($product->price_old - $product->price, 0, ',', '.') }}₫
                                    </span>
                                </div>
                            @endif
                            <div class="pd-price-note">
                                <i class="fa-solid fa-tag"></i> Giá đã bao gồm VAT
                            </div>
                        </div>

                        <!-- Quick specs từ DB -->
                        @if ($product->specs)
                            <div class="pd-quick-specs">
                                @foreach (array_slice($product->specs, 0, 4) as $key => $value)
                                    <div class="qspec">
                                        <i class="fa-solid fa-microchip"></i>
                                        <span>{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="pd-separator"></div>

                        <!-- Quantity + CTA -->
                        <div class="pd-qty-row">
                            <div class="qty-wrap">
                                <button class="qty-btn" id="qtyMinus">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <span class="qty-val" id="qtyVal">1</span>
                                <button class="qty-btn" id="qtyPlus">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                            <span class="pd-stock">
                                <i class="fa-solid fa-circle-check"></i>
                                Còn hàng ({{ $product->stock }})
                            </span>
                        </div>

                        <div class="pd-cta-row">
                            <button class="cta-buy">
                                <i class="fa-solid fa-bag-shopping"></i> Mua ngay
                            </button>
                            <form method="POST" action="{{ route('cart.add') }}" id="addCartForm">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                <div class="qty-wrap">
                                    <button type="button" onclick="changeQty(-1)">−</button>
                                    <input type="number" name="quantity" id="qtyInput" value="1" min="1"
                                        max="{{ $product->stock }}" />
                                    <button type="button" onclick="changeQty(1)">+</button>
                                </div>
                                <button type="submit" class="btn-add-cart">
                                    <i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ
                                </button>
                            </form>
                            <button class="cta-wish" id="wishBtn" title="Yêu thích">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </div>

                        <!-- Trust badges -->
                        <div class="pd-trust">
                            <div class="trust-item">
                                <i class="fa-solid fa-shield-halved"></i>
                                <div>
                                    <strong>Bảo hành 24 tháng</strong>
                                    <span>Chính hãng toàn quốc</span>
                                </div>
                            </div>
                            <div class="trust-item">
                                <i class="fa-solid fa-rotate-left"></i>
                                <div>
                                    <strong>Đổi trả 30 ngày</strong>
                                    <span>Không cần lý do</span>
                                </div>
                            </div>
                            <div class="trust-item">
                                <i class="fa-solid fa-truck-fast"></i>
                                <div>
                                    <strong>Giao hỏa tốc</strong>
                                    <span>Trong 2 giờ nội thành</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══ TABS: MÔ TẢ / THÔNG SỐ ══ -->
        <section class="pd-tabs-section">
            <div class="container">
                <div class="pd-tabs">
                    <button class="tab-btn active" data-tab="specs">
                        Thông số kỹ thuật
                    </button>
                    <button class="tab-btn" data-tab="desc">Mô tả sản phẩm</button>
                </div>

                <!-- Tab: Thông số -->
                <div class="tab-panel active" id="tab-specs">
                    @if ($product->specs && count($product->specs) > 0)
                        <div class="specs-grid">
                            <div class="specs-group">
                                <h3 class="specs-group-title">
                                    <i class="fa-solid fa-list"></i> Thông số kỹ thuật
                                </h3>
                                <table class="specs-table">
                                    @foreach ($product->specs as $key => $value)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @else
                        <p style="padding:24px;color:#999">Chưa có thông số kỹ thuật.</p>
                    @endif
                </div>

                <!-- Tab: Mô tả -->
                <div class="tab-panel" id="tab-desc">
                    <div class="desc-content">
                        @if ($product->description)
                            {!! nl2br(e($product->description)) !!}
                        @else
                            <p style="color:#999">Chưa có mô tả sản phẩm.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
    @push('scripts')
        <script>
            // ── Quantity (dùng stock từ blade) ──
            function changeQty(delta) {
                const input = document.getElementById('qtyInput');
                const stock = {{ $product->stock }}; // ← Blade xử lý được ở đây
                input.value = Math.max(1, Math.min(stock, +input.value + delta));
            }

            // ── Thêm giỏ hàng AJAX ──
            document.querySelectorAll('.add-cart-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    fetch('{{ route('cart.add') }}', { // ← Blade xử lý được ở đây
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: this.querySelector('[name=product_id]').value,
                                quantity: parseInt(document.getElementById('qtyInput')?.value || 1)
                            })
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                const badge = document.querySelector('.cart-badge');
                                if (badge) {
                                    badge.textContent = data.count;
                                } else {
                                    const wrap = document.querySelector('.cart-icon-wrap');
                                    const span = document.createElement('span');
                                    span.className = 'cart-badge';
                                    span.textContent = data.count;
                                    wrap.appendChild(span);
                                }
                                const btn = this.querySelector('.btn-cart, .btn-add-cart');
                                const original = btn.innerHTML;
                                btn.style.background = '#22c55e';
                                btn.innerHTML = '<i class="fa-solid fa-check"></i> Đã thêm!';
                                setTimeout(() => {
                                    btn.style.background = '';
                                    btn.innerHTML = original;
                                }, 1500);
                            }
                        });
                });
            });
        </script>
    @endpush
@endsection
