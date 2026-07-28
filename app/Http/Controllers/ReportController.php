<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date', now()->toDateString());

        $transactions = Transaction::with('customer', 'packages')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung summary
        $totalRevenue = $transactions->sum(function ($t) {
            return $t->packages->sum(fn($p) => $p->pivot->total);
        });

        $totalItems = $transactions->sum(function ($t) {
            return $t->packages->sum(fn($p) => $p->pivot->qty);
        });

        $byStatus = $transactions->groupBy('status')->map->count();

        return view('admin.reports.index', compact(
            'transactions', 'startDate', 'endDate',
            'totalRevenue', 'totalItems', 'byStatus'
        ));
    }

    /**
     * Export ke PDF
     */
    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date', now()->toDateString());

        $transactions = Transaction::with('customer', 'packages')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $transactions->sum(function ($t) {
            return $t->packages->sum(fn($p) => $p->pivot->total);
        });

        $pdf = Pdf::loadView('admin.reports.pdf', compact('transactions', 'startDate', 'endDate', 'totalRevenue'))
                  ->setPaper('A4', 'landscape');

        ActivityLog::record(
            'exported', 'Report', null,
            "Laporan PDF diekspor untuk periode {$startDate} s/d {$endDate}"
        );

        return $pdf->download("laporan-laundry-{$startDate}-{$endDate}.pdf");
    }

    /**
     * Export ke CSV (Excel-compatible)
     */
    public function exportCsv(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date', now()->toDateString());

        $transactions = Transaction::with('customer', 'packages')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();

        ActivityLog::record(
            'exported', 'Report', null,
            "Laporan CSV diekspor untuk periode {$startDate} s/d {$endDate}"
        );

        $filename = "laporan-laundry-{$startDate}-{$endDate}.csv";

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            // BOM untuk Excel agar bisa baca UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            fputcsv($file, ['No', 'Tanggal', 'Pelanggan', 'No. HP', 'Rincian Paket', 'Total Item', 'Total Harga (Rp)', 'Status']);

            foreach ($transactions as $i => $t) {
                $rincian = $t->packages->map(function ($p) {
                    return $p->name . ' x' . $p->pivot->qty;
                })->implode(', ');

                $totalHarga = $t->packages->sum(fn($p) => $p->pivot->total);
                $totalItem  = $t->packages->sum(fn($p) => $p->pivot->qty);

                fputcsv($file, [
                    $i + 1,
                    $t->created_at->format('d/m/Y H:i'),
                    $t->customer->name,
                    $t->customer->phone,
                    $rincian,
                    $totalItem,
                    $totalHarga,
                    ucfirst($t->status),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
