<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminRegisterController extends Controller
{
    // Tampilkan form register
    public function showRegisterForm()
    {
        // PERBAIKAN DI SINI — path view disesuaikan
        return view('auth.admin.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'organization' => $request->organization,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Auto login setelah register (opsional, bisa dihapus kalau mau)
        Auth::guard('admin')->login($admin);

        // Redirect ke halaman login / dashboard admin
        return redirect()->route('admin.login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
