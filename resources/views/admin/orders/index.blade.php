@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')

    {{-- ══ PAGE HEADER ══ --}}
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title"><i class="fa-solid fa-receipt"></i> Đơn hàng</h1>
            <p class="page-subtitle">Quản lý toàn bộ đơn hàng của cửa hàng</p>
        </div>
    </div>

    {{-- ══ STATS ══ --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff0ec;color:#ff4500">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-num">{{ $statsTotal }}</div>
                <div class="stat-label">Tổng đơn</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff8e1;color:#f59e0b">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-info">
                <div class="stat-num">{{ $statsPending }}</div>
                <div class="stat-label">Chờ xác nhận</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ede9fe;color:#8b5cf6">
                <i class="fa-solid fa-truck"></i>
            </div>
            <div class="stat-info">
                <div class="stat-num">{{ $statsShipping }}</div>
                <div class="stat-label">Đang giao</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f5e9;color:#22c55e">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-num">{{ $statsDelivered }}</div>
                <div class="stat-label">Đã giao</div>
            </div>
        </div>
    </div>

    {{-- ══ FILTER ══ --}}
    <div class="table-toolbar">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="toolbar-search">
            <div class="search-field">
                <i class="fa-solid fa-search"></i>
                <input type="text" name="search" placeholder="Mã đơn, tên khách..." value="{{ request('search') }}" />
            </div>
            <select name="status" class="filter-select">
                <option value="">Tất cả trạng thái</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Đang giao</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã huỷ</option>
            </select>
            <select name="payment" class="filter-select">
                <option value="">Tất cả thanh toán</option>
                <option value="cod" {{ request('payment') == 'cod' ? 'selected' : '' }}>COD</option>
                <option value="bank_deposit" {{ request('payment') == 'bank_deposit' ? 'selected' : '' }}>Chuyển khoản
                </option>
                <option value="ewallet_deposit" {{ request('payment') == 'ewallet_deposit' ? 'selected' : '' }}>Ví điện tử
                </option>
            </select>
            <button type="submit" class="btn-filter">
                <i class="fa-solid fa-filter"></i> Lọc
            </button>
            @if (request()->hasAny(['search', 'status', 'payment']))
                <a href="{{ route('admin.orders.index') }}" class="btn-clear">
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
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Sản phẩm</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th style="width:100px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        {{-- Mã đơn --}}
                        <td>
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-weight:700;
                                 color:#ff4500;font-size:0.95rem">
                                {{ $order->order_code }}
                            </span>
                        </td>

                        {{-- Khách hàng --}}
                        <td>
                            <div style="font-weight:600;color:#1a1a1a;font-size:0.88rem">
                                {{ $order->user->name }}
                            </div>
                            <div style="font-size:0.78rem;color:#aaa">{{ $order->user->email }}</div>
                        </td>

                        {{-- Số SP --}}
                        <td>
                            <span style="font-size:0.88rem;color:#555">
                                {{ $order->items->count() }} sản phẩm
                            </span>
                        </td>

                        {{-- Tổng tiền --}}
                        <td>
                            <div style="font-weight:700;color:#1a1a1a;font-size:0.92rem">
                                {{ number_format($order->total, 0, ',', '.') }}₫
                            </div>
                            @if ($order->deposit > 0)
                                <div style="font-size:0.75rem;color:#f59e0b">
                                    Cọc: {{ number_format($order->deposit, 0, ',', '.') }}₫
                                </div>
                            @endif
                        </td>

                        {{-- Thanh toán --}}
                        <td>
                            <span
                                style="font-size:0.82rem;background:#f5f4f2;
                                 padding:3px 10px;border-radius:20px;color:#555">
                                {{ $order->paymentLabel() }}
                            </span>
                        </td>

                        {{-- Trạng thái --}}
                        <td>
                            <span
                                style="display:inline-flex;align-items:center;gap:5px;
                                 font-size:0.82rem;font-weight:600;padding:4px 10px;
                                 border-radius:20px;
                                 background:{{ $order->statusColor() }}20;
                                 color:{{ $order->statusColor() }}">
                                <span
                                    style="width:6px;height:6px;border-radius:50%;
                                     background:{{ $order->statusColor() }};
                                     display:inline-block"></span>
                                {{ $order->statusLabel() }}
                            </span>
                        </td>

                        {{-- Ngày đặt --}}
                        <td style="font-size:0.82rem;color:#888">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>

                        {{-- Thao tác --}}
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.orders.show', $order) }}" class="action-btn btn-view"
                                    title="Xem chi tiết">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fa-solid fa-receipt"></i>
                            <p>Chưa có đơn hàng nào.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($orders->hasPages())
        <div class="pagination-wrap">
            {{ $orders->withQueryString()->links() }}
        </div>
    @endif

@endsection
