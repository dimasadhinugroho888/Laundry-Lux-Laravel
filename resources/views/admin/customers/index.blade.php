@extends('admin.layouts.admin')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <h2 class="text-3xl font-bold tracking-tight text-slate-800">Data <span class="gradient-text">Pelanggan</span></h2>
        <p class="text-slate-500 mt-1">Kelola data pelanggan setia Laundry Lux.</p>
    </div>
    <a href="{{ route('customers.create') }}" class="btn-primary">
        <i data-lucide="user-plus" class="w-5 h-5 mr-2"></i>
        Tambah Pelanggan
    </a>
</div>

<div class="premium-card overflow-hidden border-none shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">#</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400">Nama Lengkap</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
            @forelse ($customers as $c)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-5 text-sm font-medium text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                                {{ substr($c->name, 0, 1) }}
                            </div>
                            <span class="font-bold text-slate-700">{{ $c->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('customers.edit', $c->id) }}" class="p-2 rounded-xl text-amber-600 hover:bg-amber-50 transition-colors" title="Edit Data">
                                <i data-lucide="edit-3" class="w-5 h-5"></i>
                            </a>
                            <form action="{{ route('customers.destroy', $c->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 transition-colors" onclick="return confirm('Yakin hapus?')" title="Hapus Data">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-slate-400">
                        <div class="flex flex-col items-center">
                            <i data-lucide="users" class="w-12 h-12 mb-3 text-slate-200"></i>
                            <p class="font-medium">Belum ada data pelanggan</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
