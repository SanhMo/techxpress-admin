<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('products.detail', compact('product'));
    }

    public function index(Request $request)
    {
        $defaultCategories = [
            'Laptop Gaming',
            'Laptop Văn phòng',
            'PC - Máy tính bộ',
            'Điện thoại',
            'Máy tính bảng',
            'Màn hình',
            'Phụ kiện',
        ];

        $query = Product::where('is_active', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        // ✅ Merge DB + mặc định
        $dbCategories   = Product::where('is_active', true)->distinct()->pluck('category')->toArray();
        $categories     = collect(array_unique(array_merge($defaultCategories, $dbCategories)));

        $totalCount     = Product::where('is_active', true)->count();
        $categoryCounts = Product::where('is_active', true)
            ->groupBy('category')
            ->selectRaw('category, count(*) as total')
            ->pluck('total', 'category');

        return view('products.index', compact('products', 'categories', 'totalCount', 'categoryCounts'));
    }
}
