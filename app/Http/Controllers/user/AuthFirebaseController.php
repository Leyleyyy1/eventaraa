<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AuthFirebaseController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.user.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $apiKey = config('services.firebase.api_key');

        $response = Http::post("https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key={$apiKey}", [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'returnSecureToken' => true
        ]);

        if ($response->successful()) {
            $data = $response->json();

            Session::put('firebase_uid', $data['localId']);
            Session::put('firebase_email', $data['email']);

            return redirect()->route('user.dashboard');
        } else {
            return back()->withErrors(['message' => 'Email atau password salah']);
        }
    }
}
