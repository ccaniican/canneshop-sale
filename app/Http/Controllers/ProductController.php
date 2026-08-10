<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        // Search Keyword
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('color', 'like', "%{$keyword}%");
            });
        }

        // Category Filter
        if ($request->filled('category') && $request->category !== 'all') {
            $categorySlug = $request->category;
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Size Filter
        if ($request->filled('size') && $request->size !== 'all') {
            $size = $request->size;
            $query->whereJsonContains('sizes', $size);
        }

        // Price Sort
        if ($request->filled('sort')) {
            if ($request->sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort === 'rating') {
                $query->orderBy('rating', 'desc');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->get();
        $categories = Category::withCount('products')->get();
        $featuredProducts = Product::where('is_featured', true)->take(4)->get();

        return view('home.index', compact('products', 'categories', 'featuredProducts'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return response()->json([
            'status' => 'success',
            'product' => $product,
            'related' => $relatedProducts
        ]);
    }
}
