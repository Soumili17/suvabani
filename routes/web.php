<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VolunteerController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::view('/join', 'frontend.join')->name('join');
Route::view('/terms', 'frontend.terms')->name('terms');
Route::view('/member-search', 'frontend.member_search')->name('member.search.page');

/*
|--------------------------------------------------------------------------
| CONTACT
|--------------------------------------------------------------------------
*/

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| DONATION
|--------------------------------------------------------------------------
*/

Route::get('/donate', [DonationController::class, 'create'])->name('donate');
Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');
Route::post('/create-order', [DonationController::class, 'createOrder']);

/*
|--------------------------------------------------------------------------
| MEMBERSHIP (USER)
|--------------------------------------------------------------------------
*/

Route::post('/membership/submit', [MembershipController::class, 'submit'])->name('membership.submit');

Route::post('/create-membership-subscription', [MembershipController::class, 'createSubscription']);

Route::post('/membership/search', [MembershipController::class, 'searchMember'])->name('membership.search');

Route::get('/membership/download/{id}', [MembershipController::class, 'downloadCard'])->name('membership.download');

/*
|--------------------------------------------------------------------------
| RAZORPAY WEBHOOK
|--------------------------------------------------------------------------
*/

Route::post('/razorpay/webhook', [MembershipController::class, 'handleWebhook']);

/*
|--------------------------------------------------------------------------
| 80G CERTIFICATE
|--------------------------------------------------------------------------
*/
// Show page
Route::get('/80g-certificate', [DonationController::class, 'show80GForm'])->name('80g.form');
Route::post('/80g-certificate/search', [DonationController::class, 'search80G'])->name('80g.search');
Route::get('/80g-certificate/download/{id}', [DonationController::class, 'download80G'])->name('80g.download');

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/volunteers', [VolunteerController::class, 'index']);


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('dashboard')->group(function(){    //->middleware('auth')

    // List
    Route::get('/volunteers', [VolunteerController::class, 'adminIndex'])
        ->name('dashboard.volunteers');

    // Create form
    Route::get('/volunteers/create', [VolunteerController::class, 'create'])
        ->name('dashboard.volunteers.create');

    // Store
    Route::post('/volunteers', [VolunteerController::class, 'store'])
        ->name('dashboard.volunteers.store');

    // Edit form (REST-style)
    Route::get('/volunteers/{id}/edit', [VolunteerController::class, 'edit'])
        ->name('dashboard.volunteers.edit');

    // Update
    Route::put('/volunteers/{id}', [VolunteerController::class, 'update'])
        ->name('dashboard.volunteers.update');

    // Delete
    Route::delete('/volunteers/{id}', [VolunteerController::class, 'destroy'])
        ->name('dashboard.volunteers.delete');
});


/*
|--------------------------------------------------------------------------
| ADMIN PANEL (PROTECT THIS WITH MIDDLEWARE)
|--------------------------------------------------------------------------
*/

Route::prefix('dashboard')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | MEMBERS
    |--------------------------------------------------------------------------
    */

    Route::get('/members', [MembershipController::class, 'adminIndex'])->name('dashboard.members');

    Route::get('/members/view/{id}', [MembershipController::class, 'view'])->name('dashboard.members.view');

    Route::get('/members/edit/{id}', [MembershipController::class, 'edit'])->name('dashboard.members.edit');

    Route::post('/members/update/{id}', [MembershipController::class, 'update'])->name('dashboard.members.update');

    Route::delete('/members/delete/{id}', [MembershipController::class, 'destroy'])->name('dashboard.members.delete');

    // APPROVE / REJECT / CANCEL AUTOPAY
    Route::post('/members/approve/{id}', [MembershipController::class, 'approve'])->name('dashboard.members.approve');

    Route::post('/members/reject/{id}', [MembershipController::class, 'reject'])->name('dashboard.members.reject');

    Route::post('/members/cancel-subscription/{id}', [MembershipController::class, 'cancelSubscription'])->name('dashboard.members.cancel');

    /*
    |--------------------------------------------------------------------------
    | CONTACT MESSAGES
    |--------------------------------------------------------------------------
    */

    Route::get('/messages', [DashboardController::class, 'messages'])->name('dashboard.messages');

    Route::delete('/messages/{id}', [DashboardController::class, 'deleteMessage'])->name('dashboard.messages.delete');

    /*
    |--------------------------------------------------------------------------
    | DONORS
    |--------------------------------------------------------------------------
    */

    Route::get('/donors', [DonationController::class, 'adminIndex'])->name('dashboard.donors');

    Route::get('/donors/view/{id}', [DonationController::class, 'viewDonor'])->name('dashboard.donors.view');

    Route::get('/donors/edit/{id}', [DonationController::class, 'editDonor'])->name('dashboard.donors.edit');

    Route::post('/donors/update/{id}', [DonationController::class, 'updateDonor'])->name('dashboard.donors.update');

    Route::delete('/donors/delete/{id}', [DonationController::class, 'deleteDonor'])->name('dashboard.donors.delete');


});

use App\Http\Controllers\GalleryController;

/*
|--------------------------------------------------------------------------
| PUBLIC GALLERY
|--------------------------------------------------------------------------
*/
Route::get('/gallery', [GalleryController::class, 'index'])
    ->name('gallery');


/*
|--------------------------------------------------------------------------
| ADMIN GALLERY
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')->group(function(){ //->middleware('auth')

    // List
    Route::get('/gallery', [GalleryController::class, 'adminIndex'])
        ->name('dashboard.gallery');

    // Create form
    Route::get('/gallery/create', [GalleryController::class, 'create'])
        ->name('dashboard.gallery.create');

    // Store
    Route::post('/gallery', [GalleryController::class, 'store'])
        ->name('dashboard.gallery.store');

    // Delete
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])
        ->name('dashboard.gallery.delete');
});


Route::get('/test-invoice', function () {

    $donation = (object)[
        'name' => 'Test User',
        'amount' => 500,
        'phone'=> 1234567890,
        'email'=> 'a@g.c',
        'donation_purpose'=>'sgfshd',
        'receipt_number' => 'TEST-1234',
        'created_at' => now(),
        'razorpay_payment_id' => 'TESTPAY123'
    ];

    $pdf = Pdf::loadView('frontend.invoice_pdf', compact('donation'));

    return $pdf->download('test_invoice.pdf');
});