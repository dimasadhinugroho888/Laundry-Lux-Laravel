@extends('admin.layouts.admin')

@section('content')
<div class="mb-10">
    <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Transaksi
    </a>
    <h2 class="text-3xl font-bold tracking-tight text-slate-800">Tambah <span class="gradient-text">Transaksi Baru</span></h2>
    <p class="text-slate-500 mt-1">Buat pesanan laundry baru untuk pelanggan.</p>
</div>

<div class="max-w-4xl">
    <div class="premium-card p-8 bg-white border-none shadow-sm">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex flex-col gap-1">
                <div class="flex items-center gap-2 font-bold">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    <span>Terdapat beberapa kesalahan:</span>
                </div>
                <ul class="list-disc list-inside text-sm mt-1 text-rose-600 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Customer Section -->
            <div>
                <label for="customer_id" class="flex items-center gap-1.5 text-sm font-bold text-slate-700 mb-2">
                    <i data-lucide="user" class="w-4 h-4 text-slate-400"></i> Pilih Pelanggan
                </label>
                <div class="relative">
                    <select name="customer_id" id="customer_id" 
                            class="block w-full px-4 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all appearance-none"
                            required>
                        <option value="">-- Pilih Customer --</option>
                        @foreach ($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->phone }})</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100 my-8">

            <!-- Packages List Section -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="package" class="w-5 h-5 text-indigo-600"></i> Paket Laundry yang Dipilih
                    </h3>
                </div>

                <div id="package-wrapper" class="space-y-3">
                    <div class="grid grid-cols-12 gap-3 items-center package-row bg-slate-50/50 p-4 rounded-2xl border border-slate-100">
                        <!-- Select Package -->
                        <div class="col-span-12 md:col-span-7 relative">
                            <select name="packages[0][id]" 
                                    class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none"
                                    required>
                                <option value="">-- Pilih Paket --</option>
                                @foreach ($packages as $p)
                                    <option value="{{ $p->id }}">
                                        {{ $p->name }} (Rp {{ number_format($p->price, 0, ',', '.') }}/{{ $p->unit ?? 'Kg' }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="col-span-8 md:col-span-3">
                            <input type="number" name="packages[0][qty]" 
                                   class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                                   placeholder="Qty" min="1" required>
                        </div>

                        <!-- Remove Button -->
                        <div class="col-span-4 md:col-span-2 text-right">
                            <button type="button" 
                                    class="w-full md:w-auto inline-flex items-center justify-center p-3 rounded-xl text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-colors remove-row d-none">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" id="add-package" 
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl font-bold text-sm text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Layanan Lain
                    </button>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="flex items-center gap-3 pt-6 border-t border-slate-50">
                <button type="submit" class="btn-primary py-2.5 px-6 text-sm">
                    Simpan Transaksi
                </button>
                <a href="{{ route('transactions.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-2.5 rounded-2xl font-bold text-sm text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Dynamic Row Script --}}
<script>
let index = 1;

document.getElementById('add-package').addEventListener('click', function () {
    let wrapper = document.getElementById('package-wrapper');

    let row = `
    <div class="grid grid-cols-12 gap-3 items-center package-row bg-slate-50/50 p-4 rounded-2xl border border-slate-100 animate-in fade-in slide-in-from-top-2 duration-300">
        <!-- Select Package -->
        <div class="col-span-12 md:col-span-7 relative">
            <select name="packages[${index}][id]" 
                    class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none"
                    required>
                <option value="">-- Pilih Paket --</option>
                @foreach ($packages as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->name }} (Rp {{ number_format($p->price, 0, ',', '.') }}/{{ $p->unit ?? 'Kg' }})
                    </option>
                @endforeach
            </select>
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                <i data-lucide="chevron-down" class="w-4 h-4"></i>
            </div>
        </div>

        <!-- Quantity -->
        <div class="col-span-8 md:col-span-3">
            <input type="number" name="packages[${index}][qty]" 
                   class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                   placeholder="Qty" min="1" required>
        </div>

        <!-- Remove Button -->
        <div class="col-span-4 md:col-span-2 text-right">
            <button type="button" 
                    class="w-full md:w-auto inline-flex items-center justify-center p-3 rounded-xl text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-colors remove-row">
                <i data-lucide="trash-2" class="w-5 h-5"></i>
            </button>
        </div>
    </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', row);
    lucide.createIcons();
    index++;
});

document.addEventListener('click', function (e) {
    let button = e.target.closest('.remove-row');
    if (button) {
        button.closest('.package-row').remove();
    }
});
</script>
@endsection
