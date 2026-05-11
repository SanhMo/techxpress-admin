<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_code',
        'total',
        'deposit',
        'payment_method',
        'payment_status',
        'status',
        'note',
        'receiver_name',
        'receiver_phone',
        'receiver_address',
    ];

    protected $table = 'orders';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Label trạng thái
    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'   => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'shipping'  => 'Đang giao',
            'delivered' => 'Đã giao',
            'cancelled' => 'Đã huỷ',
            default     => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pending'   => '#f59e0b',
            'confirmed' => '#3b82f6',
            'shipping'  => '#8b5cf6',
            'delivered' => '#22c55e',
            'cancelled' => '#ef4444',
            default     => '#aaa',
        };
    }

    public function paymentLabel(): string
    {
        return match ($this->payment_method) {
            'cod'              => 'COD',
            'bank_deposit'     => 'Chuyển khoản (cọc)',
            'ewallet_deposit'  => 'Ví điện tử (cọc)',
            default            => $this->payment_method,
        };
    }
}
