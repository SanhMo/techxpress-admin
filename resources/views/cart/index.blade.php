@extends('layouts.app')

@section('title', 'Giỏ hàng — TechXpress')

@push('styles')
    <style>
        body {
            background: #f5f4f2;
        }

        .cart-hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 36px 0 28px;
            margin-bottom: 36px;
        }

        .cart-hero h1 {
            font-family: 'Rajdhani', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin: 0 0 6px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cart-hero h1 .count-badge {
            background: #ff4500;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 20px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.84rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .breadcrumb a {
            color: #ff4500;
            text-decoration: none;
        }

        .cart-wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px 60px;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            align-items: start;
        }

        /* ── Cart Card ── */
        .cart-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0eeeb;
            overflow: hidden;
        }

        .cart-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            border-bottom: 1px solid #f5f4f2;
        }

        .cart-card-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cart-card-title i {
            color: #ff4500;
        }

        .btn-clear-cart {
            font-size: 0.82rem;
            color: #dc2626;
            background: none;
            border: 1px solid #fecaca;
            border-radius: 6px;
            padding: 5px 12px;
            cursor: pointer;
            font-family: 'Be Vietnam Pro', sans-serif;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-clear-cart:hover {
            background: #fff5f5;
        }

        /* ── Item Row ── */
        .cart-item {
            display: grid;
            grid-template-columns: 80px 1fr auto auto auto;
            align-items: center;
            gap: 16px;
            padding: 18px 24px;
            border-bottom: 1px solid #f5f4f2;
            transition: background 0.15s;
        }

        .cart-item:hover {
            background: #fafaf9;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            overflow: hidden;
            background: #f5f4f2;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-img i {
            font-size: 28px;
            color: #ddd;
        }

        .item-category {
            font-size: 0.75rem;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .item-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .item-name a {
            color: inherit;
            text-decoration: none;
        }

        .item-name a:hover {
            color: #ff4500;
        }

        .item-price-unit {
            font-size: 0.82rem;
            color: #aaa;
        }

        .qty-control {
            display: flex;
            align-items: center;
            border: 1px solid #e8e8e8;
            border-radius: 8px;
            overflow: hidden;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            background: #f5f4f2;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: #555;
            transition: all 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn:hover {
            background: #ff4500;
            color: #fff;
        }

        .qty-input {
            width: 42px;
            height: 32px;
            border: none;
            border-left: 1px solid #e8e8e8;
            border-right: 1px solid #e8e8e8;
            text-align: center;
            font-size: 0.88rem;
            font-weight: 600;
            color: #1a1a1a;
            font-family: 'Be Vietnam Pro', sans-serif;
            outline: none;
            background: #fff;
        }

        .item-subtotal {
            font-size: 1rem;
            font-weight: 700;
            color: #ff4500;
            min-width: 110px;
            text-align: right;
        }

        .btn-remove {
            width: 30px;
            height: 30px;
            background: none;
            border: 1px solid #e8e8e8;
            border-radius: 6px;
            cursor: pointer;
            color: #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            transition: all 0.2s;
        }

        .btn-remove:hover {
            background: #fff5f5;
            border-color: #fecaca;
            color: #dc2626;
        }

        /* ── Empty ── */
        .cart-empty {
            padding: 80px 24px;
            text-align: center;
        }

        .cart-empty i {
            font-size: 56px;
            color: #e0dedd;
            margin-bottom: 16px;
            display: block;
        }

        .cart-empty h3 {
            font-size: 1.1rem;
            color: #aaa;
            margin-bottom: 8px;
        }

        .cart-empty p {
            font-size: 0.88rem;
            color: #ccc;
            margin-bottom: 24px;
        }

        .btn-shop {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ff4500;
            color: #fff;
            padding: 10px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn-shop:hover {
            background: #e03d00;
        }

        /* ── Summary ── */
        .summary-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0eeeb;
            padding: 24px;
            position: sticky;
            top: 20px;
        }

        .summary-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid #f5f4f2;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 0.9rem;
        }

        .summary-row .lbl {
            color: #888;
        }

        .summary-row .val {
            font-weight: 500;
            color: #333;
        }

        .summary-divider {
            height: 1px;
            background: #f5f4f2;
            margin: 16px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .summary-total .lbl {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        .summary-total .val {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #ff4500;
        }

        .coupon-wrap {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }

        .coupon-input {
            flex: 1;
            background: #f5f4f2;
            border: 1px solid #e8e8e8;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 0.88rem;
            color: #333;
            font-family: 'Be Vietnam Pro', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }

        .coupon-input:focus {
            border-color: #ff4500;
        }

        .btn-coupon {
            background: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 9px 14px;
            font-size: 0.82rem;
            font-family: 'Be Vietnam Pro', sans-serif;
            cursor: pointer;
            font-weight: 500;
            white-space: nowrap;
            transition: background 0.2s;
        }

        .btn-coupon:hover {
            background: #333;
        }

        .btn-checkout {
            width: 100%;
            background: #ff4500;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Be Vietnam Pro', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .btn-checkout:hover {
            background: #e03d00;
            box-shadow: 0 4px 20px rgba(255, 69, 0, 0.3);
            transform: translateY(-1px);
        }

        .btn-continue {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 10px;
            background: none;
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            font-size: 0.88rem;
            color: #666;
            font-family: 'Be Vietnam Pro', sans-serif;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-continue:hover {
            border-color: #ff4500;
            color: #ff4500;
        }

        .trust-list {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #f5f4f2;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: #888;
        }

        .trust-item i {
            color: #22c55e;
            width: 14px;
        }

        @media (max-width: 860px) {
            .cart-wrap {
                grid-template-columns: 1fr;
            }

            .summary-card {
                position: static;
            }

            .cart-item {
                grid-template-columns: 64px 1fr;
                gap: 12px;
            }

            .qty-control,
            .item-subtotal,
            .btn-remove {
                grid-column: 2;
            }
        }

        @media (max-width:768px) {

            .cart-item {
                grid-template-columns: 60px 1fr auto;
                align-items: start;
            }

            .qty-control {
                grid-column: 2;
                margin-top: 6px;
            }

            .item-subtotal {
                grid-column: 2;
                text-align: left;
                margin-top: 4px;
            }

            .btn-remove {
                grid-column: 3;
                grid-row: 1;
                align-self: start;
            }

        }
    </style>
@endpush

@section('content')

    <div class="cart-hero">
        <div style="max-width:1200px;margin:0 auto;padding:0 24px">
            <h1>
                <i class="fa-solid fa-cart-shopping"></i>
                Giỏ hàng
                @if ($items->count() > 0)
                    <span class="count-badge">{{ $items->sum('quantity') }} sản phẩm</span>
                @endif
            </h1>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Trang chủ</a>
                <i class="fa-solid fa-chevron-right" style="font-size:10px"></i>
                <span>Giỏ hàng</span>
            </nav>
        </div>
    </div>

    <div class="cart-wrap">

        {{-- LEFT --}}
        <div>
            <div class="cart-card">
                <div class="cart-card-header">
                    <div class="cart-card-title">
                        <i class="fa-solid fa-box"></i> Sản phẩm trong giỏ
                    </div>
                    @if ($items->count() > 0)
                        <form method="POST" action="{{ route('cart.clear') }}"
                            onsubmit="return confirm('Xoá toàn bộ giỏ hàng?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-clear-cart">
                                <i class="fa-solid fa-trash"></i> Xoá tất cả
                            </button>
                        </form>
                    @endif
                </div>

                @forelse($items as $item)
                    <div class="cart-item" id="item-{{ $item->id }}">
                        <div class="item-img">
                            @if ($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                    alt="{{ $item->product->name }}" />
                            @else
                                <i class="fa-solid fa-laptop"></i>
                            @endif
                        </div>

                        <div class="item-info">
                            <div class="item-category">{{ $item->product->category }}</div>
                            <div class="item-name">
                                <a href="{{ route('product.show', $item->product->slug) }}">
                                    {{ $item->product->name }}
                                </a>
                            </div>
                            <div class="item-price-unit">
                                Đơn giá: {{ number_format($item->product->price, 0, ',', '.') }}₫
                            </div>
                        </div>

                        <div class="qty-control">
                            <button type="button" class="qty-btn" onclick="updateQty({{ $item->id }}, -1)">−</button>
                            <input type="number" class="qty-input" id="qty-{{ $item->id }}"
                                value="{{ $item->quantity }}" min="1" max="99"
                                onchange="setQty({{ $item->id }}, this.value)" />
                            <button type="button" class="qty-btn" onclick="updateQty({{ $item->id }}, 1)">+</button>
                        </div>

                        <div class="item-subtotal" id="subtotal-{{ $item->id }}">
                            {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}₫
                        </div>

                        <button type="button" class="btn-remove" onclick="removeItem({{ $item->id }})" title="Xoá">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @empty
                    <div class="cart-empty">
                        <i class="fa-solid fa-cart-xmark"></i>
                        <h3>Giỏ hàng trống</h3>
                        <p>Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                        <a href="{{ route('products.index') }}" class="btn-shop">
                            <i class="fa-solid fa-store"></i> Mua sắm ngay
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- RIGHT --}}
        @if ($items->count() > 0)
            <div>
                <div class="summary-card">
                    <div class="summary-title">Tóm tắt đơn hàng</div>

                    <div class="summary-row">
                        <span class="lbl">Tạm tính ({{ $items->sum('quantity') }} SP)</span>
                        <span class="val" id="summarySubtotal">
                            {{ number_format($total, 0, ',', '.') }}₫
                        </span>
                    </div>
                    <div class="summary-row">
                        <span class="lbl">Phí vận chuyển</span>
                        <span class="val" style="color:#22c55e">Miễn phí</span>
                    </div>
                    <div class="summary-row">
                        <span class="lbl">Giảm giá</span>
                        <span class="val">—</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-total">
                        <span class="lbl">Tổng cộng</span>
                        <span class="val" id="summaryTotal">
                            {{ number_format($total, 0, ',', '.') }}₫
                        </span>
                    </div>

                    <div class="coupon-wrap">
                        <input type="text" class="coupon-input" placeholder="Nhập mã giảm giá..." />
                        <button class="btn-coupon">Áp dụng</button>
                    </div>

                    {{-- Chọn Phương thức --}}

                    <div style="margin-bottom:16px">
                        <div style="font-size:0.85rem;font-weight:600;color:#1a1a1a;margin-bottom:10px">
                            Phương thức thanh toán
                        </div>

                        @php
                            $totalAmount = $total;
                            $isHighValue = $totalAmount >= 10000000; // >= 10 triệu
                            $cocAmount = round($totalAmount * 0.05); // 5% cọc
                        @endphp

                        @if (!$isHighValue)
                            {{-- ── ĐƠN < 10TR: COD bình thường ── --}}
                            <label
                                style="display:flex;align-items:flex-start;gap:10px;padding:12px;
                  border:2px solid #ff4500;border-radius:10px;cursor:pointer;
                  margin-bottom:8px;background:rgba(255,69,0,0.03)">
                                <input type="radio" name="payment" value="cod" checked
                                    style="margin-top:3px;accent-color:#ff4500" />
                                <div>
                                    <div
                                        style="font-size:0.88rem;font-weight:600;color:#1a1a1a;
                        display:flex;align-items:center;gap:6px">
                                        <i class="fa-solid fa-truck-fast" style="color:#ff4500"></i>
                                        Thanh toán khi nhận hàng (COD)
                                    </div>
                                    <div style="font-size:0.78rem;color:#888;margin-top:2px">
                                        Thanh toán bằng tiền mặt khi nhận hàng
                                    </div>
                                </div>
                            </label>

                            <label
                                style="display:flex;align-items:flex-start;gap:10px;padding:12px;
                  border:2px solid #e8e8e8;border-radius:10px;cursor:pointer;
                  margin-bottom:8px">
                                <input type="radio" name="payment" value="ewallet"
                                    style="margin-top:3px;accent-color:#ff4500" />
                                <div>
                                    <div
                                        style="font-size:0.88rem;font-weight:600;color:#1a1a1a;
                        display:flex;align-items:center;gap:6px">
                                        <i class="fa-solid fa-wallet" style="color:#8b5cf6"></i>
                                        Ví điện tử (MoMo / ZaloPay)
                                    </div>
                                    <div style="font-size:0.78rem;color:#888;margin-top:2px">
                                        Thanh toán nhanh qua ví điện tử
                                    </div>
                                </div>
                            </label>
                        @else
                            {{-- ── ĐƠN >= 10TR: BẮT BUỘC CỌC TRƯỚC ── --}}

                            {{-- Banner cảnh báo --}}
                            <div
                                style="background:#fff8e1;border:1px solid #fde68a;border-radius:10px;
                padding:12px 14px;margin-bottom:12px;
                display:flex;align-items:flex-start;gap:10px">
                                <i class="fa-solid fa-circle-exclamation"
                                    style="color:#f59e0b;margin-top:2px;flex-shrink:0"></i>
                                <div style="font-size:0.82rem;color:#92400e;line-height:1.5">
                                    <strong>Đơn hàng trên 10.000.000₫ yêu cầu đặt cọc trước.</strong><br>
                                    Vui lòng thanh toán cọc <strong style="color:#d97706">
                                        {{ number_format($cocAmount, 0, ',', '.') }}₫ (5%)
                                    </strong>
                                    để xác nhận đơn hàng. Số còn lại thanh toán khi nhận hàng.
                                </div>
                            </div>

                            {{-- Cọc qua chuyển khoản --}}
                            <label id="pay-bank"
                                style="display:flex;align-items:flex-start;gap:10px;padding:12px;
                  border:2px solid #ff4500;border-radius:10px;cursor:pointer;
                  margin-bottom:8px;background:rgba(255,69,0,0.03)">
                                <input type="radio" name="payment" value="bank_deposit" checked
                                    style="margin-top:3px;accent-color:#ff4500" />
                                <div style="flex:1">
                                    <div
                                        style="font-size:0.88rem;font-weight:600;color:#1a1a1a;
                        display:flex;align-items:center;gap:6px">
                                        <i class="fa-solid fa-building-columns" style="color:#3b82f6"></i>
                                        Cọc qua chuyển khoản ngân hàng
                                        <span
                                            style="background:#dcfce7;color:#16a34a;font-size:0.72rem;
                             padding:1px 7px;border-radius:20px">Khuyến
                                            nghị</span>
                                    </div>
                                    <div style="font-size:0.78rem;color:#888;margin-top:4px;line-height:1.5">
                                        Cọc trước: <strong style="color:#ff4500">
                                            {{ number_format($cocAmount, 0, ',', '.') }}₫
                                        </strong>
                                        — Còn lại <strong style="color:#555">
                                            {{ number_format($totalAmount - $cocAmount, 0, ',', '.') }}₫
                                        </strong> trả khi nhận
                                    </div>
                                </div>
                            </label>

                            {{-- Cọc qua ví --}}
                            <label id="pay-ewallet"
                                style="display:flex;align-items:flex-start;gap:10px;padding:12px;
                  border:2px solid #e8e8e8;border-radius:10px;cursor:pointer">
                                <input type="radio" name="payment" value="ewallet_deposit"
                                    style="margin-top:3px;accent-color:#ff4500" />
                                <div style="flex:1">
                                    <div
                                        style="font-size:0.88rem;font-weight:600;color:#1a1a1a;
                        display:flex;align-items:center;gap:6px">
                                        <i class="fa-solid fa-wallet" style="color:#8b5cf6"></i>
                                        Cọc qua Ví điện tử (MoMo / ZaloPay)
                                    </div>
                                    <div style="font-size:0.78rem;color:#888;margin-top:4px;line-height:1.5">
                                        Cọc trước: <strong style="color:#ff4500">
                                            {{ number_format($cocAmount, 0, ',', '.') }}₫
                                        </strong>
                                        — Còn lại <strong style="color:#555">
                                            {{ number_format($totalAmount - $cocAmount, 0, ',', '.') }}₫
                                        </strong> trả khi nhận
                                    </div>
                                </div>
                            </label>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('cart.checkout') }}" id="checkoutForm">
                        @csrf
                        <input type="hidden" name="payment" id="selectedPayment" value="cod" />
                        <input type="hidden" name="note" value="" />

                        <button type="submit" class="btn-checkout">
                            <i class="fa-solid fa-lock"></i> Mua ngay
                        </button>
                    </form>

                    <a href="{{ route('products.index') }}" class="btn-continue">
                        <i class="fa-solid fa-arrow-left"></i> Tiếp tục mua sắm
                    </a>

                    <div class="trust-list">
                        <div class="trust-item">
                            <i class="fa-solid fa-shield-halved"></i> Thanh toán bảo mật SSL
                        </div>
                        <div class="trust-item">
                            <i class="fa-solid fa-rotate-left"></i> Đổi trả trong 30 ngày
                        </div>
                        <div class="trust-item">
                            <i class="fa-solid fa-truck-fast"></i> Giao hàng toàn quốc
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection

@push('scripts')
    <script>
        const CSRF = '{{ csrf_token() }}';

        function updateQty(id, delta) {
            const input = document.getElementById('qty-' + id);
            const newQty = Math.max(1, Math.min(99, parseInt(input.value) + delta));
            input.value = newQty;
            sendUpdate(id, newQty);
        }

        function setQty(id, val) {
            const newQty = Math.max(1, Math.min(99, parseInt(val) || 1));
            document.getElementById('qty-' + id).value = newQty;
            sendUpdate(id, newQty);
        }

        function sendUpdate(id, qty) {
            fetch(`/gio-hang/${id}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                    body: JSON.stringify({
                        quantity: qty
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('subtotal-' + id).textContent = data.subtotal + '₫';
                        document.getElementById('summarySubtotal').textContent = data.total + '₫';
                        document.getElementById('summaryTotal').textContent = data.total + '₫';
                        updateBadge(data.count);
                    }
                });
        }

        function removeItem(id) {
            fetch(`/gio-hang/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': CSRF
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const row = document.getElementById('item-' + id);
                        row.style.cssText = 'opacity:0;transform:translateX(20px);transition:all 0.3s';
                        setTimeout(() => {
                            row.remove();
                            if (!document.querySelector('.cart-item')) location.reload();
                        }, 300);
                        updateBadge(data.count);
                    }
                });
        }

        function updateBadge(count) {
            const badge = document.querySelector('.cart-badge');
            if (badge) {
                count > 0 ? badge.textContent = count : badge.remove();
            }
        }
        // ── Highlight radio khi chọn ──
        // document.querySelectorAll('input[name="payment"]').forEach(radio => {
        //     radio.addEventListener('change', function() {
        //         // Reset tất cả border
        //         document.querySelectorAll('input[name="payment"]').forEach(r => {
        //             r.closest('label').style.borderColor = '#e8e8e8';
        //             r.closest('label').style.background = 'transparent';
        //         });
        //         // Active cái được chọn
        //         this.closest('label').style.borderColor = '#ff4500';
        //         this.closest('label').style.background = 'rgba(255,69,0,0.03)';

        //         // Cập nhật tổng nếu chọn bank
        //         const baseTotal = {{ $total }};
        //         const totalEl = document.getElementById('summaryTotal');
        //         if (this.value === 'bank') {
        //             const discounted = Math.round(baseTotal * 0.95);
        //             totalEl.textContent = discounted.toLocaleString('vi-VN') + '₫';
        //             totalEl.style.color = '#22c55e';
        //         } else {
        //             totalEl.textContent = baseTotal.toLocaleString('vi-VN') + '₫';
        //             totalEl.style.color = '#ff4500';
        //         }
        //     });
        // });
        document.querySelectorAll('input[name="payment"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.addEventListener('DOMContentLoaded', function() {
                    const checked = document.querySelector('input[name="payment"]:checked');
                    if (checked) {
                        document.getElementById('selectedPayment').value = checked.value;
                    }
                });
                document.querySelectorAll('input[name="payment"]').forEach(r => {
                    r.closest('label').style.borderColor = '#e8e8e8';
                    r.closest('label').style.background = 'transparent';
                });
                // Active cái được chọn
                this.closest('label').style.borderColor = '#ff4500';
                this.closest('label').style.background = 'rgba(255,69,0,0.03)';

                // Cập nhật tổng nếu chọn bank
                const baseTotal = {{ $total }};
                const totalEl = document.getElementById('summaryTotal');
                if (this.value === 'bank') {
                    const discounted = Math.round(baseTotal * 0.95);
                    totalEl.textContent = discounted.toLocaleString('vi-VN') + '₫';
                    totalEl.style.color = '#22c55e';
                } else {
                    totalEl.textContent = baseTotal.toLocaleString('vi-VN') + '₫';
                    totalEl.style.color = '#ff4500';
                }
            });
        });
    </script>
@endpush
