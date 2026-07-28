<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LaundryLux — Smart Laundry SaaS System</title>
    
    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-slate-900 antialiased selection:bg-indigo-500 selection:text-white overflow-x-hidden">

    <!-- Glowing Background blobs -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[600px] pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-[10%] left-[10%] w-[350px] h-[350px] rounded-full bg-indigo-400/20 blur-[80px]"></div>
        <div class="absolute -top-[5%] right-[10%] w-[350px] h-[350px] rounded-full bg-pink-400/15 blur-[80px]"></div>
    </div>

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 w-full border-b border-gray-100 bg-white/70 backdrop-blur-md transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5 group">
                <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-400 text-white shadow-lg shadow-indigo-200 group-hover:scale-105 transition-transform">
                    <i data-lucide="waves" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-xl font-bold tracking-tight text-slate-800">Laundry<span class="text-indigo-600">Lux</span></span>
                    <span class="block text-[8px] uppercase tracking-widest font-bold text-slate-400 -mt-1">Smart SaaS System</span>
                </div>
            </a>
            
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary py-2 px-5 text-sm">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl font-semibold text-sm text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/50 transition-all duration-300">
                        Masuk Dasbor <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative pt-24 pb-20 md:pt-32 md:pb-28 z-10">
        <div class="container mx-auto px-6 text-center max-w-4xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-xs font-bold text-indigo-600 uppercase tracking-wider mb-6 animate-pulse">
                <i data-lucide="server" class="w-3.5 h-3.5"></i> Local SaaS Deployment
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-slate-900 leading-tight md:leading-none">
                Sistem Operasional Laundry Pintar <br class="hidden md:block">
                untuk <span class="gradient-text">Outlet & Cabang</span> Anda
            </h1>
            <p class="mt-6 text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed">
                LaundryLux berjalan sebagai sistem SaaS lokal di setiap outlet laundry untuk performa tanpa lag, 
                mempermudah kasir melayani transaksi, mengelola database pelanggan, dan melacak status pakaian secara real-time.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('dashboard') }}" class="btn-primary w-full sm:w-auto">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-2"></i> Masuk Dasbor Outlet
                </a>
                <a href="#fitur" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 rounded-2xl font-semibold text-slate-600 border border-gray-200 hover:bg-slate-50 hover:border-gray-300 transition-all duration-300 active:scale-95">
                    Pelajari Fitur SaaS
                </a>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section id="fitur" class="py-20 bg-white border-y border-gray-100 relative">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-slate-800">Dirancang untuk Skala <span class="text-indigo-600">Multi-Outlet</span></h2>
                <p class="text-slate-500 mt-2">Solusi SaaS lokal dengan keandalan operasional tingkat tinggi untuk industri laundry.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="premium-card p-8 bg-gradient-to-b from-slate-50/50 to-white">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 shadow-inner">
                        <i data-lucide="terminal" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Deployment Lokal</h3>
                    <p class="text-slate-500 mt-3 leading-relaxed text-sm">
                        Sistem berjalan di jaringan lokal outlet dengan latensi sangat rendah, menjamin pelayanan kasir tetap cepat meski internet sedang lambat.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="premium-card p-8 bg-gradient-to-b from-slate-50/50 to-white">
                    <div class="w-12 h-12 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center mb-6 shadow-inner">
                        <i data-lucide="shield-check" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Otonomi Data Cabang</h3>
                    <p class="text-slate-500 mt-3 leading-relaxed text-sm">
                        Setiap kasir memiliki akses langsung ke manajemen pelanggan cabang lokal dan transaksi harian tanpa khawatir data bocor ke cabang lain.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="premium-card p-8 bg-gradient-to-b from-slate-50/50 to-white">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6 shadow-inner">
                        <i data-lucide="message-square" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Notifikasi WA & Laporan</h3>
                    <p class="text-slate-500 mt-3 leading-relaxed text-sm">
                        Kirim notifikasi pengambilan ke WhatsApp pelanggan dengan mudah, serta cetak laporan transaksi dan nota pembayaran dalam bentuk PDF atau Excel secara lokal.
                    </p>
                </div>
            </div>
        </div>
    </section>



    <!-- FOOTER -->
    <footer class="py-8 text-center text-sm text-slate-400 border-t border-gray-100 bg-white">
        <div class="container mx-auto px-6">
            <p>
                © {{ date('Y') }} LaundryLux. Made with ❤️ by 
                <a href="https://portofoliodimasadhinugroho.great-site.net/" target="_blank" class="font-bold text-indigo-600 hover:underline">
                    Dimas Adhi Nugroho
                </a> 
                • Built with Laravel & Tailwind CSS
            </p>
        </div>
    </footer>

    <!-- FLOATING WHATSAPP -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="https://wa.me/62812XXXXXXX?text=Halo%20Admin%20LaundryLux,%20saya%20ingin%20tanya%20tentang%20layanan%20smart%20laundry."
           target="_blank"
           class="flex w-14 h-14 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full items-center justify-center shadow-lg shadow-emerald-200 hover:scale-110 active:scale-95 transition-all duration-300"
           title="Hubungi Kami via WhatsApp">
            <!-- Custom WhatsApp SVG Icon to prevent font-awesome clash -->
            <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.504-5.727-1.465L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.638 1.977 14.172 1.05 11.58 1.05c-5.44 0-9.866 4.372-9.87 9.802 0 1.726.473 3.417 1.368 4.907L2.122 21.99l6.525-1.706c.001-.001.001-.001.002-.001zm10.748-6.732c-.279-.139-1.646-.807-1.9-.9-.253-.093-.438-.139-.623.139-.184.279-.715.9-.877 1.084-.162.184-.325.208-.604.068-.279-.139-1.18-.435-2.249-1.385-.83-.737-1.39-1.648-1.552-1.927-.162-.279-.017-.43.122-.569.124-.124.279-.325.418-.487.139-.162.186-.279.279-.464.093-.184.047-.348-.023-.487-.069-.139-.623-1.493-.853-2.052-.224-.539-.452-.465-.623-.474-.161-.008-.347-.01-.532-.01s-.488.069-.743.348c-.255.279-.974.95-.974 2.319s.997 2.69 1.137 2.876c.139.186 1.962 2.977 4.753 4.167.663.283 1.181.453 1.585.58.666.21 1.272.18 1.751.109.534-.08 1.646-.668 1.879-1.314.232-.646.232-1.201.162-1.3-.069-.093-.255-.139-.534-.279z"/>
            </svg>
        </a>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
