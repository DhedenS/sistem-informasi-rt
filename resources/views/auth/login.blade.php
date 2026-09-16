<x-guest-layout>

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}
    <div class="mb-7 sm:mb-8">

        <p
            class="
                text-sm
                font-bold
                uppercase
                tracking-wider
                text-blue-600
            "
        >
            Selamat Datang
        </p>


        <h1
            class="
                mt-2
                text-2xl
                font-bold
                tracking-tight
                text-slate-900

                sm:text-3xl
            "
        >
            Masuk ke akun
        </h1>


        <p
            class="
                mt-2
                text-sm
                leading-relaxed
                text-slate-500

                sm:text-base
            "
        >
            Masukkan email dan password Anda untuk mengakses
            Sistem Informasi RT.
        </p>

    </div>



    {{-- ========================================================= --}}
    {{-- SESSION STATUS --}}
    {{-- ========================================================= --}}
    @if (session('status'))

        <div
            class="
                mb-5
                rounded-xl
                border
                border-green-200
                bg-green-50
                px-4
                py-3
                text-sm
                font-medium
                text-green-700
            "
        >
            {{ session('status') }}
        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- LOGIN FORM --}}
    {{-- ========================================================= --}}
    <form
        method="POST"
        action="{{ route('login') }}"
        class="space-y-5"
    >

        @csrf


        {{-- ===================================================== --}}
        {{-- EMAIL --}}
        {{-- ===================================================== --}}
        <div>

            <label
                for="email"
                class="
                    mb-2
                    block
                    text-sm
                    font-semibold
                    text-slate-700
                "
            >
                Email
            </label>


            <div class="relative">

                {{-- ICON EMAIL --}}
                <div
                    class="
                        pointer-events-none
                        absolute
                        inset-y-0
                        left-0
                        flex
                        items-center
                        pl-4
                    "
                >

                    <svg
                        class="h-5 w-5 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8m-18 8V8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"
                        />

                    </svg>

                </div>


                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="nama@email.com"

                    class="
                        block
                        min-h-14
                        w-full

                        rounded-xl

                        border
                        border-slate-200

                        bg-white

                        py-3
                        pl-12
                        pr-4

                        text-base
                        text-slate-900

                        shadow-sm

                        outline-none

                        placeholder:text-slate-400

                        transition

                        focus:border-blue-500
                        focus:ring-2
                        focus:ring-blue-100
                    "
                >

            </div>


            @error('email')

                <p
                    class="
                        mt-2
                        text-sm
                        font-medium
                        text-red-600
                    "
                >
                    {{ $message }}
                </p>

            @enderror

        </div>



        {{-- ===================================================== --}}
        {{-- PASSWORD --}}
        {{-- ===================================================== --}}
        <div x-data="{ showPassword: false }">

            <label
                for="password"
                class="
                    mb-2
                    block
                    text-sm
                    font-semibold
                    text-slate-700
                "
            >
                Password
            </label>


            <div class="relative">


                {{-- ICON LOCK --}}
                <div
                    class="
                        pointer-events-none
                        absolute
                        inset-y-0
                        left-0
                        flex
                        items-center
                        pl-4
                    "
                >

                    <svg
                        class="h-5 w-5 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2Zm10-10V7a4 4 0 0 0-8 0v4"
                        />

                    </svg>

                </div>


                {{-- INPUT PASSWORD --}}
                <input
                    id="password"

                    :type="showPassword ? 'text' : 'password'"

                    name="password"

                    required

                    autocomplete="current-password"

                    placeholder="Masukkan password"

                    class="
                        block
                        min-h-14
                        w-full

                        rounded-xl

                        border
                        border-slate-200

                        bg-white

                        py-3
                        pl-12
                        pr-14

                        text-base
                        text-slate-900

                        shadow-sm

                        outline-none

                        placeholder:text-slate-400

                        transition

                        focus:border-blue-500
                        focus:ring-2
                        focus:ring-blue-100
                    "
                >



                {{-- SHOW / HIDE PASSWORD --}}
                <button
                    type="button"

                    @click="showPassword = !showPassword"

                    class="
                        absolute
                        right-1
                        top-1/2

                        flex
                        h-12
                        w-12

                        -translate-y-1/2

                        items-center
                        justify-center

                        rounded-xl

                        text-slate-400

                        transition

                        hover:bg-slate-100
                        hover:text-slate-700

                        focus:outline-none
                        focus:ring-2
                        focus:ring-blue-100
                    "

                    aria-label="Tampilkan atau sembunyikan password"
                >


                    {{-- EYE --}}
                    <svg
                        x-show="!showPassword"
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.5 0C21 7.5 17.5 5 12 5S3 7.5 1.5 12C3 16.5 6.5 19 12 19s9-2.5 10.5-7Z"
                        />

                    </svg>


                    {{-- EYE OFF --}}
                    <svg
                        x-cloak
                        x-show="showPassword"

                        class="h-5 w-5"

                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m3 3 18 18M10.6 10.6A2 2 0 0 0 13.4 13.4M9.9 5.1A11.7 11.7 0 0 1 12 5c5.5 0 9 2.5 10.5 7a11 11 0 0 1-2.1 3.6M6.6 6.6A10.4 10.4 0 0 0 1.5 12C3 16.5 6.5 19 12 19a10 10 0 0 0 4.3-.9"
                        />

                    </svg>

                </button>

            </div>


            @error('password')

                <p
                    class="
                        mt-2
                        text-sm
                        font-medium
                        text-red-600
                    "
                >
                    {{ $message }}
                </p>

            @enderror

        </div>



        {{-- ===================================================== --}}
        {{-- REMEMBER + FORGOT PASSWORD --}}
        {{-- ===================================================== --}}
        <div
            class="
                flex
                flex-col
                gap-3

                sm:flex-row
                sm:items-center
                sm:justify-between
            "
        >


            {{-- REMEMBER --}}
            <label
                for="remember_me"
                class="
                    flex
                    cursor-pointer
                    items-center
                    gap-3
                "
            >

                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"

                    class="
                        h-5
                        w-5

                        rounded

                        border-slate-300

                        text-blue-600

                        focus:ring-blue-500
                    "
                >


                <span
                    class="
                        text-sm
                        text-slate-600
                    "
                >
                    Ingat saya
                </span>

            </label>



            {{-- FORGOT PASSWORD --}}
            @if (Route::has('password.request'))

                <a
                    href="{{ route('password.request') }}"

                    class="
                        text-sm
                        font-semibold
                        text-blue-600

                        transition

                        hover:text-blue-700
                    "
                >
                    Lupa password?
                </a>

            @endif

        </div>



        {{-- ===================================================== --}}
        {{-- LOGIN BUTTON --}}
        {{-- ===================================================== --}}
        <button
            type="submit"

            class="
                flex
                min-h-14
                w-full

                items-center
                justify-center
                gap-2

                rounded-xl

                bg-blue-600

                px-6
                py-3

                text-base
                font-bold
                text-white

                shadow-lg
                shadow-blue-600/20

                transition

                hover:bg-blue-700
                hover:shadow-blue-600/30

                active:scale-[0.99]

                focus:outline-none
                focus:ring-4
                focus:ring-blue-100
            "
        >

            <span>
                Masuk
            </span>


            <svg
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M14 5l7 7m0 0-7 7m7-7H3"
                />

            </svg>

        </button>



        {{-- ===================================================== --}}
        {{-- HELP --}}
        {{-- ===================================================== --}}
        <div
            class="
                rounded-xl

                border
                border-slate-200

                bg-slate-50

                px-4
                py-4

                text-center
            "
        >

            <p class="text-sm text-slate-500">
                Mengalami masalah saat masuk?
            </p>

            <p
                class="
                    mt-1
                    text-sm
                    font-semibold
                    text-slate-700
                "
            >
                Hubungi pengurus RT.
            </p>

        </div>

    </form>



    {{-- ========================================================= --}}
    {{-- REGISTER --}}
    {{-- ========================================================= --}}
    @if (Route::has('register'))

        <div
            class="
                mt-6
                border-t
                border-slate-200
                pt-5
                text-center
            "
        >

            <p class="text-sm text-slate-500">

                Belum memiliki akun?

                <a
                    href="{{ route('register') }}"

                    class="
                        font-semibold
                        text-blue-600

                        transition

                        hover:text-blue-700
                    "
                >
                    Daftar di sini
                </a>

            </p>

        </div>

    @endif

</x-guest-layout>