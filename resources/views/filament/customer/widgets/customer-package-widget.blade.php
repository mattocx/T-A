<x-filament::widget>
    <x-filament::card>
        @if ($package)
            <h2 class="text-lg font-bold">Paket Kamu Saat Ini</h2>
            <p><strong>Nama:</strong> {{ $package->name }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($package->price, 0, ',', '.') }}</p>
            <p><strong>Durasi:</strong> {{ $package->duration }} hari</p>
            <p><strong>Deskripsi:</strong> {{ $package->description }}</p>
        @else
            <p class="text-red-600">Kamu belum memiliki paket terdaftar.</p>
        @endif
    </x-filament::card>
</x-filament::widget>
