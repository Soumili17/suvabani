<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use \Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    

    public function register(Request $request)
    {
        // print_r($request->all());die;
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        $admin = Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Admin registered successfully',
            'data' => $admin
        ], 201);
    }
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

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_auth' => true, 'admin_id' => $admin->id]);
            return redirect('/dashboard');
        }

        return back()->with('error', 'Invalid username or password');
    }

    public function dashboard()
    {
        if (!session('admin_auth')) {
            return redirect('/admin/login');
        }

        return view('layouts.dashboard');
    }

    public function logout()
    {
        session()->forget('admin_auth');
        return redirect('/admin/login');
    }
}