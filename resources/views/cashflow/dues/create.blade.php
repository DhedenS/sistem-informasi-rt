<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Tagihan Iuran KK</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <form action="{{ route('cashflow.dues.store') }}" method="POST" x-data="{
                    target: '{{ old('target', 'single') }}',
                    rates: {{ $iuranRates->map(fn($r) => ['year' => $r->year, 'month' => $r->month, 'amount' => (float) $r->amount])->values() }},
                    month: {{ old('month', $currentMonth ?? date('m')) }},
                    year: {{ old('year', date('Y')) }},
                    getRate() {
                        let applicable = this.rates.filter(r =>
                            r.year < this.year || (r.year == this.year && r.month <= this.month)
                        );
                        if (applicable.length === 0) return 30000;
                        applicable.sort((a, b) => (b.year - a.year) || (b.month - a.month));
                        return applicable[0].amount;
                    },
                    updateAmount() {
                        document.getElementById('amount').value = this.getRate();
                    }
                }"
                    x-init="updateAmount()">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Target Tagihan <span
                                class="text-red-500">*</span></label>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center">
                                <input type="radio" name="target" value="single" x-model="target"
                                    class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700 font-medium">Satu Kepala Keluarga (KK)</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="target" value="all" x-model="target"
                                    class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700 font-medium">Semua KK Aktif (Tagihan
                                    Masal)</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4" x-show="target === 'single'">
                        <label for="household_id" class="block text-gray-700 font-medium mb-1">Pilih Kepala Keluarga
                            (KK) <span class="text-red-500">*</span></label>
                        <select name="household_id" id="household_id"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih KK --</option>
                            @foreach ($households as $hh)
                                <option value="{{ $hh->id }}"
                                    {{ old('household_id') == $hh->id ? 'selected' : '' }}>
                                    [{{ $hh->block->name ?? 'Blok -' }}] No. {{ $hh->household_number }} -
                                    {{ $hh->head_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('household_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="month" class="block text-gray-700 font-medium mb-1">Bulan Periode <span
                                    class="text-red-500">*</span></label>
                            <select name="month" id="month" required x-model.number="month"
                                @change="updateAmount()"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @php
                                    $months = [
                                        1 => 'Januari',
                                        2 => 'Februari',
                                        3 => 'Maret',
                                        4 => 'April',
                                        5 => 'Mei',
                                        6 => 'Juni',
                                        7 => 'Juli',
                                        8 => 'Agustus',
                                        9 => 'September',
                                        10 => 'Oktober',
                                        11 => 'November',
                                        12 => 'Desember',
                                    ];
                                    $currentMonth = (int) date('m');
                                @endphp
                                @foreach ($months as $num => $name)
                                    <option value="{{ $num }}"
                                        {{ old('month', $currentMonth) == $num ? 'selected' : '' }}>
                                        {{ $name }}</option>
                                @endforeach
                            </select>
                            @error('month')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="year" class="block text-gray-700 font-medium mb-1">Tahun Periode <span
                                    class="text-red-500">*</span></label>
                            <select name="year" id="year" required x-model.number="year"
                                @change="updateAmount()"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @for ($y = date('Y') + 1; $y >= 2024; $y--)
                                    <option value="{{ $y }}"
                                        {{ old('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}
                                    </option>
                                @endfor
                            </select>
                            @error('year')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 font-medium mb-1">Nominal Tagihan (Rp) <span
                                class="text-red-500">*</span></label>
                        <input type="number" step="0.01" min="1" name="amount" id="amount"
                            value="{{ old('amount', 30000) }}" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('amount')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="notes" class="block text-gray-700 font-medium mb-1">Catatan Tagihan</label>
                        <textarea name="notes" id="notes" rows="2" placeholder="Catatan opsional..."
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                        @error('notes')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('cashflow.dues.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-medium text-sm">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium text-sm">Proses
                            Tagihan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
