<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('home')->with('warning', 'Keranjang Anda masih kosong!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = session()->get('coupon', null);
        $discount = 0;
        if ($coupon) {
            if ($coupon['type'] === 'percent') {
                $discount = ($subtotal * $coupon['value']) / 100;
            } else {
                $discount = $coupon['value'];
            }
        }

        $shippingCost = 15000;
        $grandTotal = max(0, $subtotal - $discount + $shippingCost);

        return view('checkout.index', compact('cart', 'subtotal', 'discount', 'coupon', 'shippingCost', 'grandTotal'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'courier' => 'required|string',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja kosong');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = session()->get('coupon', null);
        $discountAmount = 0;
        if ($coupon) {
            if ($coupon['type'] === 'percent') {
                $discountAmount = ($subtotal * $coupon['value']) / 100;
            } else {
                $discountAmount = $coupon['value'];
            }
        }

        $shippingCost = 15000;
        if ($request->courier === 'JNE Express (Next Day)') {
            $shippingCost = 25000;
        } elseif ($request->courier === 'SiCepat Cargo') {
            $shippingCost = 18000;
        }

        $grandTotal = max(0, $subtotal - $discountAmount + $shippingCost);

        $orderNumber = 'CNS-' . strtoupper(Str::random(8));

        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'courier' => $request->courier,
            'payment_method' => $request->payment_method,
            'payment_status' => 'Paid',
            'order_status' => 'Diproses',
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'shipping_cost' => $shippingCost,
            'grand_total' => $grandTotal,
            'notes' => $request->notes,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'size' => $item['size'],
                'color' => $item['color'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            // Decrement stock
            $product = Product::find($item['product_id']);
            if ($product && $product->stock >= $item['quantity']) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        // Clear session cart & coupon
        session()->forget('cart');
        session()->forget('coupon');

        return redirect()->route('checkout.success', ['order_number' => $orderNumber]);
    }

    public function success($orderNumber)
    {
        $order = Order::with('items.product')->where('order_number', $orderNumber)->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}
