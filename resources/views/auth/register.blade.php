<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Daftar Akun Baru</h2>
        <p class="text-slate-500 text-xs mt-1">Buat akun admin baru untuk mengelola LaundryLux.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </div>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       class="block w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
                       placeholder="Masukkan nama lengkap Anda" required autofocus autocomplete="name">
            </div>
            @if ($errors->has('name'))
                <p class="text-xs text-rose-500 font-semibold mt-1.5 flex items-center gap-1">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $errors->first('name') }}
                </p>
            @endif
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                </div>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="block w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
                       placeholder="nama@email.com" required autocomplete="username">
            </div>
            @if ($errors->has('email'))
                <p class="text-xs text-rose-500 font-semibold mt-1.5 flex items-center gap-1">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $errors->first('email') }}
                </p>
            @endif
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                </div>
                <input type="password" id="password" name="password"
                       class="block w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
                       placeholder="••••••••" required autocomplete="new-password">
            </div>
            @if ($errors->has('password'))
                <p class="text-xs text-rose-500 font-semibold mt-1.5 flex items-center gap-1">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $errors->first('password') }}
                </p>
            @endif
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Konfirmasi Kata Sandi</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="lock-keyhole" class="w-4 h-4"></i>
                </div>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="block w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
                       placeholder="••••••••" required autocomplete="new-password">
            </div>
            @if ($errors->has('password_confirmation'))
                <p class="text-xs text-rose-500 font-semibold mt-1.5 flex items-center gap-1">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $errors->first('password_confirmation') }}
                </p>
            @endif
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors" href="{{ route('login') }}">
                Sudah punya akun?
            </a>
            
            <button type="submit" class="btn-primary py-2.5 px-6 text-sm">
                Daftar Akun
            </button>
        </div>
    </form>
</x-guest-layout>
