<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items'])->latest();

        if ($request->filled('search')) {
            $query->where('order_code', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment')) {
            $query->where('payment_method', $request->payment);
        }

        $orders = $query->paginate(15)->withQueryString();

        // Stats
        $statsTotal     = Order::count();
        $statsPending   = Order::where('status', 'pending')->count();
        $statsShipping  = Order::where('status', 'shipping')->count();
        $statsDelivered = Order::where('status', 'delivered')->count();

        return view('admin.orders.index', compact(
            'orders',
            'statsTotal',
            'statsPending',
            'statsShipping',
            'statsDelivered'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $data = ['status' => $request->status];
        if ($request->status === 'delivered') {
            $data['payment_status'] = 'paid';
        }
        $order->update($data);
        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
