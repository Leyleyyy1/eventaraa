<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\User\UserLoginController;
use App\Http\Controllers\User\UserRegisterController;

Route::get('/', function () {
    return view('user.landingpage');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/register', [App\Http\Controllers\Admin\AdminRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Admin\AdminRegisterController::class, 'register'])->name('register.submit');

    Route::get('/login', [App\Http\Controllers\Admin\AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\AdminLoginController::class, 'login'])->name('login.submit');

    Route::post('/logout', function () {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    })->name('logout');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/users', function () {
            return view('admin.users');
        })->name('users');

        Route::get('/transactions', function () {
            return view('admin.transactions');
        })->name('transactions');

        Route::get('/reports', function () {
            return view('admin.reports');
        })->name('reports');

        Route::get('/events', [EventController::class, 'index'])->name('events.kelolaevent');
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::get('/events/{id}', [EventController::class, 'show'])->name('events.detail');
    });
});

Route::get('/user/register', [UserRegisterController::class, 'showRegisterForm'])->name('user.register');
Route::post('/user/register', [UserRegisterController::class, 'register'])->name('user.register.submit');

Route::get('/user/login', [UserLoginController::class, 'showLoginForm'])->name('user.login');
Route::post('/user/login', [UserLoginController::class, 'login'])->name('user.login.submit');

Route::get('/user/dashboard', function () {
    return view('user.dashboard'); 
})->name('user.dashboard');
