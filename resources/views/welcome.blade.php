<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi & Pengelolaan Kas RT</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'sans-serif'],
                        },
                    }
                }
            }
        </script>
    @endif
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 antialiased selection:bg-blue-600 selection:text-white min-h-screen flex flex-col justify-between">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-slate-900/80 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- BRANDING LOGO -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center font-extrabold text-white text-xl shadow-lg shadow-blue-500/20 group-hover:scale-105 transition-transform">
                    RT
                </div>
                <div>
                    <span class="text-lg font-bold bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent">SIP-RT</span>
                    <span class="block text-[10px] uppercase tracking-wider font-semibold text-blue-400">Sistem Pengelolaan RT</span>
                </div>
            </a>

            <!-- NAVIGATION LINKS -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                <a href="#beranda" class="hover:text-blue-400 transition-colors">Beranda</a>
                <a href="#fitur" class="hover:text-blue-400 transition-colors">Fitur Utama</a>
                <a href="#keuangan" class="hover:text-blue-400 transition-colors">Cashflow Kas</a>
                <a href="#peran" class="hover:text-blue-400 transition-colors">Hak Akses</a>
            </nav>

            <!-- AUTH BUTTONS -->
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold text-sm shadow-lg shadow-blue-600/30 transition-all hover:shadow-blue-600/50 flex items-center gap-2">
                            <span>📊 Buka Dashboard</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl border border-slate-700 hover:border-slate-500 text-slate-200 hover:text-white font-medium text-sm transition-all bg-slate-800/50 hover:bg-slate-800">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-medium text-sm shadow-md shadow-blue-600/20 transition-all">
                                Daftar Warga
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

        </div>
    </header>

    <!-- HERO SECTION -->
    <section id="beranda" class="relative pt-12 pb-20 lg:pt-20 lg:pb-32 overflow-hidden">
        <!-- Background Glow Deco -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-600/15 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute top-1/3 right-10 w-[350px] h-[350px] bg-indigo-600/10 blur-[100px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            <!-- BADGE -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-blue-500/30 bg-blue-500/10 text-blue-400 text-xs font-semibold uppercase tracking-wider mb-8 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-ping"></span>
                Sistem Terpadu RT • Akuntabel & Transparan
            </div>

            <!-- MAIN TITLE -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-tight max-w-5xl mx-auto">
                Pengelolaan Kas, Administrasi, & Iuran RT <span class="bg-gradient-to-r from-blue-400 via-indigo-300 to-purple-400 bg-clip-text text-transparent">Dalam Satu Pintu</span>
            </h1>

            <!-- SUBTITLE -->
            <p class="mt-6 text-lg sm:text-xl text-slate-400 max-w-3xl mx-auto font-normal leading-relaxed">
                Platform modern pengelolaan lingkungan RT. Pantau saldo kas real-time, transparansi iuran per KK, serta kemudahan administrasi surat-menyurat dengan verifikasi berjenjang.
            </p>

            <!-- CALL TO ACTION BUTTONS -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-base shadow-xl shadow-blue-600/30 hover:shadow-blue-600/50 transition-all flex items-center justify-center gap-3">
                        <span>Masuk ke Dashboard Sistem</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-base shadow-xl shadow-blue-600/30 hover:shadow-blue-600/50 transition-all flex items-center justify-center gap-3">
                        <span>Login Pengurus & Warga</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </a>
                    <a href="#fitur" class="w-full sm:w-auto px-8 py-4 rounded-xl border border-slate-700 bg-slate-800/60 hover:bg-slate-800 text-slate-200 font-semibold text-base transition-all">
                        Pelajari Fitur
                    </a>
                @endauth
            </div>

            <!-- METRIC HIGHLIGHT CARDS -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
                <div class="bg-slate-800/40 border border-slate-800 rounded-2xl p-5 backdrop-blur-sm">
                    <div class="text-3xl font-extrabold text-blue-400">100%</div>
                    <div class="text-xs text-slate-400 mt-1 font-medium">Transparansi Keuangan</div>
                </div>
                <div class="bg-slate-800/40 border border-slate-800 rounded-2xl p-5 backdrop-blur-sm">
                    <div class="text-3xl font-extrabold text-emerald-400">Real-Time</div>
                    <div class="text-xs text-slate-400 mt-1 font-medium">Perhitungan Saldo Kas</div>
                </div>
                <div class="bg-slate-800/40 border border-slate-800 rounded-2xl p-5 backdrop-blur-sm">
                    <div class="text-3xl font-extrabold text-indigo-400">Per KK</div>
                    <div class="text-xs text-slate-400 mt-1 font-medium">Rekapitulasi Iuran Warga</div>
                </div>
                <div class="bg-slate-800/40 border border-slate-800 rounded-2xl p-5 backdrop-blur-sm">
                    <div class="text-3xl font-extrabold text-purple-400">PDF & Excel</div>
                    <div class="text-xs text-slate-400 mt-1 font-medium">Laporan Otomatis</div>
                </div>
            </div>

        </div>
    </section>

    <!-- FITUR UTAMA SECTION -->
    <section id="fitur" class="py-20 bg-slate-950/60 border-y border-slate-800/80 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-semibold text-blue-400 uppercase tracking-widest mb-3">Modul & Layanan</h2>
                <p class="text-3xl sm:text-4xl font-extrabold text-white">Fitur Unggulan Sistem Pengelolaan RT</p>
                <p class="text-slate-400 mt-3 text-base">Dirancang khusus untuk mendukung operasional kerja Ketua RT, Bendahara, Sekretaris, Ketua Blok, hingga Warga.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- CARD 1: CASHFLOW & KAS -->
                <div id="keuangan" class="bg-slate-900/90 border border-slate-800 rounded-2xl p-7 hover:border-blue-500/50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-blue-600/10 border border-blue-500/20 text-blue-400 flex items-center justify-center text-2xl mb-5 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        💰
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Cashflow & Saldo Kas RT</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Pencatatan dana masuk dan pengeluaran secara terstruktur. Saldo dihitung otomatis tanpa input manual untuk mencegah manipulasi data.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-300">
                        <li class="flex items-center gap-2">
                            <span class="text-blue-400">✓</span> Sumber Dana (CSR, Sumbangan, Warga)
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-blue-400">✓</span> Upload Bukti Transaksi Wajib
                        </li>
                    </ul>
                </div>

                <!-- CARD 2: IURAN PER KK -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-7 hover:border-emerald-500/50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-600/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-2xl mb-5 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        💳
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Tagihan & Iuran per KK</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Pencatatan iuran berbasis Kepala Keluarga (KK). Pembayaran iuran yang berhasil otomatis tercatat langsung ke kas pemasukan.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-300">
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400">✓</span> Status Tagihan Lunas / Belum Lunas
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400">✓</span> Otomatisasi Kas Masuk
                        </li>
                    </ul>
                </div>

                <!-- CARD 3: ADMINISTRASI SURAT -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-7 hover:border-purple-500/50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-purple-600/10 border border-purple-500/20 text-purple-400 flex items-center justify-center text-2xl mb-5 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        📥
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Administrasi Surat Menyurat</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Pengelolaan agenda surat masuk dan surat keluar lingkungan RT. Penomoran otomatis serta pengarsipan digital dokumen secara tertib.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-300">
                        <li class="flex items-center gap-2">
                            <span class="text-purple-400">✓</span> Penomoran Surat Otomatis
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-purple-400">✓</span> Pengarsipan Scan Dokumen
                        </li>
                    </ul>
                </div>

                <!-- CARD 4: DATA KK & BLOK -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-7 hover:border-amber-500/50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-amber-600/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-2xl mb-5 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                        👨‍👩‍👧
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Manajemen Blok & KK</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Pendataan wilayah RT berbasis Blok dan Rumah Tangga (KK). Memudahkan pemetaan warga, kontak darurat, dan koordinasi antar perwakilan blok.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-300">
                        <li class="flex items-center gap-2">
                            <span class="text-amber-400">✓</span> Struktur Terkait Perwakilan Blok
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-amber-400">✓</span> Data Rumah & Kontak KK
                        </li>
                    </ul>
                </div>

                <!-- CARD 5: LAPORAN & EXPORT -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-7 hover:border-indigo-500/50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-indigo-600/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center text-2xl mb-5 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        📊
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Laporan PDF & Excel</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Cetak rekapitulasi keuangan kas secara instan. Dilengkapi penyaringan berbasis tanggal, jenis transaksi, kategori, sumber dana, dan blok.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-300">
                        <li class="flex items-center gap-2">
                            <span class="text-indigo-400">✓</span> Export Dokumen PDF Landscape
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-indigo-400">✓</span> Export Spreadsheet Excel (.xlsx)
                        </li>
                    </ul>
                </div>

                <!-- CARD 6: VERIFIKASI BERJENJANG -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-7 hover:border-rose-500/50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-rose-600/10 border border-rose-500/20 text-rose-400 flex items-center justify-center text-2xl mb-5 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                        ✅
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Verifikasi & Approval Berjenjang</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Alur persetujuan pengajuan dana dan iuran dari Ketua Blok disetujui Bendahara hingga Ketua RT secara transparan dan terekam.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-300">
                        <li class="flex items-center gap-2">
                            <span class="text-rose-400">✓</span> Validasi Bertingkat Pengurus
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-rose-400">✓</span> Hak Akses Role Terbuka
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION PERAN / HAK AKSES -->
    <section id="peran" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-xs font-semibold text-blue-400 uppercase tracking-widest mb-3">Struktur Pengguna</h2>
            <p class="text-3xl sm:text-4xl font-extrabold text-white">Pembagian Peran & Hak Akses</p>
            <p class="text-slate-400 mt-3 text-base">Setiap entitas pengurus dan warga memiliki panel kerja terspesialisasi sesuai wewenang.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            
            <div class="bg-slate-800/30 border border-slate-800 p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2">👑</div>
                <h4 class="font-bold text-white text-base">Superadmin</h4>
                <p class="text-xs text-slate-400 mt-1">Kelola master data, pengguna, dan konfigurasi umum sistem.</p>
            </div>

            <div class="bg-slate-800/30 border border-slate-800 p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2">🎖️</div>
                <h4 class="font-bold text-white text-base">Ketua RT</h4>
                <p class="text-xs text-slate-400 mt-1">Monitoring pengeluaran, persetujuan transaksi & pengawasan laporan.</p>
            </div>

            <div class="bg-slate-800/30 border border-slate-800 p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2">💰</div>
                <h4 class="font-bold text-white text-base">Bendahara</h4>
                <p class="text-xs text-slate-400 mt-1">Input transaksi kas, verifikasi iuran warga, dan kelola laporan keuangan.</p>
            </div>

            <div class="bg-slate-800/30 border border-slate-800 p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2">✍️</div>
                <h4 class="font-bold text-white text-base">Sekretaris</h4>
                <p class="text-xs text-slate-400 mt-1">Pengelolaan agenda surat masuk & surat keluar lingkungan RT.</p>
            </div>

            <div class="bg-slate-800/30 border border-slate-800 p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2">🏠</div>
                <h4 class="font-bold text-white text-base">Ketua Blok / Warga</h4>
                <p class="text-xs text-slate-400 mt-1">Pengajuan iuran blok serta pemantauan status tagihan mandiri.</p>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-slate-800 bg-slate-950 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-300">
                <div class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center font-extrabold text-white text-xs">RT</div>
                <span>Sistem Informasi & Pengelolaan Kas RT</span>
            </div>

            <div class="text-xs text-slate-500">
                &copy; {{ date('Y') }} Sistem Pengelolaan Kas RT. Hak Cipta Dilindungi.
            </div>

        </div>
    </footer>

</body>
</html>
