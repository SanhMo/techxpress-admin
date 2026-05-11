@extends('layouts.app')

@section('title', 'Đặt hàng thành công — TechXpress')

@push('styles')
    <style>
        body {
            background: #f5f4f2;
        }

        .success-wrap {
            max-width: 680px;
            margin: 60px auto;
            padding: 0 24px 80px;
        }

        .success-hero {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #f0eeeb;
            padding: 48px 40px 36px;
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .success-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ff4500, #ff8c00);
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: #fff;
            box-shadow: 0 8px 24px rgba(34, 197, 94, 0.3);
            animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes popIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .success-sub {
            font-size: 0.92rem;
            color: #888;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .order-code-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff0ec;
            border: 1px solid #ffd0c0;
            border-radius: 10px;
            padding: 10px 20px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: #ff4500;
        }

        .detail-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0eeeb;
            margin-bottom: 16px;
            overflow: hidden;
        }

        .detail-card-header {
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

        .detail-card-header i {
            color: #ff4500;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px;
            border-bottom: 1px solid #f9f9f9;
            font-size: 0.88rem;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row .lbl {
            color: #888;
        }

        .info-row .val {
            font-weight: 600;
            color: #1a1a1a;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            border-bottom: 1px solid #f5f4f2;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-item-img {
            width: 52px;
            height: 52px;
            border-radius: 8px;
            background: #f5f4f2;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .order-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .order-item-img i {
            font-size: 22px;
            color: #ddd;
        }

        .deposit-notice {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 16px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .deposit-notice i {
            color: #f59e0b;
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .deposit-notice-text {
            font-size: 0.88rem;
            color: #92400e;
            line-height: 1.6;
        }

        .action-btns-wrap {
            display: flex;
            gap: 12px;
        }

        .btn-primary {
            flex: 1;
            background: #ff4500;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: 'Be Vietnam Pro', sans-serif;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: #e03d00;
            transform: translateY(-1px);
        }

        .btn-secondary {
            flex: 1;
            background: #fff;
            color: #555;
            border: 1px solid #e8e8e8;
            border-radius: 12px;
            padding: 13px;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: 'Be Vietnam Pro', sans-serif;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            border-color: #ff4500;
            color: #ff4500;
        }
    </style>
@endpush

@section('content')
    <div class="success-wrap">

        {{-- Hero --}}
        <div class="success-hero">
            <div class="success-icon"><i class="fa-solid fa-check"></i></div>
            <h1 class="success-title">Đặt hàng thành công!</h1>
            <p class="success-sub">
                Cảm ơn bạn đã mua sắm tại TechXpress.<br>
                Chúng tôi sẽ xác nhận và liên hệ sớm nhất có thể.
            </p>
            <div class="order-code-badge">
                <i class="fa-solid fa-hashtag"></i> {{ $order->order_code }}
            </div>
        </div>

        {{-- Cọc notice --}}
        @if ($order->deposit > 0)
            <div class="deposit-notice">
                <i class="fa-solid fa-circle-info"></i>
                <div class="deposit-notice-text">
                    <strong>Yêu cầu thanh toán cọc:</strong>
                    Vui lòng cọc trước <strong>{{ number_format($order->deposit, 0, ',', '.') }}₫ (5%)</strong>
                    để xác nhận đơn. Còn lại
                    <strong>{{ number_format($order->total - $order->deposit, 0, ',', '.') }}₫</strong>
                    trả khi nhận hàng.<br>
                    <span style="margin-top:4px;display:block">
                        Liên hệ <strong>1800 6789</strong> sau khi chuyển khoản.
                    </span>
                </div>
            </div>
        @endif

        {{-- Thông tin đơn --}}
        <div class="detail-card">
            <div class="detail-card-header"><i class="fa-solid fa-circle-info"></i> Thông tin đơn hàng</div>
            <div class="info-row">
                <span class="lbl">Mã đơn hàng</span>
                <span style="color:#ff4500;font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700">
                    {{ $order->order_code }}
                </span>
            </div>
            <div class="info-row">
                <span class="lbl">Ngày đặt</span>
                <span class="val">{{ $order->created_at->format('H:i — d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="lbl">Phương thức</span>
                <span class="val">{{ $order->paymentLabel() }}</span>
            </div>
            <div class="info-row">
                <span class="lbl">Trạng thái</span>
                <span
                    style="font-size:0.82rem;font-weight:600;padding:3px 10px;border-radius:20px;
                         background:{{ $order->statusColor() }}20;color:{{ $order->statusColor() }}">
                    {{ $order->statusLabel() }}
                </span>
            </div>
            <div class="info-row">
                <span class="lbl">Tổng tiền</span>
                <span style="font-family:'Rajdhani',sans-serif;font-size:1.1rem;font-weight:700;color:#ff4500">
                    {{ number_format($order->total, 0, ',', '.') }}₫
                </span>
            </div>
        </div>

        {{-- Sản phẩm --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fa-solid fa-box"></i> Sản phẩm đã đặt ({{ $order->items->count() }})
            </div>
            @foreach ($order->items as $item)
                <div class="order-item">
                    <div class="order-item-img">
                        @if ($item->product && $item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" />
                        @else
                            <i class="fa-solid fa-laptop"></i>
                        @endif
                    </div>
                    <div style="flex:1">
                        <div style="font-size:0.88rem;font-weight:600;color:#1a1a1a;line-height:1.4">
                            {{ $item->product_name }}
                        </div>
                        <div style="font-size:0.78rem;color:#aaa;margin-top:3px">
                            {{ number_format($item->price, 0, ',', '.') }}₫ × {{ $item->quantity }}
                        </div>
                    </div>
                    <div style="font-size:0.92rem;font-weight:700;color:#ff4500;flex-shrink:0">
                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Buttons --}}
        <div class="action-btns-wrap">
            <a href="{{ route('home') }}" class="btn-secondary">
                <i class="fa-solid fa-house"></i> Trang chủ
            </a>
            <a href="{{ route('products.index') }}" class="btn-primary">
                <i class="fa-solid fa-store"></i> Tiếp tục mua sắm
            </a>
        </div>

    </div>
@endsection
