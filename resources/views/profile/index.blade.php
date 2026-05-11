@extends('layouts.app')

@section('title', 'Tài khoản — TechXpress')

@push('styles')
    <style>
        body {
            background: #f5f4f2;
        }

        /* ── Hero ── */
        .profile-hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 40px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .profile-hero::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 40px;
            background: #f5f4f2;
            clip-path: ellipse(55% 100% at 50% 100%);
        }

        .profile-avatar-wrap {
            display: flex;
            align-items: center;
            gap: 20px;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .profile-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff4500, #ff8c00);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 20px rgba(255, 69, 0, 0.4);
        }

        .profile-hero-info h2 {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #fff;
            margin: 0 0 4px;
        }

        .profile-hero-info p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            margin: 0;
        }

        /* ── Layout ── */
        .profile-wrap {
            max-width: 1100px;
            margin: -20px auto 0;
            padding: 0 24px 60px;
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 24px;
            align-items: start;
            position: relative;
            z-index: 1;
        }

        /* ── Sidebar ── */
        .profile-sidebar {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0eeeb;
            overflow: hidden;
            position: sticky;
            top: 20px;
        }

        .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 20px;
            font-size: 0.9rem;
            color: #555;
            cursor: pointer;
            transition: all 0.15s;
            border-left: 3px solid transparent;
            border-bottom: 1px solid #f9f9f9;
            background: none;
            border-right: none;
            border-top: none;
            width: 100%;
            text-align: left;
            font-family: 'Be Vietnam Pro', sans-serif;
        }

        .sidebar-nav-item:last-child {
            border-bottom: none;
        }

        .sidebar-nav-item i {
            width: 16px;
            text-align: center;
            color: #ccc;
            font-size: 0.85rem;
        }

        .sidebar-nav-item.active {
            color: #ff4500;
            background: rgba(255, 69, 0, 0.04);
            border-left-color: #ff4500;
            font-weight: 600;
        }

        .sidebar-nav-item.active i {
            color: #ff4500;
        }

        .sidebar-nav-item:hover:not(.active) {
            background: #fafaf9;
            color: #333;
        }

        /* ── Cards ── */
        .profile-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0eeeb;
            overflow: hidden;
            display: none;
        }

        .profile-card.active {
            display: block;
        }

        .profile-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid #f5f4f2;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-card-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        .profile-card-title i {
            color: #ff4500;
        }

        /* ── Form ── */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            padding: 24px;
        }

        .form-group-p {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group-p.span2 {
            grid-column: span 2;
        }

        .form-label-p {
            font-size: 0.82rem;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .form-input-p {
            background: #f5f4f2;
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 0.92rem;
            color: #1a1a1a;
            font-family: 'Be Vietnam Pro', sans-serif;
            outline: none;
            transition: all 0.2s;
        }

        .form-input-p:focus {
            border-color: #ff4500;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(255, 69, 0, 0.08);
        }

        .form-actions {
            padding: 0 24px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-save {
            background: #ff4500;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 11px 24px;
            font-size: 0.9rem;
            font-weight: 700;
            font-family: 'Be Vietnam Pro', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .btn-save:hover {
            background: #e03d00;
            transform: translateY(-1px);
        }

        .alert-success-p {
            margin: 16px 24px 0;
            background: rgba(34, 197, 94, 0.08);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 10px;
            padding: 10px 14px;
            color: #16a34a;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Orders ── */
        .order-list {
            padding: 8px 0;
        }

        .order-row {
            display: grid;
            grid-template-columns: auto 1fr auto auto auto;
            align-items: center;
            gap: 16px;
            padding: 16px 24px;
            border-bottom: 1px solid #f5f4f2;
            transition: background 0.15s;
            cursor: pointer;
        }

        .order-row:hover {
            background: #fafaf9;
        }

        .order-row:last-child {
            border-bottom: none;
        }

        .order-code {
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: #ff4500;
        }

        .order-info-main {
            min-width: 0;
        }

        .order-date {
            font-size: 0.78rem;
            color: #aaa;
            margin-bottom: 3px;
        }

        .order-items-preview {
            font-size: 0.85rem;
            color: #555;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .order-total {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a1a;
            white-space: nowrap;
        }

        .order-status-badge {
            font-size: 0.78rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .order-chevron {
            color: #ccc;
            font-size: 0.8rem;
        }

        .order-empty {
            padding: 60px 24px;
            text-align: center;
        }

        .order-empty i {
            font-size: 48px;
            color: #e0dedd;
            display: block;
            margin-bottom: 12px;
        }

        .order-empty p {
            font-size: 0.9rem;
            color: #aaa;
            margin-bottom: 20px;
        }

        .btn-shop-now {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #ff4500;
            color: #fff;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-shop-now:hover {
            background: #e03d00;
        }

        .order-pagination {
            padding: 16px 24px;
            border-top: 1px solid #f5f4f2;
            display: flex;
            justify-content: center;
        }

        /* ════════════════════════════════
                                       RESPONSIVE — Tablet (≤ 768px)
                                    ════════════════════════════════ */
        @media (max-width: 768px) {
            .profile-hero {
                padding: 28px 0 60px;
            }

            .profile-avatar-wrap {
                gap: 14px;
                padding: 0 16px;
            }

            .profile-avatar {
                width: 56px;
                height: 56px;
                font-size: 1.4rem;
            }

            .profile-hero-info h2 {
                font-size: 1.3rem;
            }

            .profile-wrap {
                grid-template-columns: 1fr;
                margin-top: -10px;
                gap: 16px;
                padding: 0 16px 40px;
            }

            /* Sidebar ngang cuộn */
            .profile-sidebar {
                position: static;
                display: flex;
                overflow-x: auto;
                border-radius: 12px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }

            .profile-sidebar::-webkit-scrollbar {
                display: none;
            }

            .sidebar-nav-item {
                white-space: nowrap;
                flex-shrink: 0;
                width: auto;
                border-left: none !important;
                border-top: none;
                border-bottom: 3px solid transparent !important;
                border-right: 1px solid #f5f4f2;
                padding: 12px 18px;
            }

            .sidebar-nav-item:last-child {
                border-right: none;
            }

            .sidebar-nav-item.active {
                border-bottom: 3px solid #ff4500 !important;
                border-left: none !important;
            }

            /* Form */
            .form-grid {
                grid-template-columns: 1fr;
                padding: 16px;
                gap: 12px;
            }

            .form-group-p.span2 {
                grid-column: span 1;
            }

            .form-actions {
                padding: 0 16px 16px;
                flex-wrap: wrap;
            }

            .profile-card-header {
                padding: 14px 16px;
            }

            /* Orders */
            .order-row {
                grid-template-columns: 1fr auto auto;
                gap: 10px;
                padding: 12px 16px;
            }

            .order-code {
                display: none;
            }

            .order-chevron {
                display: none;
            }

            .order-pagination {
                padding: 12px 16px;
            }

            .order-pagination .pagination {
                display: flex !important;
                flex-direction: row !important;
                justify-content: center;
                align-items: center;
                gap: 8px;
                flex-wrap: nowrap;
                padding: 0;
                margin: 0;
                list-style: none;
            }

            .order-pagination .page-item {
                display: inline-block !important;
            }

            .order-pagination .page-link {
                display: inline-block !important;
                padding: 8px 12px;
                font-size: 0.9rem;
                border-radius: 6px;
            }

        }

        /* ════════════════════════════════
                                       RESPONSIVE — Mobile (≤ 480px)
                                    ════════════════════════════════ */
        @media (max-width: 480px) {
            .profile-hero {
                padding: 20px 0 50px;
            }

            .profile-avatar {
                width: 46px;
                height: 46px;
                font-size: 1.2rem;
            }

            .profile-hero-info h2 {
                font-size: 1.05rem;
            }

            .profile-hero-info p {
                font-size: 0.75rem;
            }

            .profile-wrap {
                padding: 0 12px 40px;
                gap: 12px;
            }

            .sidebar-nav-item {
                font-size: 0.8rem;
                padding: 10px 12px;
                gap: 6px;
            }

            .sidebar-nav-item i {
                font-size: 0.75rem;
            }

            .form-grid {
                padding: 12px;
                gap: 10px;
            }

            .form-input-p {
                padding: 10px 12px;
                font-size: 0.88rem;
            }

            .form-label-p {
                font-size: 0.75rem;
            }

            .form-actions {
                padding: 0 12px 12px;
            }

            .btn-save {
                width: 100%;
                justify-content: center;
            }

            /* Orders mobile */
            .order-row {
                grid-template-columns: 1fr auto;
                gap: 8px;
                padding: 10px 12px;
            }

            .order-status-badge {
                display: none;
            }

            .order-total {
                font-size: 0.88rem;
            }

            .order-items-preview {
                font-size: 0.8rem;
            }

            .order-date {
                font-size: 0.72rem;
            }

            .order-empty {
                padding: 40px 16px;
            }

            .order-empty i {
                font-size: 36px;
            }

            .alert-success-p {
                margin: 12px 12px 0;
                font-size: 0.8rem;
            }

            /* Order row */
            .order-row {
                grid-template-columns: 1fr auto;
                gap: 6px;
                padding: 12px;
                align-items: start;
            }

            /* khối thông tin */
            .order-info-main {
                grid-column: 1 / span 1;
            }

            /* tên sản phẩm */
            .order-items-preview {
                font-size: 0.82rem;
                line-height: 1.3;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 200px;
            }

            /* ngày giờ */
            .order-date {
                font-size: 0.72rem;
                color: #999;
                margin-bottom: 2px;
            }

            /* giá */
            .order-total {
                font-size: 0.9rem;
                font-weight: 700;
            }

            /* ẩn status để gọn */
            .order-status-badge {
                display: none;
            }

            /* pagination */
            .order-pagination {
                padding: 14px 10px;
            }

            .order-pagination .pagination {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 6px;
                flex-wrap: wrap;
                margin: 0;
            }

            .order-pagination .page-link {
                padding: 6px 10px;
                font-size: 0.8rem;
                border-radius: 6px;
            }

        }
    </style>
@endpush

@section('content')

    {{-- Hero --}}
    <div class="profile-hero">
        <div class="profile-avatar-wrap">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="profile-hero-info">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }} · Thành viên từ {{ $user->created_at->format('m/Y') }}</p>
            </div>
        </div>
    </div>

    @if (session('error'))
        <div style="max-width:1100px;margin:16px auto;padding:0 24px;position:relative;z-index:10">
            <div
                style="background:rgba(220,38,38,0.08);border:1px solid rgba(220,38,38,0.2);
                        border-radius:10px;padding:12px 16px;
                        color:#dc2626;font-size:0.88rem;
                        display:flex;align-items:center;gap:8px">
                <i class="fa-solid fa-triangle-exclamation"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="profile-wrap">

        {{-- ── Sidebar ── --}}
        <div class="profile-sidebar">
            <button class="sidebar-nav-item active" data-tab="info" onclick="switchTab('info')">
                <i class="fa-solid fa-user"></i> Thông tin cá nhân
            </button>
            <button class="sidebar-nav-item" data-tab="orders" onclick="switchTab('orders')">
                <i class="fa-solid fa-box"></i> Đơn hàng của tôi
                @if ($orders->total() > 0)
                    <span
                        style="margin-left:6px;background:#ff4500;color:#fff;
                                 font-size:0.72rem;padding:1px 7px;border-radius:20px">
                        {{ $orders->total() }}
                    </span>
                @endif
            </button>
            <button class="sidebar-nav-item" onclick="window.location='{{ route('home') }}'">
                <i class="fa-solid fa-store"></i> Tiếp tục mua sắm
            </button>
        </div>

        {{-- ── Content ── --}}
        <div>

            {{-- ══ TAB: Thông tin ══ --}}
            <div class="profile-card active" id="tab-info">
                <div class="profile-card-header">
                    <div class="profile-card-title">
                        <i class="fa-solid fa-user"></i> Thông tin cá nhân
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert-success-p">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group-p span2">
                            <label class="form-label-p">Họ và tên</label>
                            <input type="text" name="name" class="form-input-p" value="{{ old('name', $user->name) }}"
                                required />
                            @error('name')
                                <span style="color:#ef4444;font-size:0.78rem">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group-p">
                            <label class="form-label-p">Email</label>
                            <input type="email" class="form-input-p" value="{{ $user->email }}" readonly
                                style="opacity:0.6;cursor:not-allowed" />
                        </div>

                        <div class="form-group-p">
                            <label class="form-label-p">Số điện thoại</label>
                            <input type="text" name="phone" class="form-input-p"
                                value="{{ old('phone', $user->phone) }}" placeholder="0912 345 678" />
                            @error('phone')
                                <span style="color:#ef4444;font-size:0.78rem">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="padding: 0 24px">
                        <div
                            style="font-family:'Rajdhani',sans-serif;font-size:0.9rem;
                                    font-weight:700;color:#1a1a1a;margin-bottom:14px;
                                    border-top:1px solid #f5f4f2;padding-top:16px">
                            <i class="fa-solid fa-location-dot" style="color:#ff4500"></i>
                            Địa chỉ giao hàng
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group-p span2">
                            <label class="form-label-p">Số nhà, tên đường</label>
                            <input type="text" name="address" class="form-input-p"
                                value="{{ old('address', $user->address) }}" placeholder="VD: 123 Nguyễn Văn Linh" />
                        </div>
                        <div class="form-group-p">
                            <label class="form-label-p">Phường / Xã</label>
                            <input type="text" name="ward" class="form-input-p"
                                value="{{ old('ward', $user->ward) }}" placeholder="VD: Phường Tân Phong" />
                        </div>
                        <div class="form-group-p">
                            <label class="form-label-p">Quận / Huyện</label>
                            <input type="text" name="district" class="form-input-p"
                                value="{{ old('district', $user->district) }}" placeholder="VD: Quận 7" />
                        </div>
                        <div class="form-group-p span2">
                            <label class="form-label-p">Tỉnh / Thành phố</label>
                            <input type="text" name="province" class="form-input-p"
                                value="{{ old('province', $user->province) }}" placeholder="VD: TP. Hồ Chí Minh" />
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-save">
                            <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
                        </button>
                        @if ($user->hasAddress())
                            <span style="font-size:0.82rem;color:#22c55e;display:flex;align-items:center;gap:5px">
                                <i class="fa-solid fa-circle-check"></i> Địa chỉ đã được lưu
                            </span>
                        @else
                            <span style="font-size:0.82rem;color:#f59e0b;display:flex;align-items:center;gap:5px">
                                <i class="fa-solid fa-triangle-exclamation"></i> Chưa có địa chỉ giao hàng
                            </span>
                        @endif
                    </div>
                </form>
            </div>

            {{-- ══ TAB: Đơn hàng ══ --}}
            <div class="profile-card" id="tab-orders">
                <div class="profile-card-header">
                    <div class="profile-card-title">
                        <i class="fa-solid fa-box"></i> Đơn hàng của tôi
                    </div>
                </div>

                @if ($orders->count() > 0)
                    <div class="order-list">
                        @foreach ($orders as $order)
                            <div class="order-row"
                                onclick="window.location='{{ route('profile.order', $order->order_code) }}'">
                                <div class="order-code">{{ $order->order_code }}</div>

                                <div class="order-info-main">
                                    <div class="order-date">
                                        <i class="fa-regular fa-clock" style="font-size:0.72rem"></i>
                                        {{ $order->created_at->format('H:i — d/m/Y') }}
                                    </div>
                                    <div class="order-items-preview">
                                        {{ $order->items->first()?->product_name ?? 'Sản phẩm' }}
                                        @if ($order->items->count() > 1)
                                            <span style="color:#aaa">
                                                + {{ $order->items->count() - 1 }} sản phẩm khác
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="order-total">
                                    {{ number_format($order->total, 0, ',', '.') }}₫
                                </div>

                                <span class="order-status-badge"
                                    style="background:{{ $order->statusColor() }}20;color:{{ $order->statusColor() }}">
                                    {{ $order->statusLabel() }}
                                </span>

                                <div class="order-chevron">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($orders->hasPages())
                        <div class="order-pagination">
                            <nav>
                                {{ $orders->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif
                @else
                    <div class="order-empty">
                        <i class="fa-solid fa-box-open"></i>
                        <p>Bạn chưa có đơn hàng nào.</p>
                        <a href="{{ route('products.index') }}" class="btn-shop-now">
                            <i class="fa-solid fa-store"></i> Mua sắm ngay
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function switchTab(tab) {
            document.querySelectorAll('.profile-card').forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.sidebar-nav-item').forEach(b => b.classList.remove('active'));
            document.getElementById('tab-' + tab).classList.add('active');
            document.querySelector(`.sidebar-nav-item[data-tab="${tab}"]`).classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(location.search);
            const urlTab = urlParams.get('tab');
            const alert = urlParams.get('alert');

            if (urlTab === 'orders') {
                switchTab('orders');
            } else {
                switchTab('info');

                if (alert === 'no-address') {
                    const alertBox = document.createElement('div');
                    alertBox.innerHTML = `
                        <div style="max-width:1100px;margin:16px auto;padding:0 24px">
                            <div style="background:rgba(220,38,38,0.08);border:1px solid rgba(220,38,38,0.2);
                                        border-radius:10px;padding:12px 16px;
                                        color:#dc2626;font-size:0.88rem;
                                        display:flex;align-items:center;gap:8px">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                Vui lòng cập nhật địa chỉ giao hàng trước khi đặt hàng!
                            </div>
                        </div>`;
                    document.querySelector('.profile-wrap').insertAdjacentElement('beforebegin', alertBox
                        .firstElementChild);

                    setTimeout(() => {
                        const addressField = document.querySelector('input[name="address"]');
                        if (addressField) {
                            addressField.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            addressField.style.borderColor = '#ff4500';
                            addressField.style.boxShadow = '0 0 0 3px rgba(255,69,0,0.15)';
                            addressField.focus();
                        }
                    }, 400);
                }
            }
        });
    </script>
@endpush
