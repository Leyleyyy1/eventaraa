<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\EventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "web" middleware group.
|
*/

// =======================
// LANDING PAGE
// =======================
Route::get('/', function () {
    return view('user.landingpage');
});


// =======================
// ADMIN ROUTES
// =======================
Route::prefix('admin')->name('admin.')->group(function () {

    // Register Admin
    Route::get('/register', [App\Http\Controllers\Admin\AdminRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Admin\AdminRegisterController::class, 'register'])->name('register.submit');

    // Login Admin
    Route::get('/login', [App\Http\Controllers\Admin\AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\AdminLoginController::class, 'login'])->name('login.submit');

    // Logout Admin
    Route::post('/logout', function () {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    })->name('logout');

    // Hanya bisa diakses setelah login admin
    Route::middleware(['auth:admin'])->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Users
        Route::get('/users', function () {
            return view('admin.users');
        })->name('users');

        // Transactions
        Route::get('/transactions', function () {
            return view('admin.transactions');
        })->name('transactions');

        // Reports
        Route::get('/reports', function () {
            return view('admin.reports');
        })->name('reports');

        // =======================
        // EVENT CRUD ROUTES
        // =======================
    Route::get('/events', [EventController::class, 'index'])->name('events.kelolaevent');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

    // ✅ Tambahkan ini:
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.detail');
    });
});


// =======================
// USER ROUTES (Simulasi)
// =======================
Route::get('/user/register', function () {
    return view('auth.user.register');
})->name('user.register');

Route::post('/user/register', function () {
    return redirect()->route('user.login')->with('success', 'Register berhasil (simulasi)');
})->name('user.register.submit');

Route::get('/user/login', function () {
    return view('auth.user.login');
})->name('user.login');

Route::post('/user/login', function () {
    return redirect()->route('user.login')->with('success', 'Login berhasil (simulasi)');
})->name('user.login.submit');
