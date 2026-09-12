<x-guest-layout>

    <div class="mb-8">

        <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
            Selamat Datang
        </p>

        <h1 class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900">
            Masuk ke Akun
        </h1>

        <p class="mt-3 text-base sm:text-lg leading-relaxed text-gray-600">
            Silakan masukkan email dan password untuk melanjutkan.
        </p>

    </div>


    {{-- SESSION STATUS --}}
    <x-auth-session-status
        class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-base text-green-800"
        :status="session('status')"
    />


    <form method="POST" action="{{ route('login') }}" class="space-y-5">

        @csrf


        {{-- EMAIL --}}
        <div>

            <label
                for="email"
                class="mb-2 block text-base font-semibold text-gray-800"
            >
                Email
            </label>


            <div class="relative">

                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-xl text-gray-400">
                    ✉️
                </div>


                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan email Anda"
                    class="block min-h-14 w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-4 text-base text-gray-900 shadow-sm
                           placeholder:text-gray-400
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                >

            </div>


            @error('email')

                <p class="mt-2 text-sm font-medium text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- PASSWORD --}}
        <div
            x-data="{ showPassword: false }"
        >

            <label
                for="password"
                class="mb-2 block text-base font-semibold text-gray-800"
            >
                Password
            </label>


            <div class="relative">

                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-xl text-gray-400">
                    🔒
                </div>


                <input
                    id="password"
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password Anda"
                    class="block min-h-14 w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-14 text-base text-gray-900 shadow-sm
                           placeholder:text-gray-400
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                >


                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 flex min-w-14 items-center justify-center text-xl text-gray-500"
                    aria-label="Tampilkan atau sembunyikan password"
                >

                    <span x-show="!showPassword">
                        👁️
                    </span>

                    <span x-show="showPassword" x-cloak>
                        🙈
                    </span>

                </button>

            </div>


            @error('password')

                <p class="mt-2 text-sm font-medium text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- REMEMBER --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <label
                for="remember_me"
                class="flex min-h-11 cursor-pointer items-center gap-3"
            >

                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                >

                <span class="text-base text-gray-700">
                    Ingat saya
                </span>

            </label>


            @if (Route::has('password.request'))

                <a
                    href="{{ route('password.request') }}"
                    class="text-base font-semibold text-blue-600 hover:text-blue-700 hover:underline"
                >
                    Lupa password?
                </a>

            @endif

        </div>


        {{-- LOGIN BUTTON --}}
        <button
            type="submit"
            class="inline-flex min-h-14 w-full items-center justify-center rounded-xl bg-blue-600 px-6 py-3.5 text-lg font-bold text-white shadow-md transition
                   hover:bg-blue-700
                   active:bg-blue-800
                   focus:outline-none focus:ring-4 focus:ring-blue-200"
        >
            Masuk
        </button>


        {{-- BANTUAN --}}
        <div class="rounded-xl bg-gray-50 px-4 py-4 text-center">

            <p class="text-sm sm:text-base text-gray-600">
                Mengalami kesulitan masuk?
            </p>

            <p class="mt-1 text-sm font-semibold text-gray-800">
                Silakan hubungi pengurus RT.
            </p>

        </div>

    </form>

</x-guest-layout>