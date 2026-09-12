<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                    Detail Approval
                </h1>

                <p class="mt-1 text-base text-gray-600">
                    Periksa data sebelum memilih tindakan.
                </p>

            </div>


            <a
                href="{{ route('approval.index') }}"
                class="inline-flex min-h-12 items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-3 text-base font-semibold text-gray-700 shadow-sm hover:bg-gray-50"
            >

                ← Kembali

            </a>

        </div>

    </x-slot>


    @if(session('success'))

        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-4 text-base font-medium text-green-800">

            {{ session('success') }}

        </div>

    @endif
    
    @if(session('error'))
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-base font-medium text-red-800">
        {{ session('error') }}
    </div>
@endif


    @if($errors->any())

        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-base text-red-800">

            <p class="font-bold">
                Ada data yang perlu diperbaiki:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="mx-auto max-w-4xl space-y-5">

        {{-- RINGKASAN --}}
        <section class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Status saat ini
                    </p>

                    <p class="mt-1 text-xl font-bold text-gray-900">

                        {{ ucfirst($approval->status) }}

                    </p>

                </div>


                @php

                    $statusClass = match($approval->status) {

                        'approved' =>
                            'bg-green-100 text-green-800',

                        'rejected' =>
                            'bg-red-100 text-red-800',

                        'revision' =>
                            'bg-yellow-100 text-yellow-900',

                        'verified' =>
                            'bg-blue-100 text-blue-800',

                        default =>
                            'bg-gray-100 text-gray-800',

                    };

                @endphp


                <span class="inline-flex w-fit rounded-full px-4 py-2 text-base font-bold {{ $statusClass }}">

                    {{ ucfirst($approval->status) }}

                </span>

            </div>


            <dl class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">

                <div class="rounded-xl bg-gray-50 p-4">

                    <dt class="text-sm text-gray-500">
                        Jenis
                    </dt>

                    <dd class="mt-1 text-base font-semibold text-gray-900 break-words">

                        {{ class_basename($approval->approvable_type) }}

                    </dd>

                </div>


                <div class="rounded-xl bg-gray-50 p-4">

                    <dt class="text-sm text-gray-500">
                        ID Pengajuan
                    </dt>

                    <dd class="mt-1 text-base font-semibold text-gray-900">

                        {{ $approval->approvable_id }}

                    </dd>

                </div>


                <div class="rounded-xl bg-gray-50 p-4 sm:col-span-2">

                    <dt class="text-sm text-gray-500">
                        Catatan terakhir
                    </dt>

                    <dd class="mt-1 text-base font-medium leading-relaxed text-gray-900">

                        {{ $approval->notes ?? '-' }}

                    </dd>

                </div>

            </dl>

        </section>


        {{-- VERIFIKASI --}}
        <section class="rounded-2xl border border-blue-200 bg-white p-5 sm:p-6 shadow-sm">

            <h2 class="text-xl font-bold text-gray-900">
                Verifikasi
            </h2>

            <p class="mt-1 text-base text-gray-600">
                Gunakan jika data sudah diperiksa dan siap dilanjutkan.
            </p>


            <form
                method="POST"
                action="{{ route('approval.verify', $approval->id) }}"
                class="mt-4"
            >

                @csrf


                <label
                    for="verify-notes"
                    class="mb-2 block text-base font-semibold text-gray-800"
                >
                    Catatan verifikasi
                </label>


                <textarea
                    id="verify-notes"
                    name="notes"
                    rows="4"
                    class="w-full rounded-xl border-gray-300 text-base shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Tulis catatan jika diperlukan"
                >{{ old('notes') }}</textarea>


                <button
                    type="submit"
                    class="mt-4 inline-flex min-h-12 w-full sm:w-auto items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-base font-bold text-white shadow-sm hover:bg-blue-700 active:bg-blue-800"
                >

                    Verifikasi Pengajuan

                </button>

            </form>

        </section>


        {{-- SETUJUI --}}
        <section class="rounded-2xl border border-green-200 bg-white p-5 sm:p-6 shadow-sm">

            <h2 class="text-xl font-bold text-gray-900">
                Setujui
            </h2>

            <p class="mt-1 text-base text-gray-600">
                Gunakan jika pengajuan sudah memenuhi syarat.
            </p>


            <form
                method="POST"
                action="{{ route('approval.approve', $approval->id) }}"
                class="mt-4"
            >

                @csrf


                <label
                    for="approve-notes"
                    class="mb-2 block text-base font-semibold text-gray-800"
                >
                    Catatan persetujuan
                </label>


                <textarea
                    id="approve-notes"
                    name="notes"
                    rows="4"
                    class="w-full rounded-xl border-gray-300 text-base shadow-sm focus:border-green-500 focus:ring-green-500"
                    placeholder="Tulis catatan jika diperlukan"
                >{{ old('notes') }}</textarea>


                <button
                    type="submit"
                    class="mt-4 inline-flex min-h-12 w-full sm:w-auto items-center justify-center rounded-xl bg-green-600 px-6 py-3 text-base font-bold text-white shadow-sm hover:bg-green-700 active:bg-green-800"
                >

                    Setujui Pengajuan

                </button>

            </form>

        </section>


        {{-- REVISI --}}
        <section class="rounded-2xl border border-yellow-300 bg-white p-5 sm:p-6 shadow-sm">

            <h2 class="text-xl font-bold text-gray-900">
                Minta Revisi
            </h2>

            <p class="mt-1 text-base text-gray-600">
                Jelaskan bagian yang perlu diperbaiki agar mudah dipahami.
            </p>


            <form
                method="POST"
                action="{{ route('approval.revision', $approval->id) }}"
                class="mt-4"
            >

                @csrf


                <label
                    for="revision-notes"
                    class="mb-2 block text-base font-semibold text-gray-800"
                >
                    Catatan revisi
                </label>


                <textarea
                    id="revision-notes"
                    name="notes"
                    rows="4"
                    class="w-full rounded-xl border-gray-300 text-base shadow-sm focus:border-yellow-500 focus:ring-yellow-500"
                    placeholder="Contoh: Mohon lengkapi bukti transaksi"
                >{{ old('notes') }}</textarea>


                <button
                    type="submit"
                    class="mt-4 inline-flex min-h-12 w-full sm:w-auto items-center justify-center rounded-xl bg-yellow-500 px-6 py-3 text-base font-bold text-gray-950 shadow-sm hover:bg-yellow-600 active:bg-yellow-700"
                >

                    Minta Revisi

                </button>

            </form>

        </section>


        {{-- TOLAK --}}
        <section class="rounded-2xl border border-red-200 bg-white p-5 sm:p-6 shadow-sm">

            <h2 class="text-xl font-bold text-gray-900">
                Tolak
            </h2>

            <p class="mt-1 text-base text-gray-600">
                Gunakan hanya jika pengajuan memang tidak dapat diterima.
            </p>


            <form
                method="POST"
                action="{{ route('approval.reject', $approval->id) }}"
                class="mt-4"
                onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')"
            >

                @csrf


                <label
                    for="reject-notes"
                    class="mb-2 block text-base font-semibold text-gray-800"
                >
                    Alasan penolakan
                </label>


                <textarea
                    id="reject-notes"
                    name="notes"
                    rows="4"
                    class="w-full rounded-xl border-gray-300 text-base shadow-sm focus:border-red-500 focus:ring-red-500"
                    placeholder="Tuliskan alasan penolakan dengan jelas"
                >{{ old('notes') }}</textarea>


                <button
                    type="submit"
                    class="mt-4 inline-flex min-h-12 w-full sm:w-auto items-center justify-center rounded-xl bg-red-600 px-6 py-3 text-base font-bold text-white shadow-sm hover:bg-red-700 active:bg-red-800"
                >

                    Tolak Pengajuan

                </button>

            </form>

        </section>

    </div>

</x-app-layout>