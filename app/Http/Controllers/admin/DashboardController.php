<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $adminId = Auth::guard('admin')->id();

        $totalEvents = Event::where('admin_id', $adminId)->count();

        $totalTransactions = Transaction::whereHas('event', function($q) use ($adminId) {
            $q->where('admin_id', $adminId);
        })->count();

        $totalRevenue = Transaction::whereHas('event', function($q) use ($adminId) {
            $q->where('admin_id', $adminId);
        })->sum('total_amount');

        $last7Days = Carbon::now()->subDays(6)->startOfDay();
        $transactionsPerDay = Transaction::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereHas('event', fn($q) => $q->where('admin_id', $adminId))
            ->whereDate('created_at', '>=', $last7Days)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates->put($date, $transactionsPerDay->get($date, 0));
        }

        return view('admin.dashboard', [
            'totalEvents' => $totalEvents,
            'totalTransactions' => $totalTransactions,
            'totalRevenue' => $totalRevenue,
            'transactionsPerDay' => $dates,
        ]);
    }
}
