<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\User\UserRegisterController;
use App\Http\Controllers\User\AuthFirebaseController;
use App\Http\Controllers\User\GoogleAuthController;


Route::get('/', function () {
    return view('user.landingpage');
});

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/register', [UserRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserRegisterController::class, 'register'])->name('register.submit');

    Route::get('/login', [AuthFirebaseController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthFirebaseController::class, 'login'])->name('login.submit');

    Route::get('/login/google', fn() => view('user.google-login'))->name('google.login');
    Route::post('/login/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', fn() => view('user.dashboard'))->name('dashboard');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/register', [AdminRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AdminRegisterController::class, 'register'])->name('register.submit');

    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');

    Route::post('/logout', function () {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    })->name('logout');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
        Route::get('/users', fn() => view('admin.users'))->name('users');
        Route::get('/transactions', fn() => view('admin.transactions'))->name('transactions');
        Route::get('/reports', fn() => view('admin.reports'))->name('reports');

        Route::get('/events', [EventController::class, 'index'])->name('events.kelolaevent');
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::get('/events/{id}', [EventController::class, 'show'])->name('events.detail');
    });
});
