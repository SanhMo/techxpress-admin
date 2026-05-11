@extends('layouts.app')

@section('title', 'Đơn hàng ' . $order->order_code . ' — TechXpress')

@push('styles')
    <style>
        body {
            background: #f5f4f2;
        }

        .order-detail-wrap {
            max-width: 780px;
            margin: 40px auto;
            padding: 0 24px 60px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: #888;
            text-decoration: none;
            margin-bottom: 20px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #ff4500;
        }

        /* ── Status banner ── */
        .status-banner {
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .status-banner-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .status-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .status-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .status-sub {
            font-size: 0.82rem;
            margin-top: 2px;
        }

        /* ── Timeline ── */
        .timeline-wrap {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0eeeb;
            padding: 20px 24px;
            margin-bottom: 16px;
        }

        .timeline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            height: 2px;
            background: #e8e8e8;
            z-index: 0;
        }

        .tl-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .tl-dot {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            transition: all 0.3s;
            border: 2px solid #e8e8e8;
            background: #fff;
            color: #ccc;
        }

        .tl-dot.done {
            background: #ff4500;
            border-color: #ff4500;
            color: #fff;
        }

        .tl-dot.current {
            background: #fff;
            border-color: #ff4500;
            color: #ff4500;
            box-shadow: 0 0 0 4px rgba(255, 69, 0, 0.1);
        }

        .tl-label {
            font-size: 0.75rem;
            color: #aaa;
            text-align: center;
        }

        .tl-label.done {
            color: #ff4500;
            font-weight: 600;
        }

        .tl-label.current {
            color: #1a1a1a;
            font-weight: 600;
        }

        /* ── Cards ── */
        .od-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0eeeb;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .od-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f5f4f2;
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .od-card-header i {
            color: #ff4500;
        }

        .od-item {
            display: flex;
            position: relative;
            padding-bottom: 30px;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            border-bottom: 1px solid #f5f4f2;
        }

        .od-item:last-child {
            border-bottom: none;
        }

        .od-item-img {
            width: 56px;
            height: 56px;
            border-radius: 8px;
            background: #f5f4f2;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .od-item .remove-btn {
            position: absolute;
            right: 12px;
            bottom: 12px;
        }

        .od-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .od-item-img i {
            font-size: 22px;
            color: #ddd;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }

        .info-cell {
            padding: 13px 20px;
            border-bottom: 1px solid #f9f9f9;
            font-size: 0.88rem;
        }

        .info-cell:nth-child(odd) {
            border-right: 1px solid #f9f9f9;
        }

        .info-cell .lbl {
            color: #aaa;
            font-size: 0.75rem;
            margin-bottom: 3px;
        }

        .info-cell .val {
            font-weight: 600;
            color: #1a1a1a;
        }

        /* Cọc notice */
        .coc-notice {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 16px;
            display: flex;
            gap: 10px;
            font-size: 0.85rem;
            color: #92400e;
        }

        .coc-notice i {
            color: #f59e0b;
            flex-shrink: 0;
            margin-top: 2px;
        }
    </style>
@endpush

@section('content')
    <div class="order-detail-wrap">

        <a href="{{ route('profile.index') }}?tab=orders" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Quay lại đơn hàng
        </a>

        {{-- ── Status Banner ── --}}
        @php
            $bannerBg = $order->statusColor() . '15';
            $bannerColor = $order->statusColor();
            $statusIcons = [
                'pending' => 'fa-clock',
                'confirmed' => 'fa-check',
                'shipping' => 'fa-truck',
                'delivered' => 'fa-circle-check',
                'cancelled' => 'fa-ban',
            ];
            $icon = $statusIcons[$order->status] ?? 'fa-circle';
        @endphp

        <div class="status-banner" style="background:{{ $bannerBg }};border:1px solid {{ $bannerColor }}30">
            <div class="status-banner-left">
                <div class="status-icon" style="background:{{ $bannerColor }}20;color:{{ $bannerColor }}">
                    <i class="fa-solid {{ $icon }}"></i>
                </div>
                <div>
                    <div class="status-title" style="color:{{ $bannerColor }}">
                        {{ $order->statusLabel() }}
                    </div>
                    <div class="status-sub" style="color:{{ $bannerColor }}99">
                        Đặt lúc {{ $order->created_at->format('H:i — d/m/Y') }}
                    </div>
                </div>
            </div>
            <div style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;color:#666">
                #{{ $order->order_code }}
            </div>
        </div>

        {{-- ── Timeline ── --}}
        @if ($order->status !== 'cancelled')
            @php
                $steps = ['pending', 'confirmed', 'shipping', 'delivered'];
                $statusIdx = array_search($order->status, $steps);
            @endphp
            <div class="timeline-wrap">
                <div class="timeline">
                    @foreach ([['fa-clock', 'Chờ xác nhận'], ['fa-check', 'Đã xác nhận'], ['fa-truck', 'Đang giao'], ['fa-circle-check', 'Đã giao']] as $i => [$ico, $lbl])
                        <div class="tl-step">
                            <div class="tl-dot {{ $i < $statusIdx ? 'done' : ($i == $statusIdx ? 'current' : '') }}">
                                <i class="fa-solid {{ $ico }}"></i>
                            </div>
                            <div class="tl-label {{ $i < $statusIdx ? 'done' : ($i == $statusIdx ? 'current' : '') }}">
                                {{ $lbl }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ── Cọc notice ── --}}
        @if ($order->deposit > 0 && $order->payment_status !== 'paid')
            <div class="coc-notice">
                <i class="fa-solid fa-circle-info"></i>
                <div>
                    Đơn hàng yêu cầu cọc <strong>{{ number_format($order->deposit, 0, ',', '.') }}₫</strong>.
                    Vui lòng chuyển khoản và liên hệ <strong>1800 6789</strong> để xác nhận.
                    Còn lại <strong>{{ number_format($order->total - $order->deposit, 0, ',', '.') }}₫</strong> trả khi
                    nhận.
                </div>
            </div>
        @endif

        {{-- ── Sản phẩm ── --}}
        <div class="od-card">
            <div class="od-card-header">
                <i class="fa-solid fa-box"></i>
                Sản phẩm ({{ $order->items->count() }})
            </div>
            @foreach ($order->items as $item)
                <div class="od-item">
                    <div class="od-item-img">
                        @if ($item->product && $item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" />
                        @else
                            <i class="fa-solid fa-laptop"></i>
                        @endif
                    </div>
                    <div style="flex:1;min-width:0">
                        <div
                            style="font-size:0.9rem;font-weight:600;color:#1a1a1a;
                            line-height:1.4;margin-bottom:4px">
                            {{ $item->product_name }}
                        </div>
                        <div style="font-size:0.78rem;color:#aaa">
                            {{ number_format($item->price, 0, ',', '.') }}₫ × {{ $item->quantity }}
                        </div>
                    </div>
                    <div style="font-size:0.95rem;font-weight:700;color:#ff4500;flex-shrink:0">
                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                    </div>
                </div>
            @endforeach

            {{-- Tổng --}}
            <div
                style="padding:14px 20px;border-top:1px solid #f5f4f2;
                    display:flex;justify-content:space-between;align-items:center">
                <span style="font-weight:600;color:#555;font-size:0.9rem">Tổng cộng</span>
                <span
                    style="font-family:'Rajdhani',sans-serif;font-size:1.3rem;
                         font-weight:700;color:#ff4500">
                    {{ number_format($order->total, 0, ',', '.') }}₫
                </span>
            </div>
        </div>

        {{-- ── Thông tin giao hàng & thanh toán ── --}}
        <div class="od-card">
            <div class="od-card-header">
                <i class="fa-solid fa-circle-info"></i> Chi tiết đơn hàng
            </div>
            <div class="info-grid">
                <div class="info-cell">
                    <div class="lbl">Người nhận</div>
                    <div class="val">{{ $order->receiver_name ?? auth()->user()->name }}</div>
                </div>
                <div class="info-cell">
                    <div class="lbl">Số điện thoại</div>
                    <div class="val">{{ $order->receiver_phone ?? '—' }}</div>
                </div>
                <div class="info-cell" style="grid-column:span 2;border-right:none">
                    <div class="lbl">Địa chỉ giao hàng</div>
                    <div class="val">{{ $order->receiver_address ?? '—' }}</div>
                </div>
                <div class="info-cell">
                    <div class="lbl">Phương thức</div>
                    <div class="val">{{ $order->paymentLabel() }}</div>
                </div>
                <div class="info-cell">
                    <div class="lbl">Trạng thái thanh toán</div>
                    <div class="val" style="color:{{ $order->payment_status == 'paid' ? '#22c55e' : '#f59e0b' }}">
                        {{ $order->payment_status == 'paid'
                            ? 'Đã thanh toán'
                            : ($order->payment_status == 'deposited'
                                ? 'Đã cọc'
                                : 'Chưa thanh toán') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Actions ── --}}
        <div style="display:flex;gap:12px">
            <a href="{{ route('profile.index') }}?tab=orders"
                style="flex:1;display:flex;align-items:center;justify-content:center;gap:7px;
                  padding:12px;border:1px solid #e8e8e8;border-radius:12px;
                  font-size:0.88rem;color:#666;text-decoration:none;transition:all 0.2s"
                onmouseover="this.style.borderColor='#ff4500';this.style.color='#ff4500'"
                onmouseout="this.style.borderColor='#e8e8e8';this.style.color='#666'">
                <i class="fa-solid fa-list"></i> Tất cả đơn hàng
            </a>
            <a href="{{ route('products.index') }}"
                style="flex:1;display:flex;align-items:center;justify-content:center;gap:7px;
                  padding:12px;background:#ff4500;border-radius:12px;
                  font-size:0.88rem;font-weight:700;color:#fff;text-decoration:none;transition:all 0.2s"
                onmouseover="this.style.background='#e03d00'" onmouseout="this.style.background='#ff4500'">
                <i class="fa-solid fa-store"></i> Tiếp tục mua sắm
            </a>
        </div>

    </div>
@endsection
