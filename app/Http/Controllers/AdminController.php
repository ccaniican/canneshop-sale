<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalRevenue = Order::where('payment_status', 'Paid')->sum('grand_total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 10)->count();

        $recentOrders = Order::with('items')->latest()->take(6)->get();
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();
        $allUsers = User::latest()->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalProducts', 'lowStockProducts',
            'recentOrders', 'products', 'categories', 'allUsers'
        ));
    }

    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sizes' => 'required|array',
            'color' => 'required|string|max:100',
            'description' => 'required|string',
            'badge' => 'nullable|string|max:50',
            'image_url' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dashboard')
                ->withErrors($validator, 'productStore')
                ->withInput()
                ->with('error', 'Gagal menambah produk: ' . $validator->errors()->first());
        }

        $imagePath = '/images/products/oversized_hoodie.jpg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $imagePath = '/images/products/' . $filename;
        } elseif ($request->filled('image_url')) {
            $parsedUrl = parse_url($request->image_url, PHP_URL_PATH);
            if ($parsedUrl && strpos($parsedUrl, '/images/products/') !== false) {
                $imagePath = substr($parsedUrl, strpos($parsedUrl, '/images/products/'));
            } else {
                $imagePath = $request->image_url;
            }
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'sizes' => $request->sizes,
            'color' => $request->color,
            'description' => $request->description,
            'badge' => $request->badge,
            'image' => $imagePath,
            'rating' => 5.0,
            'review_count' => 0,
            'is_featured' => $request->has('is_featured'),
            'is_active' => true,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Produk apparel berhasil ditambahkan!');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sizes' => 'required|array',
            'color' => 'required|string|max:100',
            'description' => 'required|string',
            'badge' => 'nullable|string|max:50',
            'image_url' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dashboard')
                ->withErrors($validator, 'productUpdate')
                ->withInput()
                ->with('error', 'Gagal memperbarui produk: ' . $validator->errors()->first());
        }

        $imagePath = $product->getRawOriginal('image') ?: '/images/products/oversized_hoodie.jpg';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $imagePath = '/images/products/' . $filename;
        } elseif ($request->filled('image_url')) {
            $parsedUrl = parse_url($request->image_url, PHP_URL_PATH);
            if ($parsedUrl && strpos($parsedUrl, '/images/products/') !== false) {
                $imagePath = substr($parsedUrl, strpos($parsedUrl, '/images/products/'));
            } else {
                $imagePath = $request->image_url;
            }
        }

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'sizes' => $request->sizes,
            'color' => $request->color,
            'description' => $request->description,
            'badge' => $request->badge,
            'image' => $imagePath,
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Produk apparel "' . $request->name . '" berhasil diperbarui!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Produk apparel berhasil dihapus!');
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|string|in:Pending,Diproses,Dikirim,Selesai,Dibatalkan',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['order_status' => $request->order_status]);

        return redirect()->route('admin.dashboard')->with('success', 'Status pesanan ' . $order->order_number . ' diperbarui menjadi ' . $request->order_status);
    }

    // User CRUD Methods
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dashboard')
                ->withErrors($validator, 'userStore')
                ->withInput()
                ->with('addUserError', true)
                ->with('error', 'Gagal menambah user: ' . $validator->errors()->first());
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Pengguna ' . $request->name . ' (' . strtoupper($request->role) . ') berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dashboard')
                ->withErrors($validator, 'userUpdate')
                ->withInput()
                ->with('error', 'Gagal memperbarui user: ' . $validator->errors()->first());
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Data pengguna ' . $user->name . ' berhasil diperbarui!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if (Auth::check() && Auth::id() === $user->id) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Pengguna berhasil dihapus!');
    }
}
