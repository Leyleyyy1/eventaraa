<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(storage_path('firebase/firebase_credentials.json'));
        $this->auth = $factory->createAuth();
    }

    public function signInWithEmailAndPassword(string $email, string $password)
    {
        try {
            $signInResult = $this->auth->signInWithEmailAndPassword($email, $password);
            return $signInResult;
        } catch (\Kreait\Firebase\Exception\Auth\InvalidPassword $e) {
            throw new \Exception("Password salah.");
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            throw new \Exception("User tidak ditemukan.");
        } catch (\Exception $e) {
            throw new \Exception("Login gagal: " . $e->getMessage());
        }
    }
}
