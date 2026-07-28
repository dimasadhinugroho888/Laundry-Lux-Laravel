@extends('admin.layouts.admin')

@section('content')
<div class="mb-10">
    <a href="{{ route('customers.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Database
    </a>
    <h2 class="text-3xl font-bold tracking-tight text-slate-800">Tambah <span class="gradient-text">Pelanggan</span></h2>
    <p class="text-slate-500 mt-1">Daftarkan pelanggan baru ke database LaundryLux.</p>
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

        <form action="{{ route('customers.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="name" class="flex items-center gap-1.5 text-sm font-bold text-slate-700 mb-2">
                    <i data-lucide="user" class="w-4 h-4 text-slate-400"></i> Nama Lengkap
                </label>
                <input type="text" id="name" name="name" 
                       class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
                       placeholder="Masukkan nama lengkap pelanggan" required>
            </div>

            <div>
                <label for="phone" class="flex items-center gap-1.5 text-sm font-bold text-slate-700 mb-2">
                    <i data-lucide="phone" class="w-4 h-4 text-slate-400"></i> Nomor WhatsApp
                </label>
                <input type="text" id="phone" name="phone" 
                       class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
                       placeholder="Contoh: 08123456789" required>
            </div>

            <div>
                <label for="address" class="flex items-center gap-1.5 text-sm font-bold text-slate-700 mb-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-slate-400"></i> Alamat Lengkap
                </label>
                <textarea id="address" name="address" rows="3"
                          class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
                          placeholder="Masukkan alamat lengkap rumah pelanggan" required></textarea>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-50">
                <button type="submit" class="btn-primary py-2.5 px-6 text-sm">
                    Simpan Pelanggan
                </button>
                <a href="{{ route('customers.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-2.5 rounded-2xl font-bold text-sm text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
