<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;

class ProfileController extends Controller
{
    // ── Trang profile ──
    public function index()
    {
        $user   = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with('items')
            ->latest()
            ->paginate(5);
        return view('profile.index', compact('user', 'orders'));
    }

    // ── Cập nhật thông tin ──
    public function update(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:15',
            'address'  => 'nullable|string|max:255',
            'ward'     => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
        ]);

        Auth::user()->update($request->only([
            'name',
            'phone',
            'address',
            'ward',
            'district',
            'province'
        ]));

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    // ── Đổi mật khẩu ──
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'password.min'              => 'Mật khẩu mới tối thiểu 6 ký tự.',
            'password.confirmed'        => 'Xác nhận mật khẩu không khớp.',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    // ── Chi tiết đơn hàng ──
    public function orderDetail($code)
    {
        $order = Order::where('order_code', $code)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();
        return view('profile.order-detail', compact('order'));
    }
}
