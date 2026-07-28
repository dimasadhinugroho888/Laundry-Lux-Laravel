@extends('admin.layouts.admin')

@section('content')
<div class="mb-10">
    <h2 class="text-3xl font-bold tracking-tight text-slate-800">Ringkasan <span class="gradient-text">Bisnis</span></h2>
    <p class="text-slate-500 mt-1 text-lg">Pantau aktivitas laundry Anda hari ini secara real-time.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Customers Card -->
    <div class="stat-card-indigo group">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mb-1">Total Pelanggan</p>
                <h3 class="text-4xl font-extrabold text-slate-800">{{ number_format($customer) }}</h3>
            </div>
            <div class="p-3 rounded-2xl bg-indigo-100 text-indigo-600 group-hover:scale-110 transition-transform duration-300">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('customers.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:gap-3 transition-all">
                Kelola Database <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    <!-- Packages Card -->
    <div class="stat-card-pink group">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mb-1">Layanan Aktif</p>
                <h3 class="text-4xl font-extrabold text-slate-800">{{ number_format($package) }}</h3>
            </div>
            <div class="p-3 rounded-2xl bg-pink-100 text-pink-600 group-hover:scale-110 transition-transform duration-300">
                <i data-lucide="package-search" class="w-6 h-6"></i>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('packages.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-pink-600 hover:gap-3 transition-all">
                Cek Paket <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    <!-- Transactions Card -->
    <div class="stat-card-blue group">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mb-1">Total Pesanan</p>
                <h3 class="text-4xl font-extrabold text-slate-800">{{ number_format($transaction) }}</h3>
            </div>
            <div class="p-3 rounded-2xl bg-blue-100 text-blue-600 group-hover:scale-110 transition-transform duration-300">
                <i data-lucide="shopping-bag" class="w-6 h-6"></i>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:gap-3 transition-all">
                Lihat Semua <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="premium-card p-6 bg-gradient-to-br from-indigo-600 to-indigo-800 text-white border-none group">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-indigo-200 font-bold text-xs uppercase tracking-widest mb-1">Total Pendapatan</p>
                <h3 class="text-3xl font-extrabold tracking-tight">Rp {{ number_format($income, 0, ',', '.') }}</h3>
            </div>
            <div class="p-3 rounded-2xl bg-white/10 text-white backdrop-blur-md group-hover:scale-110 transition-transform duration-300">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
        </div>
        <div class="mt-8">
            <div class="flex items-center gap-2 text-indigo-200 text-sm font-medium">
                <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-bold border border-emerald-500/30">
                    {{ $todayOrders }} order hari ini
                </span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-12">
    <!-- Chart Section -->
    <div class="lg:col-span-2 premium-card p-8 bg-white">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h4 class="text-lg font-bold text-slate-800">Statistik Penjualan</h4>
                <p class="text-xs text-slate-400 mt-0.5">Pendapatan 6 bulan terakhir</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-bold text-slate-400">
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-indigo-500 inline-block"></span> Pendapatan</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-pink-400 inline-block"></span> Jumlah Order</span>
            </div>
        </div>
        <div class="relative h-64">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="premium-card p-8 bg-white">
        <h4 class="text-lg font-bold text-slate-800 mb-6 flex items-center justify-between">
            Aksi Cepat
            <i data-lucide="zap" class="w-5 h-5 text-amber-500"></i>
        </h4>
        <ul class="space-y-4">
            <li>
                <a href="{{ route('transactions.create') }}" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-100">
                        <i data-lucide="plus" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">Buat Transaksi Baru</p>
                        <p class="text-xs text-slate-500">Input laundry baru</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('customers.create') }}" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-100">
                        <i data-lucide="user-plus" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">Daftar Pelanggan</p>
                        <p class="text-xs text-slate-500">Tambah data pelanggan</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('transactions.index') }}" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-lg shadow-amber-100">
                        <i data-lucide="receipt" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 group-hover:text-amber-600 transition-colors">Semua Transaksi</p>
                        <p class="text-xs text-slate-500">Lihat riwayat pesanan</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = @json($chartLabels);
    const revenue = @json($chartRevenue);
    const orders = @json($chartOrders);

    const ctx = document.getElementById('salesChart').getContext('2d');

    // Gradient fill for revenue
    const gradientRevenue = ctx.createLinearGradient(0, 0, 0, 256);
    gradientRevenue.addColorStop(0, 'rgba(99, 102, 241, 0.25)');
    gradientRevenue.addColorStop(1, 'rgba(99, 102, 241, 0)');

    const gradientOrders = ctx.createLinearGradient(0, 0, 0, 256);
    gradientOrders.addColorStop(0, 'rgba(244, 114, 182, 0.20)');
    gradientOrders.addColorStop(1, 'rgba(244, 114, 182, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pendapatan (Rp)',
                    data: revenue,
                    borderColor: '#6366f1',
                    backgroundColor: gradientRevenue,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#6366f1',
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y',
                },
                {
                    label: 'Jumlah Order',
                    data: orders,
                    borderColor: '#f472b6',
                    backgroundColor: gradientOrders,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#f472b6',
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#94a3b8',
                    bodyColor: '#f8fafc',
                    padding: 12,
                    cornerRadius: 12,
                    callbacks: {
                        label: function(ctx) {
                            if (ctx.datasetIndex === 0) {
                                return '  Pendapatan: Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                            }
                            return '  Order: ' + ctx.parsed.y + ' transaksi';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(148,163,184,0.08)' },
                    ticks: { color: '#94a3b8', font: { weight: '600', size: 11 } }
                },
                y: {
                    type: 'linear',
                    position: 'left',
                    grid: { color: 'rgba(148,163,184,0.08)' },
                    ticks: {
                        color: '#94a3b8',
                        font: { weight: '600', size: 11 },
                        callback: v => 'Rp ' + (v >= 1000000 ? (v/1000000).toFixed(1)+'jt' : (v >= 1000 ? (v/1000).toFixed(0)+'rb' : v))
                    }
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: {
                        color: '#f472b6',
                        font: { weight: '600', size: 11 },
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>

{{-- Activity Log Section --}}
<div class="mt-8 premium-card bg-white border-none shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-8 py-5 border-b border-slate-50">
        <div>
            <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <i data-lucide="shield-check" class="w-5 h-5 text-indigo-500"></i>
                Log Aktivitas Sistem
            </h4>
            <p class="text-xs text-slate-400 mt-0.5">Riwayat perubahan data — 15 aktivitas terakhir</p>
        </div>
    </div>
    <div class="divide-y divide-slate-50">
        @forelse ($recentLogs as $log)
            @php
                $actionConfig = [
                    'created'  => ['color' => 'text-emerald-600 bg-emerald-50', 'icon' => 'plus-circle',  'label' => 'Tambah'],
                    'updated'  => ['color' => 'text-blue-600 bg-blue-50',       'icon' => 'pencil',       'label' => 'Edit'],
                    'deleted'  => ['color' => 'text-rose-600 bg-rose-50',        'icon' => 'trash-2',      'label' => 'Hapus'],
                    'exported' => ['color' => 'text-purple-600 bg-purple-50',    'icon' => 'download',     'label' => 'Export'],
                ];
                $ac = $actionConfig[$log->action] ?? ['color' => 'text-slate-600 bg-slate-50', 'icon' => 'activity', 'label' => ucfirst($log->action)];
            @endphp
            <div class="flex items-start gap-4 px-8 py-4 hover:bg-slate-50/50 transition-colors">
                <div class="flex-shrink-0 mt-0.5 p-2 rounded-xl {{ $ac['color'] }}">
                    <i data-lucide="{{ $ac['icon'] }}" class="w-4 h-4"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs font-extrabold uppercase tracking-wider px-2 py-0.5 rounded-md {{ $ac['color'] }}">
                            {{ $ac['label'] }}
                        </span>
                        <span class="text-xs font-bold text-slate-500">{{ $log->model_type }}</span>
                        <span class="text-xs text-slate-400">•</span>
                        <span class="text-xs font-bold text-slate-700">{{ $log->user_name }}</span>
                    </div>
                    <p class="text-sm text-slate-600 mt-1 truncate">{{ $log->description }}</p>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-[10px] text-slate-400">
                            <i data-lucide="clock" class="w-3 h-3 inline mr-0.5"></i>
                            {{ $log->created_at->diffForHumans() }}
                        </span>
                        @if ($log->ip_address)
                            <span class="text-[10px] text-slate-400">
                                <i data-lucide="globe" class="w-3 h-3 inline mr-0.5"></i>
                                {{ $log->ip_address }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="px-8 py-12 text-center text-slate-400">
                <i data-lucide="shield" class="w-10 h-10 mx-auto mb-3 text-slate-200"></i>
                <p class="font-semibold">Belum ada aktivitas tercatat</p>
                <p class="text-sm mt-1">Log akan muncul setelah ada perubahan data</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
