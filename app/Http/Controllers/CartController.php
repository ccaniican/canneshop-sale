<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $coupon = session()->get('coupon', null);
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        if ($coupon) {
            if ($coupon['type'] === 'percent') {
                $discount = ($subtotal * $coupon['value']) / 100;
            } else {
                $discount = $coupon['value'];
            }
        }

        $shipping = $subtotal > 0 ? 15000 : 0;
        $grandTotal = max(0, $subtotal - $discount + $shipping);

        return response()->json([
            'cart' => array_values($cart),
            'subtotal' => $subtotal,
            'formatted_subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
            'discount' => $discount,
            'formatted_discount' => 'Rp ' . number_format($discount, 0, ',', '.'),
            'coupon' => $coupon,
            'shipping' => $shipping,
            'formatted_shipping' => 'Rp ' . number_format($shipping, 0, ',', '.'),
            'grand_total' => $grandTotal,
            'formatted_grand_total' => 'Rp ' . number_format($grandTotal, 0, ',', '.'),
            'total_items' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $size = $request->size ?: ($product->sizes[0] ?? 'M');
        $cartKey = $product->id . '-' . $size;

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $effectivePrice = $product->discount_price ?: $product->price;
            $cart[$cartKey] = [
                'key' => $cartKey,
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $effectivePrice,
                'formatted_price' => 'Rp ' . number_format($effectivePrice, 0, ',', '.'),
                'quantity' => $request->quantity,
                'size' => $size,
                'color' => $product->color,
                'image' => $product->image,
                'category' => $product->category ? $product->category->name : 'Apparel',
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->key])) {
            $cart[$request->key]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['status' => 'success', 'message' => 'Jumlah keranjang diperbarui']);
        }

        return response()->json(['status' => 'error', 'message' => 'Item tidak ditemukan'], 440);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->key])) {
            unset($cart[$request->key]);
            session()->put('cart', $cart);
        }

        return response()->json(['status' => 'success', 'message' => 'Item berhasil dihapus dari keranjang']);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->code))
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return response()->json(['status' => 'error', 'message' => 'Kode kupon tidak valid atau sudah kedaluwarsa!'], 422);
        }

        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        if ($subtotal < $coupon->min_spend) {
            return response()->json([
                'status' => 'error',
                'message' => 'Minimal belanja untuk kupon ini adalah Rp ' . number_format($coupon->min_spend, 0, ',', '.')
            ], 422);
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->discount_type,
            'value' => $coupon->discount_value,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Kupon ' . $coupon->code . ' berhasil digunakan!'
        ]);
    }
}
