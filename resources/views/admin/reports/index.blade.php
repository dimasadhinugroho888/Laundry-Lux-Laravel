@extends('admin.layouts.admin')

@section('content')
<div class="mb-10">
    <h2 class="text-3xl font-bold tracking-tight text-slate-800">Laporan <span class="gradient-text">Penjualan</span></h2>
    <p class="text-slate-500 mt-1">Generate laporan transaksi berdasarkan rentang tanggal.</p>
</div>

{{-- Filter Card --}}
<div class="premium-card p-6 bg-white border-none shadow-sm mb-8">
    <form method="GET" action="{{ route('reports.index') }}" class="flex flex-col md:flex-row items-end gap-4">
        <div class="flex-1">
            <label class="flex items-center gap-1.5 text-sm font-bold text-slate-700 mb-2">
                <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i> Tanggal Mulai
            </label>
            <input type="date" name="start_date" value="{{ $startDate }}"
                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all">
        </div>
        <div class="flex-1">
            <label class="flex items-center gap-1.5 text-sm font-bold text-slate-700 mb-2">
                <i data-lucide="calendar-check" class="w-4 h-4 text-slate-400"></i> Tanggal Selesai
            </label>
            <input type="date" name="end_date" value="{{ $endDate }}"
                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary py-3 px-5 text-sm whitespace-nowrap">
                <i data-lucide="search" class="w-4 h-4 mr-1.5"></i> Filter
            </button>
        </div>
    </form>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="premium-card p-5 bg-gradient-to-br from-indigo-50 to-white">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Transaksi</p>
        <h3 class="text-3xl font-extrabold text-slate-800">{{ $transactions->count() }}</h3>
    </div>
    <div class="premium-card p-5 bg-gradient-to-br from-emerald-50 to-white">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Pendapatan</p>
        <h3 class="text-2xl font-extrabold text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>
    <div class="premium-card p-5 bg-gradient-to-br from-pink-50 to-white">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Item</p>
        <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($totalItems) }}</h3>
    </div>
    <div class="premium-card p-5 bg-gradient-to-br from-amber-50 to-white">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Status Selesai</p>
        <h3 class="text-3xl font-extrabold text-slate-800">{{ $byStatus['selesai'] ?? 0 }}</h3>
    </div>
</div>

{{-- Export Buttons --}}
<div class="flex items-center gap-3 mb-6">
    <span class="text-sm font-bold text-slate-500">Export:</span>
    <a href="{{ route('reports.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
       target="_blank"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-bold text-sm text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-100 transition-colors">
        <i data-lucide="file-text" class="w-4 h-4"></i> Export PDF
    </a>
    <a href="{{ route('reports.csv', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-bold text-sm text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 transition-colors">
        <i data-lucide="table" class="w-4 h-4"></i> Export Excel (CSV)
    </a>
</div>

{{-- Table --}}
<div class="premium-card overflow-hidden border-none shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">#</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">Pelanggan</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">Rincian Paket</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Item</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">Total</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
            @forelse ($transactions as $t)
                @php
                    $totalHarga = $t->packages->sum(fn($p) => $p->pivot->total);
                    $totalItem  = $t->packages->sum(fn($p) => $p->pivot->qty);
                    $statusClasses = [
                        'proses'  => 'bg-amber-50 text-amber-600 border-amber-100',
                        'selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                        'diambil' => 'bg-slate-100 text-slate-600 border-slate-200',
                    ];
                    $statusClass = $statusClasses[$t->status] ?? $statusClasses['diambil'];
                @endphp
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-5 text-sm font-medium text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-5 text-sm text-slate-600 font-medium whitespace-nowrap">{{ $t->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-5">
                        <div>
                            <span class="font-bold text-slate-700 block">{{ $t->customer->name }}</span>
                            <span class="text-xs text-slate-400">{{ $t->customer->phone }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex flex-wrap gap-1">
                            @foreach ($t->packages as $p)
                                <span class="inline-flex items-center px-2 py-1 rounded-md bg-slate-100 text-[10px] font-bold text-slate-600 border border-slate-200">
                                    {{ $p->name }} ({{ $p->pivot->qty }} {{ $p->unit }})
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-5 text-sm text-slate-600 font-medium text-center">{{ $totalItem }}</td>
                    <td class="px-6 py-5">
                        <span class="font-bold text-slate-800">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current mr-2"></span>
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                        <div class="flex flex-col items-center gap-3">
                            <i data-lucide="folder-x" class="w-12 h-12 text-slate-200"></i>
                            <p class="font-semibold">Tidak ada transaksi pada periode ini</p>
                            <p class="text-sm">Coba ubah rentang tanggal filter di atas</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
            @if ($transactions->count() > 0)
            <tfoot>
                <tr class="bg-indigo-50/50 border-t border-indigo-100">
                    <td colspan="5" class="px-6 py-4 text-sm font-extrabold text-indigo-800 text-right">TOTAL PENDAPATAN:</td>
                    <td class="px-6 py-4 font-extrabold text-indigo-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
