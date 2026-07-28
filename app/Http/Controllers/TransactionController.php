<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Package;
use App\Models\ActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    // Tampilkan semua transaksi dengan QuickSort & Interpolation Search
    public function index(Request $request)
    {
        $querySearch = $request->input('search');
        $filterStatus = $request->input('status');

        // Fetch data dasar
        $transactionsQuery = Transaction::with('customer', 'packages');

        // Filter berdasarkan status jika ada
        if ($filterStatus && in_array($filterStatus, ['proses', 'selesai', 'diambil'])) {
            $transactionsQuery->where('status', $filterStatus);
        }

        $transactions = $transactionsQuery->get();

        // 1. URUTKAN TERLEBIH DAHULU MENGGUNAKAN ALGORITMA QUICKSORT (Terbaru berdasarkan created_at / id desc)
        $transactionsArray = $transactions->all();
        $sortedTransactions = $this->quickSortByLatest($transactionsArray);

        // 2. JIKA ADA PENCARIAN NAMA PELANGGAN -> GUNAKAN ALGORITMA INTERPOLATION SEARCH
        if (!empty($querySearch)) {
            $sortedTransactions = $this->searchByInterpolation($sortedTransactions, $querySearch);
        }

        // Return ke view dengan data terurut dan terfilter
        return view('transactions.index', [
            'transactions' => collect($sortedTransactions),
            'querySearch'  => $querySearch,
            'filterStatus' => $filterStatus,
        ]);
    }

    /**
     * Algoritma QuickSort untuk mengurutkan transaksi terbaru (created_at DESC / ID DESC)
     */
    private function quickSortByLatest(array $arr): array
    {
        if (count($arr) < 2) {
            return $arr;
        }

        $left = [];
        $right = [];
        $pivotKey = key($arr);
        $pivot = array_shift($arr);

        foreach ($arr as $val) {
            // Karena ingin urutan TERBARU (Descending), item dengan timestamp/ID lebih besar masuk ke kiri ($left)
            if ($val->created_at->timestamp >= $pivot->created_at->timestamp) {
                $left[] = $val;
            } else {
                $right[] = $val;
            }
        }

        return array_merge($this->quickSortByLatest($left), [$pivot], $this->quickSortByLatest($right));
    }

    /**
     * Algoritma Interpolation Search untuk mencari nama pelanggan
     * Syarat Interpolation Search: Data harus terurut berdasarkan kunci pencarian (nama pelanggan secara A-Z).
     */
    private function searchByInterpolation(array $transactions, string $searchQuery): array
    {
        if (empty($transactions)) {
            return [];
        }

        $searchQueryClean = strtolower(trim($searchQuery));

        // Buat copy array lalu urutkan secara Alphabetical (Ascending) berdasarkan nama pelanggan untuk syarat Interpolation Search
        $sortedByName = $transactions;
        usort($sortedByName, function ($a, $b) {
            return strcasecmp($a->customer->name ?? '', $b->customer->name ?? '');
        });

        $low = 0;
        $high = count($sortedByName) - 1;
        $matchedIndices = [];

        // Konversi karakter string ke nilai numerik ASCII/Code Point untuk rumus interpolasi
        $getValue = function ($item) {
            $name = strtolower($item->customer->name ?? '');
            if ($name === '') return 0;
            // Ambil bobot numerik dari 3 karakter pertama
            $val = 0;
            for ($i = 0; $i < min(3, strlen($name)); $i++) {
                $val = ($val * 256) + ord($name[$i]);
            }
            return $val;
        };

        $targetVal = 0;
        for ($i = 0; $i < min(3, strlen($searchQueryClean)); $i++) {
            $targetVal = ($targetVal * 256) + ord($searchQueryClean[$i]);
        }

        // Proses Interpolation Search logic
        while ($low <= $high && $targetVal >= $getValue($sortedByName[$low]) && $targetVal <= $getValue($sortedByName[$high])) {
            if ($low === $high) {
                if (str_contains(strtolower($sortedByName[$low]->customer->name ?? ''), $searchQueryClean)) {
                    $matchedIndices[] = $low;
                }
                break;
            }

            $lowVal  = $getValue($sortedByName[$low]);
            $highVal = $getValue($sortedByName[$high]);

            if ($highVal === $lowVal) {
                if ($highVal === $targetVal) {
                    for ($k = $low; $k <= $high; $k++) {
                        if (str_contains(strtolower($sortedByName[$k]->customer->name ?? ''), $searchQueryClean)) {
                            $matchedIndices[] = $k;
                        }
                    }
                }
                break;
            }

            // Rumus posisi Interpolation Search: pos = low + [ (target - lowVal) * (high - low) / (highVal - lowVal) ]
            $pos = $low + (int) floor((($targetVal - $lowVal) * ($high - $low)) / ($highVal - $lowVal));

            if ($pos < $low || $pos > $high) {
                break;
            }

            // Cek apakah posisi ini cocok atau mengandung query pencarian
            if (str_contains(strtolower($sortedByName[$pos]->customer->name ?? ''), $searchQueryClean)) {
                // Kumpulkan semua kecocokan di sekitar posisi $pos
                $matchedIndices[] = $pos;
                // Cek tetangga kiri
                $leftIndex = $pos - 1;
                while ($leftIndex >= $low && str_contains(strtolower($sortedByName[$leftIndex]->customer->name ?? ''), $searchQueryClean)) {
                    $matchedIndices[] = $leftIndex;
                    $leftIndex--;
                }
                // Cek tetangga kanan
                $rightIndex = $pos + 1;
                while ($rightIndex <= $high && str_contains(strtolower($sortedByName[$rightIndex]->customer->name ?? ''), $searchQueryClean)) {
                    $matchedIndices[] = $rightIndex;
                    $rightIndex++;
                }
                break;
            }

            if ($getValue($sortedByName[$pos]) < $targetVal) {
                $low = $pos + 1;
            } else {
                $high = $pos - 1;
            }
        }

        // Jika interpolation search persis tidak menemukan titik awal, lakukan penelusuran fallback substring match
        if (empty($matchedIndices)) {
            $results = array_filter($transactions, function ($t) use ($searchQueryClean) {
                return str_contains(strtolower($t->customer->name ?? ''), $searchQueryClean);
            });
            return array_values($results);
        }

        // Ambil hasil match unik
        $matchedIndices = array_unique($matchedIndices);
        $matchedResults = [];
        foreach ($matchedIndices as $idx) {
            $matchedResults[] = $sortedByName[$idx];
        }

        // Kembalikan urutan hasil pencarian tetap terurut QuickSort (Terbaru)
        return $this->quickSortByLatest($matchedResults);
    }

    // Form tambah transaksi
    public function create()
    {
        $customers = Customer::all();
        $packages = Package::all();
        return view('transactions.create', compact('customers', 'packages'));
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'packages' => 'required|array|min:1',
            'packages.*.id' => 'required|exists:packages,id',
            'packages.*.qty' => 'required|integer|min:1',
        ]);

        $transaction = Transaction::create([
            'customer_id' => $request->customer_id,
            'status' => 'proses',
        ]);

        foreach ($request->packages as $pkg) {
            $package = Package::findOrFail($pkg['id']);
            $transaction->packages()->attach($package->id, [
                'qty' => $pkg['qty'],
                'total' => $package->price * $pkg['qty'],
            ]);
        }

        ActivityLog::record(
            'created', 'Transaction', $transaction->id,
            "Transaksi baru dibuat untuk pelanggan: \"{$transaction->customer->name}\" (" . $transaction->packages->count() . " paket)"
        );

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaksi berhasil ditambahkan');
    }

    // Tampilkan bill (web)
    public function bill(Transaction $transaction)
    {
        $transaction->load('customer', 'packages');
        return view('transactions.bill', compact('transaction'));
    }

    // Generate PDF
    public function pdf(Transaction $transaction)
    {
        $transaction->load('customer', 'packages');

        $pdf = Pdf::loadView('transactions.bill', compact('transaction'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream('bill-transaksi-'.$transaction->id.'.pdf');
    }

    // Update status transaksi
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:proses,selesai,diambil',
        ]);

        $oldStatus = $transaction->status;
        $transaction->update([
            'status' => $request->status,
        ]);

        ActivityLog::record(
            'updated', 'Transaction', $transaction->id,
            "Status transaksi pelanggan \"{$transaction->customer->name}\" diubah: {$oldStatus} → {$request->status}"
        );

        return redirect()->route('transactions.index')
                         ->with('success', 'Status transaksi berhasil diperbarui');
    }

    // Hapus transaksi
    public function destroy(Transaction $transaction)
    {
        $customerName = $transaction->customer->name;
        $id = $transaction->id;
        $transaction->delete();

        ActivityLog::record(
            'deleted', 'Transaction', $id,
            "Transaksi pelanggan \"{$customerName}\" dihapus"
        );

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaksi berhasil dihapus');
    }
}
