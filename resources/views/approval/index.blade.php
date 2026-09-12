<x-app-layout>

    <x-slot name="header">

        <div>

            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                Daftar Approval
            </h1>

            <p class="mt-1 text-base text-gray-600">
                Pilih pengajuan untuk melihat detail dan melakukan tindakan.
            </p>

        </div>

    </x-slot>


    @if(session('success'))

        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-4 text-base font-medium text-green-800">

            {{ session('success') }}

        </div>

    @endif


    {{-- MOBILE --}}
    <div class="space-y-4 md:hidden">

        @forelse($approvals as $approval)

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


            <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">

                        <p class="text-sm font-medium text-gray-500">
                            Pengajuan #{{ $approval->approvable_id }}
                        </p>

                        <h2 class="mt-1 text-lg font-bold text-gray-900 break-words">

                            {{ class_basename($approval->approvable_type) }}

                        </h2>

                    </div>


                    <span class="shrink-0 rounded-full px-3 py-1.5 text-sm font-semibold {{ $statusClass }}">

                        {{ ucfirst($approval->status) }}

                    </span>

                </div>


                <div class="mt-4 rounded-xl bg-gray-50 p-4">

                    <p class="text-sm text-gray-500">
                        Petugas
                    </p>

                    <p class="mt-1 text-base font-semibold text-gray-900">

                        {{ $approval->user->name ?? '-' }}

                    </p>

                </div>


                <a
                    href="{{ route('approval.show', $approval->id) }}"
                    class="mt-4 inline-flex min-h-12 w-full items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-base font-bold text-white shadow-sm hover:bg-blue-700 active:bg-blue-800"
                >

                    Lihat Detail

                </a>

            </article>


        @empty

            <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center text-base text-gray-600 shadow-sm">

                Belum ada data approval.

            </div>

        @endforelse

    </div>


    {{-- TABLET / DESKTOP --}}
    <div class="hidden md:block overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-5 py-4 text-left text-sm font-bold text-gray-700">
                            No
                        </th>

                        <th class="px-5 py-4 text-left text-sm font-bold text-gray-700">
                            Jenis
                        </th>

                        <th class="px-5 py-4 text-left text-sm font-bold text-gray-700">
                            ID Pengajuan
                        </th>

                        <th class="px-5 py-4 text-left text-sm font-bold text-gray-700">
                            Status
                        </th>

                        <th class="px-5 py-4 text-left text-sm font-bold text-gray-700">
                            Petugas
                        </th>

                        <th class="px-5 py-4 text-left text-sm font-bold text-gray-700">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($approvals as $approval)

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


                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-4 text-base text-gray-700">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-5 py-4 text-base font-medium text-gray-900">

                                {{ class_basename($approval->approvable_type) }}

                            </td>

                            <td class="px-5 py-4 text-base text-gray-700">

                                {{ $approval->approvable_id }}

                            </td>

                            <td class="px-5 py-4">

                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusClass }}">

                                    {{ ucfirst($approval->status) }}

                                </span>

                            </td>

                            <td class="px-5 py-4 text-base text-gray-700">

                                {{ $approval->user->name ?? '-' }}

                            </td>

                            <td class="px-5 py-4">

                                <a
                                    href="{{ route('approval.show', $approval->id) }}"
                                    class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-4 py-2 text-base font-semibold text-white hover:bg-blue-700"
                                >

                                    Detail

                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-5 py-10 text-center text-base text-gray-500"
                            >

                                Belum ada data approval.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    <div class="mt-5">

        {{ $approvals->links() }}

    </div>

</x-app-layout>