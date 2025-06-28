<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\UserRegisterController;
use App\Http\Controllers\User\AuthFirebaseController;
use App\Http\Controllers\User\GoogleAuthController;
use App\Http\Controllers\User\PurchaseController;
use App\Models\Transaction;

Route::get('/', function () {
    return view('user.landingpage');
})->name('user.landingpage');

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/register', [UserRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserRegisterController::class, 'register'])->name('register.submit');

    Route::get('/login', [AuthFirebaseController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthFirebaseController::class, 'login'])->name('login.submit');

    Route::get('/login/google', fn() => view('user.google-login'))->name('google.login');
    Route::post('/login/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');

    Route::post('/logout', function () {
        Session::forget('firebase_uid');
        Session::forget('firebase_email');
        Auth::logout();
        return redirect()->route('user.landingpage');
    })->name('logout');


    Route::get('/events', [App\Http\Controllers\User\EventController::class, 'index'])->name('events');
    Route::get('/events/{id}', [App\Http\Controllers\User\EventController::class, 'show'])->name('events.show');


    Route::get('/midtrans/status/{orderId}', [PurchaseController::class, 'checkMidtransStatus']);
    Route::get('/payment/detail/{order_id}', [App\Http\Controllers\User\PurchaseController::class, 'detail'])->name('payment.detail');

    Route::middleware(['auth'])->group(function () {
        Route::get('/profil', fn() => view('user.profil'))->name('profil');

        Route::get('/tickets/{event_id}', [PurchaseController::class, 'selectTicket'])->name('tickets.select');
        Route::get('/checkout', [PurchaseController::class, 'checkout'])->name('checkout');
        Route::post('/purchase/pay', [PurchaseController::class, 'pay'])->name('purchase.pay');
        Route::get('/payment/detail/{order_id}', [PurchaseController::class, 'detail'])->name('purchase.detail');
        Route::get('/payment/check-status/{orderId}', [PurchaseController::class, 'checkMidtransStatus'])->name('purchase.checkstatus');
        Route::get('/transactions/history', [App\Http\Controllers\User\TransactionController::class, 'history'])->name('transactions.history');
        Route::get('/riwayat', [PurchaseController::class, 'riwayat'])->name('user.riwayat');

    });

  

});

Route::post('/midtrans/notification', [PurchaseController::class, 'notificationHandler']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['web'])->group(function () {
        Route::get('/register', [AdminRegisterController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [AdminRegisterController::class, 'register'])->name('register.submit');

        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::post('/logout', function () {
            Auth::guard('admin')->logout();
            return redirect()->route('user.landingpage');
        })->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/transactions', function () {
            $admin = Auth::guard('admin')->user();

            $transactions = Transaction::with(['user', 'event', 'ticket'])
                ->whereHas('event', function ($query) use ($admin) {
                    $query->where('admin_id', $admin->id);
                })
                ->latest()
                ->get();

            return view('admin.transactions', compact('transactions'));
        })->name('transactions');


        Route::get('/profile', fn() => view('admin.profil'))->name('profile');

        Route::get('/events', [EventController::class, 'index'])->name('events.kelolaevent');
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::get('/events/{id}', [EventController::class, 'show'])->name('events.detail');
    });
});
