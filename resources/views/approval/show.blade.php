<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Approval') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-800">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6 space-y-3">
                        <p>
                            <strong>Status:</strong>
                            {{ $approval->status }}
                        </p>

                        <p>
                            <strong>Jenis:</strong>
                            {{ class_basename($approval->approvable_type) }}
                        </p>

                        <p>
                            <strong>ID Pengajuan:</strong>
                            {{ $approval->approvable_id }}
                        </p>

                        <p>
                            <strong>Catatan:</strong>
                            {{ $approval->notes ?? '-' }}
                        </p>
                    </div>

                    <hr class="my-6">

                    {{-- VERIFIKASI --}}
                    <div class="mb-6">
                        <h3 class="mb-3 text-lg font-semibold">
                            Verifikasi
                        </h3>

                        <form
                            method="POST"
                            action="{{ route('approval.verify', $approval->id) }}"
                        >
                            @csrf

                            <textarea
                                name="notes"
                                rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Catatan verifikasi"
                            >{{ old('notes') }}</textarea>

                            <button
                                type="submit"
                                class="mt-3 rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                Verifikasi
                            </button>
                        </form>
                    </div>

                    <hr class="my-6">

                    {{-- SETUJUI --}}
                    <div class="mb-6">
                        <h3 class="mb-3 text-lg font-semibold">
                            Persetujuan
                        </h3>

                        <form
                            method="POST"
                            action="{{ route('approval.approve', $approval->id) }}"
                        >
                            @csrf

                            <textarea
                                name="notes"
                                rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Catatan persetujuan"
                            >{{ old('notes') }}</textarea>

                            <button
                                type="submit"
                                class="mt-3 rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                            >
                                Setujui
                            </button>
                        </form>
                    </div>

                    <hr class="my-6">

                    {{-- TOLAK --}}
                    <div class="mb-6">
                        <h3 class="mb-3 text-lg font-semibold">
                            Penolakan
                        </h3>

                        <form
                            method="POST"
                            action="{{ route('approval.reject', $approval->id) }}"
                        >
                            @csrf

                            <textarea
                                name="notes"
                                rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Alasan penolakan"
                            >{{ old('notes') }}</textarea>

                            <button
                                type="submit"
                                class="mt-3 rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                            >
                                Tolak
                            </button>
                        </form>
                    </div>

                    <hr class="my-6">

                    {{-- REVISI --}}
                    <div class="mb-6">
                        <h3 class="mb-3 text-lg font-semibold">
                            Revisi
                        </h3>

                        <form
                            method="POST"
                            action="{{ route('approval.revision', $approval->id) }}"
                        >
                            @csrf

                            <textarea
                                name="notes"
                                rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Catatan revisi"
                            >{{ old('notes') }}</textarea>

                            <button
                                type="submit"
                                class="mt-3 rounded-md bg-yellow-500 px-4 py-2 text-white hover:bg-yellow-600"
                            >
                                Minta Revisi
                            </button>
                        </form>
                    </div>

                    <div class="mt-8">
                        <a
                            href="{{ route('approval.index') }}"
                            class="text-blue-600 hover:underline"
                        >
                            ← Kembali ke Daftar Approval
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>