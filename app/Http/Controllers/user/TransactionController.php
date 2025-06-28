<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function history()
    {
        $user = auth()->user();

        $transactions = Transaction::with(['event', 'ticket'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('user.riwayat', compact('transactions'));
    }
}
