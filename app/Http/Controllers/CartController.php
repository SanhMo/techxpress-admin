<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ── Trang giỏ hàng ──
    public function index()
    {
        $items = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

        return view('cart.index', compact('items', 'total'));
    }

    // ── Thêm vào giỏ ──
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'integer|min:1|max:99',
        ]);

        $item = CartItem::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($item) {
            // Đã có → cộng thêm số lượng
            $item->increment('quantity', $request->quantity ?? 1);
        } else {
            // Chưa có → tạo mới
            CartItem::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity ?? 1,
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'count'   => Auth::user()->cartCount(),
                'message' => 'Đã thêm vào giỏ hàng!',
            ]);
        }

        return back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    // ── Cập nhật số lượng ──
    public function update(Request $request, CartItem $item)
    {
        abort_if($item->user_id !== Auth::id(), 403);

        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $item->update(['quantity' => $request->quantity]);

        if ($request->ajax()) {
            $subtotal = $item->product->price * $item->quantity;
            $total = CartItem::with('product')
                ->where('user_id', Auth::id())
                ->get()
                ->sum(fn($i) => $i->product->price * $i->quantity);
            return response()->json([
                'success'  => true,
                'subtotal' => number_format($subtotal, 0, ',', '.'),
                'total'    => number_format($total, 0, ',', '.'),
                'count'    => Auth::user()->cartCount(),
            ]);
        }

        return back();
    }

    // ── Xoá 1 item ──
    public function remove(CartItem $item)
    {
        abort_if($item->user_id !== Auth::id(), 403);
        $item->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'count'   => Auth::user()->cartCount(),
            ]);
        }

        return back()->with('success', 'Đã xoá khỏi giỏ hàng!');
    }

    // ── Xoá toàn bộ ──
    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Đã xoá giỏ hàng!');
    }

    // ── Mini cart data (AJAX) ──
    public function mini()
    {
        $items = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        $total = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->sum(fn($i) => $i->product->price * $i->quantity);

        $count = Auth::user()->cartCount();

        return response()->json(compact('items', 'total', 'count'));
    }

    public function checkout(Request $request)
    {
        $user  = Auth::user();
        $items = CartItem::with('product')->where('user_id', $user->id)->get();

        if ($items->isEmpty()) return back()->with('error', 'Giỏ hàng trống!');

        if (!$user->hasAddress()) {
            session()->flash('error', 'Vui lòng cập nhật địa chỉ giao hàng trước khi đặt hàng!');
            session()->flash('open_tab', 'info');
            return redirect()->route('profile.index');
        }

        // if (!$user->hasAddress()) {
        //     return redirect()->route('profile.index', ['tab' => 'info', 'alert' => 'no-address']);
        // }

        $total   = $items->sum(fn($i) => $i->product->price * $i->quantity);
        $method  = $request->payment ?? 'cod';
        $deposit = in_array($method, ['bank_deposit', 'ewallet_deposit']) ? round($total * 0.05) : 0;

        $orderCode = 'TX-' . date('Ymd') . '-' . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);

        $order = Order::create([
            'user_id'          => $user->id,
            'order_code'       => $orderCode,
            'total'            => $total,
            'deposit'          => $deposit,
            'payment_method'   => $method,
            'payment_status'   => 'pending',
            'status'           => 'pending',
            'note'             => $request->note,
            // ── Địa chỉ giao hàng lấy từ profile ──
            'receiver_name'    => $user->name,
            'receiver_phone'   => $user->phone,
            'receiver_address' => $user->fullAddress(),
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item->product_id,
                'product_name' => $item->product->name,
                'price'        => $item->product->price,
                'quantity'     => $item->quantity,
            ]);
        }

        CartItem::where('user_id', $user->id)->delete();

        return redirect()->route('order.success', $order->order_code);
    }
}
