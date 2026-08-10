<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $myOrders = Order::with('items')
            ->where('customer_email', $user->email)
            ->latest()
            ->get();

        $totalSpent = $myOrders->where('payment_status', 'Paid')->sum('grand_total');
        $totalOrdersCount = $myOrders->count();
        $activeOrdersCount = $myOrders->whereIn('order_status', ['Pending', 'Diproses', 'Dikirim'])->count();

        return view('user.dashboard', compact('user', 'myOrders', 'totalSpent', 'totalOrdersCount', 'activeOrdersCount'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Password Anda berhasil diubah!');
    }
}
