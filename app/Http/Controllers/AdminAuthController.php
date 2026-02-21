<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('layouts.admin_login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $admin = Admin::where('username', $request->username)
                      ->where('password', $request->password)
                      ->first();

        if ($admin) {
            session(['admin_auth' => true]);
            return redirect('/dashboard');
        }

        return back()->with('error', 'Invalid username or password');
    }

    public function dashboard()
    {
        return view('layouts.dashboard');
    }

    public function logout()
    {
        session()->forget('admin_auth');
        return redirect('/admin/login');
    }
}