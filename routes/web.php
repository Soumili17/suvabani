<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\Auth\LoginController;
// Frontend pages
Route::get('/', [FrontPageController::class, 'index'])->name('home');
Route::get('/contact', function () { return view('frontend.contact'); });
Route::get('/join', function () { return view('frontend.join'); });
Route::get('/terms', function () { return view('frontend.terms'); });

// Donation Routes
Route::get('/donate', [DonationController::class, 'create'])->name('donate.form');
Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');
Route::get('/donation-receipt/{id}', [DonationController::class, 'receipt'])->name('donate.receipt');

// Invoice PDF download
Route::get('/invoice/{id}/download', [InvoiceController::class, 'download'])->name('invoice.download');

// Admin Routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Members
    Route::get('/members', [MembershipController::class, 'index'])->name('admin.members');
    Route::get('/members/create', [MembershipController::class, 'create'])->name('admin.members.create');
    Route::post('/members', [MembershipController::class, 'store'])->name('admin.members.store');
    Route::get('/members/{id}/edit', [MembershipController::class, 'edit'])->name('admin.members.edit');
    Route::put('/members/{id}', [MembershipController::class, 'update'])->name('admin.members.update');
    Route::delete('/members/{id}', [MembershipController::class, 'destroy'])->name('admin.members.destroy');

    // Invoices
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('admin.invoices');
});


// Admin login form
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');

// Admin login POST
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// Admin logout
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');
