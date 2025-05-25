@php
    $baseClasses = 'bg-white border-2 border-pink-600 hover:border-pink-700 hover:border-4 transform hover:scale-105 transition duration-300 rounded-lg cursor-pointer';

    $latestPayment = auth()->user()->latestPayment();
    $startDate = $latestPayment?->payment_date ?? $latestPayment?->created_at;
    $endDate = auth()->user()->dueDate();
@endphp

<x-filament::widget>
    <div
        class="{{ $baseClasses }} p-6 shadow-md grid grid-cols-2 divide-x divide-pink-600"
        wire:click="$dispatch('setStatusFilter', { filter: 'processed' })"
    >
        <!-- Kiri: Judul + Ikon -->
        <div class="pr-4 flex flex-col items-center justify-center text-pink-600">
            <x-heroicon-o-globe-alt class="w-8 h-8 mb-2" />
            <h2 class="text-xl font-bold">Paket Internet</h2>
        </div>

        <!-- Kanan: Informasi Paket -->
        <div class="pl-4">
            @if ($package)
                <p class="mb-2"><strong>Nama:</strong> {{ $package->name }}</p>
                <p class="mb-2"><strong>Harga:</strong> Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                <p class="mb-2"><strong>Durasi:</strong> {{ $package->duration }} hari</p>

                @if ($startDate && $endDate)
                    <p class="mt-2 text-sm text-gray-600">
                        <strong>Masa Aktif:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s.d. {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                    </p>
                @else
                    <p class="mt-2 text-sm text-red-500">Belum ada riwayat pembayaran aktif.</p>
                @endif
            @else
                <p class="text-red-600 font-semibold">❌ Kamu belum memiliki paket terdaftar.</p>
            @endif
        </div>
    </div>
</x-filament::widget>
