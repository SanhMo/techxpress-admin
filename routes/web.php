<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;

// ====== Trang chủ =====
Route::get('/', function () {
    $featured  = \App\Models\Product::where('is_featured', true)->where('is_active', true)->latest()->take(4)->get();
    $flashSale = \App\Models\Product::where('is_flash_sale', true)->where('is_active', true)->latest()->take(4)->get();
    $newest    = \App\Models\Product::where('is_active', true)->latest()->take(4)->get();
    return view('home', compact('featured', 'flashSale', 'newest'));
})->name('home');

Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('product.show');

// ====== Auth =====
Route::middleware('guest')->group(function () {
    Route::get('/dang-ky',    [AuthController::class, 'showRegister'])->name('register');
    Route::post('/dang-ky',   [AuthController::class, 'register']);
    Route::get('/dang-nhap',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/dang-nhap', [AuthController::class, 'login']);
});

Route::post('/dang-xuat', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ====== Admin ======
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::resource('products', AdminProductController::class);
    Route::resource('orders',   AdminOrderController::class)->only(['index', 'show', 'update']);
});

// ====== Cart =======
Route::middleware('auth')->prefix('gio-hang')->name('cart.')->group(function () {
    Route::get('/',          [CartController::class, 'index'])->name('index');
    Route::post('/them',     [CartController::class, 'add'])->name('add');
    Route::patch('/{item}',  [CartController::class, 'update'])->name('update');
    Route::delete('/{item}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/',       [CartController::class, 'clear'])->name('clear');
    Route::get('/mini',      [CartController::class, 'mini'])->name('mini');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
});

// ========= Order success ======
Route::get('/dat-hang-thanh-cong/{code}', function ($code) {
    $order = \App\Models\Order::where('order_code', $code)
        ->where('user_id', auth()->id())
        ->with('items.product')
        ->firstOrFail();
    return view('order.success', compact('order'));
})->name('order.success')->middleware('auth');

// =========== Profile user ================
Route::middleware('auth')->prefix('tai-khoan')->name('profile.')->group(function () {
    Route::get('/',                  [ProfileController::class, 'index'])->name('index');
    Route::post('/cap-nhat',         [ProfileController::class, 'update'])->name('update');
    Route::post('/doi-mat-khau',     [ProfileController::class, 'changePassword'])->name('password');
    Route::get('/don-hang/{code}',   [ProfileController::class, 'orderDetail'])->name('order');
});

use App\Models\Order;

Route::get('/orders', function () {
    return Order::latest()->first();
});
