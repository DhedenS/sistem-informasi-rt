<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Approval') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">No</th>
                                    <th class="border px-4 py-2 text-left">Jenis</th>
                                    <th class="border px-4 py-2 text-left">ID Pengajuan</th>
                                    <th class="border px-4 py-2 text-left">Status</th>
                                    <th class="border px-4 py-2 text-left">Petugas</th>
                                    <th class="border px-4 py-2 text-left">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($approvals as $approval)
                                    <tr>
                                        <td class="border px-4 py-2">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ class_basename($approval->approvable_type) }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $approval->approvable_id }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $approval->status }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $approval->user->name ?? '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            <a
                                                href="{{ route('approval.show', $approval->id) }}"
                                                class="text-blue-600 hover:underline"
                                            >
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border px-4 py-6 text-center text-gray-500">
                                            Belum ada data approval.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $approvals->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>