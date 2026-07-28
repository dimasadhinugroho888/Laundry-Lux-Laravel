@extends('admin.layouts.admin')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="text-3xl font-bold tracking-tight text-slate-800">Daftar <span class="gradient-text">Transaksi</span></h2>
        <p class="text-slate-500 mt-1">Kelola semua pesanan laundry pelanggan Anda.</p>
    </div>
    <a href="{{ route('transactions.create') }}" class="btn-primary">
        <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
        Tambah Transaksi
    </a>
</div>

{{-- Filter & Search Form --}}
<div class="premium-card p-6 bg-white border-none shadow-sm mb-6">
    <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-col md:flex-row items-center gap-4">
        <!-- Input Search dengan Interpolation Search -->
        <div class="flex-1 w-full">
            <label for="search" class="flex items-center gap-1.5 text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">
                <i data-lucide="search" class="w-3.5 h-3.5 text-indigo-500"></i> Cari Pelanggan (Interpolation Search)
            </label>
            <div class="relative">
                <input type="text" id="search" name="search" value="{{ $querySearch ?? '' }}"
                       class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
                       placeholder="Ketik nama pelanggan...">
                @if(!empty($querySearch))
                    <a href="{{ route('transactions.index', ['status' => $filterStatus]) }}" 
                       class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- Filter Status -->
        <div class="w-full md:w-56">
            <label for="status" class="flex items-center gap-1.5 text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">
                <i data-lucide="filter" class="w-3.5 h-3.5 text-indigo-500"></i> Filter Status
            </label>
            <div class="relative">
                <select name="status" id="status" onchange="this.form.submit()"
                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all appearance-none">
                    <option value="">Semua Status</option>
                    <option value="proses" {{ ($filterStatus ?? '') == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="selesai" {{ ($filterStatus ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="diambil" {{ ($filterStatus ?? '') == 'diambil' ? 'selected' : '' }}>Diambil</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                </div>
            </div>
        </div>

        <!-- Submit Button & Reset -->
        <div class="flex items-center gap-2 w-full md:w-auto md:self-end">
            <button type="submit" class="btn-primary py-2.5 px-5 text-sm w-full md:w-auto">
                Cari & Filter
            </button>
            @if(!empty($querySearch) || !empty($filterStatus))
                <a href="{{ route('transactions.index') }}" 
                   class="px-4 py-2.5 rounded-xl font-bold text-sm text-slate-500 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 transition-colors w-full md:w-auto text-center">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Info Badge Sorting Algorithm --}}
<div class="flex items-center justify-between mb-4 px-2 text-xs font-bold text-slate-400">
    <span class="flex items-center gap-1.5">
        <i data-lucide="arrow-up-down" class="w-3.5 h-3.5 text-indigo-500"></i>
        Urutan: Transaksi Terbaru (QuickSort Algorithm)
    </span>
    @if(!empty($querySearch))
        <span class="bg-indigo-50 text-indigo-600 px-2.5 py-1 rounded-lg border border-indigo-100">
            Pencarian "<strong>{{ $querySearch }}</strong>" via Interpolation Search
        </span>
    @endif
</div>

<div class="premium-card overflow-hidden border-none shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">#</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">Pelanggan</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">Rincian Paket</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Total Item</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">Total Harga</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">Status</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
            @forelse ($transactions as $t)
                @php
                    $totalHarga = $t->packages->sum(fn($p) => $p->pivot->total);
                    $totalItem  = $t->packages->sum(fn($p) => $p->pivot->qty);

                    // Build WhatsApp message
                    $waPhone = preg_replace('/[^0-9]/', '', $t->customer->phone);
                    if (str_starts_with($waPhone, '0')) {
                        $waPhone = '62' . substr($waPhone, 1);
                    }

                    $rincian = $t->packages->map(function($p) {
                        return "- {$p->name} x{$p->pivot->qty} = Rp " . number_format($p->pivot->total, 0, ',', '.');
                    })->implode("\n");

                    $waMessage = "Halo " . ($t->customer->name ?? 'Pelanggan') . ",\n\n"
                        . "Pemberitahuan dari LaundryLux: Pakaian laundry Anda sudah SELESAI dikerjakan dan siap untuk diambil.\n\n"
                        . "Rincian Pesanan:\n"
                        . $rincian . "\n\n"
                        . "Total Pembayaran: Rp " . number_format($totalHarga, 0, ',', '.') . "\n\n"
                        . "Terima kasih telah menggunakan layanan LaundryLux.";

                    $waUrl = 'https://wa.me/' . $waPhone . '?text=' . urlencode($waMessage);
                @endphp
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-5 text-sm font-medium text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                {{ substr($t->customer->name ?? 'P', 0, 1) }}
                            </div>
                            <div>
                                <span class="font-bold text-slate-700 block">{{ $t->customer->name ?? 'Tanpa Nama' }}</span>
                                <span class="text-xs text-slate-400">{{ $t->customer->phone ?? '-' }}</span>
                            </div>
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
                    <td class="px-6 py-5 text-sm text-slate-600 font-medium text-center">
                        {{ $totalItem }}
                    </td>
                    <td class="px-6 py-5">
                        <span class="font-bold text-slate-800">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-5">
                        @php
                            $statusClasses = [
                                'proses'  => 'bg-amber-50 text-amber-600 border-amber-100',
                                'selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'diambil' => 'bg-slate-100 text-slate-600 border-slate-200',
                            ];
                            $statusClass = $statusClasses[$t->status] ?? $statusClasses['diambil'];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current mr-2"></span>
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-end gap-2 flex-wrap">

                            {{-- Tombol Kirim Nota WA — hanya muncul saat status selesai --}}
                            @if ($t->status === 'selesai')
                                <a href="{{ $waUrl }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold transition-all shadow-sm shadow-emerald-200 hover:shadow-emerald-300 active:scale-95"
                                   title="Kirim Notifikasi ke WhatsApp">
                                    <svg class="w-3.5 h-3.5 fill-current flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.504-5.727-1.465L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.638 1.977 14.172 1.05 11.58 1.05c-5.44 0-9.866 4.372-9.87 9.802 0 1.726.473 3.417 1.368 4.907L2.122 21.99l6.525-1.706zm10.748-6.732c-.279-.139-1.646-.807-1.9-.9-.253-.093-.438-.139-.623.139-.184.279-.715.9-.877 1.084-.162.184-.325.208-.604.068-.279-.139-1.18-.435-2.249-1.385-.83-.737-1.39-1.648-1.552-1.927-.162-.279-.017-.43.122-.569.124-.124.279-.325.418-.487.139-.162.186-.279.279-.464.093-.184.047-.348-.023-.487-.069-.139-.623-1.493-.853-2.052-.224-.539-.452-.465-.623-.474-.161-.008-.347-.01-.532-.01s-.488.069-.743.348c-.255.279-.974.95-.974 2.319s.997 2.69 1.137 2.876c.139.186 1.962 2.977 4.753 4.167.663.283 1.181.453 1.585.58.666.21 1.272.18 1.751.109.534-.08 1.646-.668 1.879-1.314.232-.646.232-1.201.162-1.3-.069-.093-.255-.139-.534-.279z"/>
                                    </svg>
                                    Kirim Notifikasi
                                </a>
                            @endif

                            <a href="{{ route('transactions.bill', $t->id) }}" class="p-2 rounded-xl text-indigo-600 hover:bg-indigo-50 transition-colors" title="Lihat Nota">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </a>
                            <a href="{{ route('transactions.pdf', $t->id) }}" class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 transition-colors" title="Download PDF">
                                <i data-lucide="download" class="w-5 h-5"></i>
                            </a>

                            <div class="h-6 w-[1px] bg-slate-100 mx-1"></div>

                            <form action="{{ route('transactions.update', $t->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <select name="status" 
                                        onchange="this.form.submit()"
                                        class="text-xs font-bold bg-slate-50 border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5 pr-8 transition-all">
                                    <option value="proses"  {{ $t->status=='proses'  ? 'selected' : '' }}>Set Proses</option>
                                    <option value="selesai" {{ $t->status=='selesai' ? 'selected' : '' }}>Set Selesai</option>
                                    <option value="diambil" {{ $t->status=='diambil' ? 'selected' : '' }}>Set Diambil</option>
                                </select>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                        <div class="flex flex-col items-center">
                            <i data-lucide="search-x" class="w-12 h-12 mb-3 text-slate-200"></i>
                            <p class="font-medium">Belum ada transaksi ditemukan</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
