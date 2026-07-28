<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Selamat Datang Kembali</h2>
        <p class="text-slate-500 text-xs mt-1">Silakan masuk ke akun Anda untuk mengelola LaundryLux.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                </div>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="block w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
                       placeholder="nama@email.com" required autofocus autocomplete="username">
            </div>
            @if ($errors->has('email'))
                <p class="text-xs text-rose-500 font-semibold mt-1.5 flex items-center gap-1">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $errors->first('email') }}
                </p>
            @endif
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                </div>
                <input type="password" id="password" name="password"
                       class="block w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all"
                       placeholder="••••••••" required autocomplete="current-password">
            </div>
            @if ($errors->has('password'))
                <p class="text-xs text-rose-500 font-semibold mt-1.5 flex items-center gap-1">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $errors->first('password') }}
                </p>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded-lg border-slate-200 text-indigo-600 shadow-sm focus:ring-2 focus:ring-indigo-500/20 w-4 h-4">
                <span class="ms-2 text-xs font-bold text-slate-500 select-none">Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full btn-primary py-3 text-sm">
                Masuk ke Dasbor
            </button>
        </div>
    </form>
</x-guest-layout>
