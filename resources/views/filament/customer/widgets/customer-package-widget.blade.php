<x-filament::widget>
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6 shadow-lg rounded-lg">
        @if ($package)
            <h2 class="text-xl font-extrabold mb-2">Internet Kamu Saat Ini</h2>
            <p class="mb-1"><strong>Nama:</strong> {{ $package->name }}</p>
            <p class="mb-1"><strong>Harga:</strong> Rp {{ number_format($package->price, 0, ',', '.') }}</p>
            <p class="mb-1"><strong>Durasi:</strong> {{ $package->duration }} hari</p>
        @else
            <p class="text-red-200 font-semibold">❌ Kamu belum memiliki paket terdaftar.</p>
        @endif
    </div>
</x-filament::widget>
