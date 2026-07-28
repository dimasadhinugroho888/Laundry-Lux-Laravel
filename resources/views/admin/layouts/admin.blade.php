<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laundry Lux') }} | Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#f8fafc] overflow-x-hidden">

    <!-- Sidebar Overlay (mobile) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/30 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed top-0 left-0 z-40 h-screen transition-transform duration-300 ease-in-out border-r border-gray-100 glass w-64"
    >
        <div class="flex flex-col h-full px-4 py-6">
            <!-- Logo -->
            <div class="flex items-center gap-3 px-2 mb-10">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-400 text-white shadow-lg shadow-indigo-200">
                    <i data-lucide="waves" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-800">Laundry<span class="text-indigo-600">Lux</span></h1>
                    <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 -mt-1">Premium System</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 space-y-1">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span class="font-semibold">Dashboard</span>
                </a>
                
                <a href="{{ route('customers.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('customers.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span class="font-semibold">Pelanggan</span>
                </a>

                <a href="{{ route('packages.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('packages.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span class="font-semibold">Layanan & Paket</span>
                </a>

                <a href="{{ route('transactions.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('transactions.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                    <span class="font-semibold">Transaksi</span>
                </a>

                <a href="{{ route('reports.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('reports.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
                    <i data-lucide="bar-chart-2" class="w-5 h-5"></i>
                    <span class="font-semibold">Laporan</span>
                </a>
            </nav>

            <!-- Bottom Profile -->
            <div class="pt-6 border-t border-gray-100">
                <div class="flex items-center gap-3 p-2 rounded-2xl bg-slate-50 border border-gray-200 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-400 flex items-center justify-center text-white font-bold text-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate">Administrator</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex w-full items-center gap-3 px-4 py-3 rounded-2xl text-rose-500 hover:bg-rose-50 transition-all duration-300 font-semibold group">
                        <i data-lucide="log-out" class="w-5 h-5 transition-transform group-hover:translate-x-1"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main id="main-content" class="transition-all duration-300 min-h-screen ml-64">
        <!-- Header -->
        <header class="sticky top-0 z-30 flex items-center justify-between px-8 py-4 glass border-b border-gray-100">
            <button onclick="toggleSidebar()" class="p-2 rounded-xl text-slate-500 hover:bg-gray-100 transition-colors" title="Toggle Sidebar">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex flex-col items-end">
                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Waktu Sekarang</p>
                    <p class="text-sm font-semibold text-slate-600">{{ now()->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="p-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-500">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-8 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        lucide.createIcons();

        // Sidebar state — persisted via localStorage
        let sidebarOpen = localStorage.getItem('sidebarOpen') !== 'false';

        function applySidebarState() {
            const sidebar = document.getElementById('sidebar');
            const main    = document.getElementById('main-content');
            const overlay = document.getElementById('sidebar-overlay');

            if (sidebarOpen) {
                sidebar.style.transform = 'translateX(0)';
                main.style.marginLeft   = '256px';
                overlay.classList.add('hidden');
            } else {
                sidebar.style.transform = 'translateX(-100%)';
                main.style.marginLeft   = '0px';
                // show overlay on mobile only
                if (window.innerWidth < 1024) {
                    overlay.classList.remove('hidden');
                }
            }
        }

        function toggleSidebar() {
            sidebarOpen = !sidebarOpen;
            localStorage.setItem('sidebarOpen', sidebarOpen);
            applySidebarState();
        }

        // Apply on load
        applySidebarState();

        // Handle window resize
        window.addEventListener('resize', applySidebarState);
    </script>
</body>
</html>
