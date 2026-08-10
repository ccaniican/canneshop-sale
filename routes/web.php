<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes - CanneShop Apparel
|--------------------------------------------------------------------------
*/

// Authentication Routes (Login, Register, Logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Storefront Routes
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Cart Ajax Routes
Route::get('/cart-data', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');

// Customer / User Dashboard Routes (Requires Auth)
Route::prefix('my-account')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/password', [UserController::class, 'updatePassword'])->name('user.password.update');
});

// Protected Admin Panel Routes (Requires Role = Admin)
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Product CRUD Routes
    Route::post('/product/store', [AdminController::class, 'storeProduct'])->name('admin.product.store');
    Route::put('/product/{id}/update', [AdminController::class, 'updateProduct'])->name('admin.product.update');
    Route::delete('/product/{id}/delete', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');
    
    // Order Status Routes
    Route::post('/order/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.order.status');
    
    // User Management CRUD Routes
    Route::post('/user/store', [AdminController::class, 'storeUser'])->name('admin.user.store');
    Route::put('/user/{id}/update', [AdminController::class, 'updateUser'])->name('admin.user.update');
    Route::delete('/user/{id}/delete', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
});
