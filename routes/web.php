<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
Route::get('/donate', [DonationController::class, 'create'])->name('donate');
Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');
Route::get('/donate', function () {
    return "Donate Page Working";
});


Route::get('/join', function () {
    return view('frontend.join');
})->name('join');

Route::post('/membership-submit', [MembershipController::class, 'submit'])->name('membership.submit');

Route::get('/membership/{id}/edit', [MembershipController::class, 'edit'])->name('membership.edit');

Route::post('/membership/{id}/update', [MembershipController::class, 'update'])->name('membership.update');

Route::get('/membership/{id}/pdf', [MembershipController::class, 'generatePdf'])->name('membership.pdf');




Route::get('/', [FrontendController::class, 'index']);
Route::get('/', fn() => view('frontend.index'))->name('home');
Route::get('/contact', fn() => view('frontend.contact'))->name('contact');
Route::get('/donate', fn() => view('frontend.donate'))->name('donate');
Route::get('/join', fn() => view('frontend.join'))->name('join');
Route::get('/terms', fn() => view('frontend.terms'))->name('terms');

Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');


Route::post('/contact-submit', function (Illuminate\Http\Request $request) {
    // simple validation
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required'
    ]);

    return back()->with('success', 'Your message has been sent successfully!');
})->name('contact.submit');


Route::get('/join', function () {
    return view('frontend.join');
})->name('join');

//admin login


Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])
    ->name('dashboard');

Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');



//contact


Route::get('/', function () {
    return view('frontend.index');
})->name('home');

Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact');

Route::post('/contact-submit', [ContactController::class, 'submit'])
    ->name('contact.submit');


Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
//contact show
Route::get('/dashboard/messages', [DashboardController::class,'messages'])->name('dashboard.messages');
Route::delete('/dashboard/messages/{id}', [DashboardController::class,'deleteMessage'])->name('dashboard.messages.delete');

// Members show
Route::get('/dashboard/members', [DashboardController::class, 'members'])->name('dashboard.members');
Route::get('/dashboard/members/delete/{id}', [DashboardController::class, 'deleteMember'])->name('dashboard.members.delete');
// Donations show
Route::get('/dashboard/donors', [DashboardController::class, 'donors'])->name('dashboard.donors');
Route::get('/dashboard/donors/delete/{id}', [DashboardController::class, 'deleteDonor'])->name('dashboard.donors.delete');