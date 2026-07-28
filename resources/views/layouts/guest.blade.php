<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>LaundryLux — Smart Laundry System</title>

        <!-- Scripts & Styles via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans text-slate-900 antialiased bg-gray-50 relative min-h-screen flex flex-col justify-center items-center p-6 overflow-hidden">
        
        <!-- Glowing background blobs -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
            <div class="absolute -top-[10%] -left-[10%] w-[450px] h-[450px] rounded-full bg-indigo-400/20 blur-[100px]"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[450px] h-[450px] rounded-full bg-pink-400/15 blur-[100px]"></div>
        </div>

        <div class="w-full max-w-md z-10">
            <!-- Logo & Brand -->
            <div class="text-center mb-8">
                <a href="/" class="inline-flex flex-col items-center gap-2.5 group">
                    <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-indigo-400 text-white shadow-lg shadow-indigo-200 group-hover:scale-105 transition-transform duration-300">
                        <i data-lucide="waves" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-800">Laundry<span class="text-indigo-600">Lux</span></h1>
                        <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 -mt-0.5">Smart Laundry System</p>
                    </div>
                </a>
            </div>

            <!-- Card Content -->
            <div class="premium-card p-8 bg-white border-none shadow-sm rounded-3xl">
                {{ $slot }}
            </div>
        </div>

        <script>
            lucide.createIcons();
        </script>
    </body>
</html>
