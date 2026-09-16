<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-white tracking-tight">Masuk ke Sistem RT</h2>
        <p class="mt-2 text-xs text-slate-400">Silakan masukkan email dan kata sandi akun Anda untuk mengakses dashboard.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@rt.test" class="w-full bg-slate-950/70 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-400" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-blue-400 hover:text-blue-300 transition-colors" href="{{ route('password.request') }}">
                        Lupa Kata Sandi?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="w-full bg-slate-950/70 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-400" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-800 bg-slate-950 text-blue-600 focus:ring-blue-500 focus:ring-offset-slate-900">
                <span class="ms-2 text-xs text-slate-400">Ingat Saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-sm shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 transition-all flex items-center justify-center gap-2">
                <span>Masuk ke Dashboard</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="mt-6 border-t border-slate-800/80 pt-4 text-center">
            <p class="text-xs text-slate-400">
                Belum memiliki akun warga? 
                <a href="{{ route('register') }}" class="font-semibold text-blue-400 hover:text-blue-300 transition-colors">
                    Daftar di sini
                </a>
            </p>
        </div>
    @endif

    <!-- DEMO ACCOUNTS HELPER BOX -->
    <div class="mt-6 p-4 rounded-xl bg-slate-950/60 border border-slate-800 text-xs">
        <p class="font-semibold text-slate-300 mb-2 flex items-center gap-1.5">
            <span>💡</span> Akun Demo Uji Coba (Password: <code class="text-blue-400">password</code>):
        </p>
        <div class="grid grid-cols-2 gap-1.5 text-[11px] text-slate-400">
            <div>• Ketua RT: <span class="text-slate-200">ketuart@rt.test</span></div>
            <div>• Bendahara: <span class="text-slate-200">bendahara@rt.test</span></div>
            <div>• Sekretaris: <span class="text-slate-200">sekretaris@rt.test</span></div>
            <div>• Ketua Blok: <span class="text-slate-200">ketuablock@rt.test</span></div>
            <div class="col-span-2">• Warga: <span class="text-slate-200">warga@rt.test</span></div>
        </div>
    </div>
</x-guest-layout>
