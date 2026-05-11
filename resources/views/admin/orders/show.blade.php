@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng — ' . $order->order_code)

@section('content')

    {{-- ══ HEADER ══ --}}
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">
                <i class="fa-solid fa-receipt"></i>
                {{ $order->order_code }}
            </h1>
            <p class="page-subtitle">Đặt lúc {{ $order->created_at->format('H:i — d/m/Y') }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn-secondary-admin">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:24px;align-items:start">

        {{-- ── LEFT ── --}}
        <div style="display:flex;flex-direction:column;gap:20px">

            {{-- Danh sách sản phẩm --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span><i class="fa-solid fa-box" style="color:#ff4500"></i> Sản phẩm đã đặt</span>
                </div>
                <table class="admin-table" style="margin:0">
                    <thead>
                        <tr>
                            <th style="width:56px">Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>SL</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>
                                    <div
                                        style="width:48px;height:48px;border-radius:8px;overflow:hidden;
                                        background:#f5f4f2;display:flex;align-items:center;justify-content:center">
                                        @if ($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                style="width:100%;height:100%;object-fit:cover" />
                                        @else
                                            <i class="fa-solid fa-laptop" style="color:#ddd"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight:600;color:#1a1a1a;font-size:0.88rem">
                                        {{ $item->product_name }}
                                    </div>
                                </td>
                                <td style="font-size:0.88rem;color:#555">
                                    {{ number_format($item->price, 0, ',', '.') }}₫
                                </td>
                                <td style="font-size:0.88rem;font-weight:600">
                                    × {{ $item->quantity }}
                                </td>
                                <td style="font-weight:700;color:#ff4500">
                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background:#fafaf9">
                            <td colspan="4"
                                style="text-align:right;font-weight:600;
                                               padding:14px 16px;font-size:0.9rem;color:#555">
                                Tổng cộng:
                            </td>
                            <td
                                style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;
                                   font-weight:700;color:#ff4500;padding:14px 16px">
                                {{ number_format($order->total, 0, ',', '.') }}₫
                            </td>
                        </tr>
                        @if ($order->deposit > 0)
                            <tr style="background:#fffbeb">
                                <td colspan="4"
                                    style="text-align:right;font-weight:600;
                                               padding:10px 16px;font-size:0.85rem;color:#92400e">
                                    Tiền cọc (5%):
                                </td>
                                <td style="font-weight:700;color:#d97706;padding:10px 16px">
                                    {{ number_format($order->deposit, 0, ',', '.') }}₫
                                </td>
                            </tr>
                            <tr style="background:#fffbeb">
                                <td colspan="4"
                                    style="text-align:right;font-weight:600;
                                               padding:10px 16px;font-size:0.85rem;color:#92400e">
                                    Còn lại khi nhận:
                                </td>
                                <td style="font-weight:700;color:#d97706;padding:10px 16px">
                                    {{ number_format($order->total - $order->deposit, 0, ',', '.') }}₫
                                </td>
                            </tr>
                        @endif
                    </tfoot>
                </table>
            </div>

            {{-- Thông tin khách hàng --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span><i class="fa-solid fa-user" style="color:#ff4500"></i> Thông tin khách hàng</span>
                </div>
                <div style="padding:20px;display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div>
                        <div style="font-size:0.78rem;color:#aaa;margin-bottom:4px">Họ tên</div>
                        <div style="font-weight:600;color:#1a1a1a">{{ $order->user->name }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.78rem;color:#aaa;margin-bottom:4px">Email</div>
                        <div style="font-weight:600;color:#1a1a1a">{{ $order->user->email }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.78rem;color:#aaa;margin-bottom:4px">Phương thức</div>
                        <div style="font-weight:600;color:#1a1a1a">{{ $order->paymentLabel() }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.78rem;color:#aaa;margin-bottom:4px">Ngày đặt</div>
                        <div style="font-weight:600;color:#1a1a1a">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <div>
                        <div style="font-size:0.78rem;color:#aaa">Số điện thoại</div>
                        <div style="font-weight:600">{{ $order->receiver_phone ?? '—' }}</div>
                    </div>
                    <div style="grid-column:span 2">
                        <div style="font-size:0.78rem;color:#aaa">Địa chỉ giao hàng</div>
                        <div style="font-weight:600">{{ $order->receiver_address ?? '—' }}</div>
                    </div>
                    @if ($order->note)
                        <div style="grid-column:1/-1">
                            <div style="font-size:0.78rem;color:#aaa;margin-bottom:4px">Ghi chú</div>
                            <div
                                style="font-size:0.88rem;color:#555;background:#f5f4f2;
                                padding:10px 12px;border-radius:8px">
                                {{ $order->note }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── RIGHT: Cập nhật trạng thái ── --}}
        <div style="display:flex;flex-direction:column;gap:16px">

            {{-- Trạng thái hiện tại --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span><i class="fa-solid fa-timeline" style="color:#ff4500"></i> Trạng thái đơn hàng</span>
                </div>
                <div style="padding:20px">

                    {{-- Badge trạng thái --}}
                    <div style="display:flex;justify-content:center;margin-bottom:20px">
                        <span
                            style="display:inline-flex;align-items:center;gap:8px;
                                 font-size:1rem;font-weight:700;padding:8px 20px;
                                 border-radius:20px;
                                 background:{{ $order->statusColor() }}20;
                                 color:{{ $order->statusColor() }}">
                            <span
                                style="width:8px;height:8px;border-radius:50%;
                                     background:{{ $order->statusColor() }}"></span>
                            {{ $order->statusLabel() }}
                        </span>
                    </div>

                    {{-- Timeline --}}
                    @php
                        $steps = [
                            ['key' => 'pending', 'label' => 'Chờ xác nhận', 'icon' => 'fa-clock'],
                            ['key' => 'confirmed', 'label' => 'Đã xác nhận', 'icon' => 'fa-check'],
                            ['key' => 'shipping', 'label' => 'Đang giao', 'icon' => 'fa-truck'],
                            ['key' => 'delivered', 'label' => 'Đã giao', 'icon' => 'fa-circle-check'],
                        ];
                        $statusOrder = [
                            'pending' => 0,
                            'confirmed' => 1,
                            'shipping' => 2,
                            'delivered' => 3,
                            'cancelled' => 4,
                        ];
                        $currentIdx = $statusOrder[$order->status] ?? 0;
                    @endphp

                    <div style="display:flex;flex-direction:column;gap:0;margin-bottom:20px">
                        @foreach ($steps as $i => $step)
                            @php $done = $statusOrder[$step['key']] <= $currentIdx && $order->status !== 'cancelled'; @endphp
                            <div
                                style="display:flex;align-items:center;gap:12px;padding:8px 0;
                                position:relative">
                                <div
                                    style="width:32px;height:32px;border-radius:50%;flex-shrink:0;
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:0.75rem;
                                    background:{{ $done ? '#ff4500' : '#f5f4f2' }};
                                    color:{{ $done ? '#fff' : '#ccc' }}">
                                    <i class="fa-solid {{ $step['icon'] }}"></i>
                                </div>
                                <span
                                    style="font-size:0.85rem;
                                     color:{{ $done ? '#1a1a1a' : '#aaa' }};
                                     font-weight:{{ $done ? '600' : '400' }}">
                                    {{ $step['label'] }}
                                </span>
                            </div>
                            @if ($i < count($steps) - 1)
                                <div
                                    style="width:2px;height:16px;margin-left:15px;
                                background:{{ $done ? '#ff4500' : '#e8e8e8' }}">
                                </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- Form cập nhật --}}
                    @if ($order->status !== 'delivered' && $order->status !== 'cancelled')
                        <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                            @csrf @method('PATCH')
                            <select name="status"
                                style="width:100%;background:#f5f4f2;border:1px solid #e8e8e8;
                                                  border-radius:8px;padding:9px 12px;font-size:0.88rem;
                                                  font-family:'Be Vietnam Pro',sans-serif;outline:none;
                                                  margin-bottom:10px">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận
                                </option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận
                                </option>
                                <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao
                                </option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Huỷ đơn
                                </option>
                            </select>
                            <button type="submit" class="btn-primary-admin" style="width:100%;justify-content:center">
                                <i class="fa-solid fa-floppy-disk"></i> Cập nhật
                            </button>
                        </form>
                    @else
                        <div style="text-align:center;font-size:0.84rem;color:#aaa;padding:8px">
                            Đơn hàng đã hoàn tất
                        </div>
                    @endif
                </div>
            </div>

            {{-- Thanh toán --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span><i class="fa-solid fa-credit-card" style="color:#ff4500"></i> Thanh toán</span>
                </div>
                <div style="padding:16px 20px;display:flex;flex-direction:column;gap:10px">
                    <div style="display:flex;justify-content:space-between;font-size:0.88rem">
                        <span style="color:#888">Phương thức</span>
                        <span style="font-weight:600">{{ $order->paymentLabel() }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:0.88rem">
                        <span style="color:#888">Trạng thái</span>
                        <span style="font-weight:600;color:{{ $order->payment_status == 'paid' ? '#22c55e' : '#f59e0b' }}">
                            {{ $order->payment_status == 'paid'
                                ? 'Đã thanh toán'
                                : ($order->payment_status == 'deposited'
                                    ? 'Đã cọc'
                                    : 'Chưa thanh toán') }}
                        </span>
                    </div>
                    @if ($order->deposit > 0)
                        <div style="display:flex;justify-content:space-between;font-size:0.88rem">
                            <span style="color:#888">Đã cọc</span>
                            <span style="font-weight:600;color:#d97706">
                                {{ number_format($order->deposit, 0, ',', '.') }}₫
                            </span>
                        </div>
                        <div style="display:flex;justify-content:space-between;font-size:0.88rem">
                            <span style="color:#888">Còn lại</span>
                            <span style="font-weight:600;color:#ff4500">
                                {{ number_format($order->total - $order->deposit, 0, ',', '.') }}₫
                            </span>
                        </div>
                    @endif
                    <div style="height:1px;background:#f5f4f2;margin:4px 0"></div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="font-weight:700;color:#1a1a1a">Tổng đơn</span>
                        <span
                            style="font-family:'Rajdhani',sans-serif;font-size:1.15rem;
                                 font-weight:700;color:#ff4500">
                            {{ number_format($order->total, 0, ',', '.') }}₫
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .admin-card {
            background: #fff;
            border: 1px solid #f0eeeb;
            border-radius: 14px;
            overflow: hidden;
        }

        .admin-card-header {
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

        .btn-secondary-admin {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #f5f4f2;
            color: #555;
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            padding: 9px 18px;
            font-size: 0.88rem;
            font-weight: 600;
            font-family: 'Be Vietnam Pro', sans-serif;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-secondary-admin:hover {
            border-color: #ff4500;
            color: #ff4500;
        }
    </style>

@endsection
