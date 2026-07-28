<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Build last 6 months chart data
        $chartLabels = [];
        $chartRevenue = [];
        $chartOrders = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->translatedFormat('M Y');

            // Revenue per bulan dari pivot table
            $revenue = DB::table('package_transaction')
                ->join('transactions', 'transactions.id', '=', 'package_transaction.transaction_id')
                ->whereYear('transactions.created_at', $month->year)
                ->whereMonth('transactions.created_at', $month->month)
                ->sum('package_transaction.total');
            $chartRevenue[] = (int) $revenue;

            // Jumlah order per bulan
            $orders = Transaction::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $chartOrders[] = $orders;
        }

        return view('admin.dashboard', [
            'customer'     => Customer::count(),
            'package'      => Package::count(),
            'transaction'  => Transaction::count(),
            'income'       => DB::table('package_transaction')->sum('total'),
            'todayOrders'  => Transaction::whereDate('created_at', today())->count(),
            'chartLabels'  => $chartLabels,
            'chartRevenue' => $chartRevenue,
            'chartOrders'  => $chartOrders,
            'recentLogs'   => ActivityLog::latest()->take(15)->get(),
        ]);
    }
}
