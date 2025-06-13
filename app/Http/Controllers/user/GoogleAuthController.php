<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Kreait\Firebase\Auth as FirebaseAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleAuthController extends Controller
{
    public function handleGoogleCallback(Request $request, FirebaseAuth $firebaseAuth)
    {
        $request->validate([
            'idToken' => 'required|string'
        ]);

        try {
            $verifiedIdToken = $firebaseAuth->verifyIdToken($request->idToken);
            $firebaseUid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
            $name = $verifiedIdToken->claims()->get('name');

            $user = User::where('firebase_uid', $firebaseUid)->orWhere('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $name ?? 'User Google',
                    'email' => $email,
                    'firebase_uid' => $firebaseUid,
                    'password' => bcrypt(str()->random(16)),
                ]);
            }

            Auth::login($user);
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
