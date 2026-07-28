@extends('admin.layouts.admin')

@section('content')
<div class="mb-10">
    <a href="{{ route('packages.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Layanan
    </a>
    <h2 class="text-3xl font-bold tracking-tight text-slate-800">Edit <span class="gradient-text">Paket Laundry</span></h2>
    <p class="text-slate-500 mt-1">Perbarui tarif atau nama paket layanan laundry.</p>
</div>

<div class="max-w-2xl">
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

        <form action="{{ route('packages.update', $package->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')
            
            <div>
                <label for="name" class="flex items-center gap-1.5 text-sm font-bold text-slate-700 mb-2">
                    <i data-lucide="package" class="w-4 h-4 text-slate-400"></i> Nama Paket
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $package->name) }}"
                       class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
                       placeholder="Masukkan nama paket" required>
            </div>

            <div>
                <label for="price" class="flex items-center gap-1.5 text-sm font-bold text-slate-700 mb-2">
                    <i data-lucide="tag" class="w-4 h-4 text-slate-400"></i> Harga Satuan (Rupiah)
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400 font-bold text-sm pointer-events-none">Rp</span>
                    <input type="number" id="price" name="price" value="{{ old('price', $package->price) }}"
                           class="block w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
                           placeholder="Contoh: 10000" required>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-50">
                <button type="submit" class="btn-primary py-2.5 px-6 text-sm">
                    Update Paket
                </button>
                <a href="{{ route('packages.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-2.5 rounded-2xl font-bold text-sm text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
