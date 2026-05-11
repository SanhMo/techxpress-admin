<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('status')) {
            match ($request->status) {
                'active'   => $query->where('is_active', true),
                'inactive' => $query->where('is_active', false),
                'featured' => $query->where('is_featured', true),
                'flash'    => $query->where('is_flash_sale', true),
                default    => null
            };
        }

        $products = $query->paginate(15)->withQueryString();

        $statsTotal    = Product::count();
        $statsActive   = Product::where('is_active', true)->count();
        $statsFeatured = Product::where('is_featured', true)->count();
        $statsFlash    = Product::where('is_flash_sale', true)->count();

        return view('admin.products.index', compact(
            'products',
            'statsTotal',
            'statsActive',
            'statsFeatured',
            'statsFlash'
        ));
    }

    public function create()
    {
        return view('admin.products.form');
    }

    // ══════════════════════════════════════
    public function store(Request $request)
    // ══════════════════════════════════════
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|string',
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except(['image', 'images', 'specs_key', 'specs_val', '_token']);
        $data['slug'] = Str::slug($request->name);

        // ── Xử lý specs ──────────────────
        $specs = [];
        if ($request->specs_key) {
            foreach ($request->specs_key as $i => $key) {
                if ($key) $specs[$key] = $request->specs_val[$i] ?? '';
            }
        }
        $data['specs'] = $specs ?: null;
        // ─────────────────────────────────

        // Upload ảnh chính
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Upload ảnh gallery
        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $img) {
                $paths[] = $img->store('products', 'public');
            }
            $data['images'] = $paths;
        }

        // Checkbox (nếu không check = false)
        $data['is_active']     = $request->has('is_active');
        $data['is_featured']   = $request->has('is_featured');
        $data['is_flash_sale'] = $request->has('is_flash_sale');

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', compact('product'));
    }

    // ══════════════════════════════════════
    public function update(Request $request, Product $product)
    // ══════════════════════════════════════
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|string',
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except(['image', 'images', 'specs_key', 'specs_val', '_token', '_method']);
        $data['slug'] = Str::slug($request->name);

        // ── Xử lý specs ──────────────────
        $specs = [];
        if ($request->specs_key) {
            foreach ($request->specs_key as $i => $key) {
                if ($key) $specs[$key] = $request->specs_val[$i] ?? '';
            }
        }
        $data['specs'] = $specs ?: null;
        // ─────────────────────────────────

        // Đổi ảnh chính
        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Đổi ảnh gallery
        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $img) {
                $paths[] = $img->store('products', 'public');
            }
            $data['images'] = $paths;
        }

        $data['is_active']     = $request->has('is_active');
        $data['is_featured']   = $request->has('is_featured');
        $data['is_flash_sale'] = $request->has('is_flash_sale');

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật thành công!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Đã xoá sản phẩm!');
    }
}
