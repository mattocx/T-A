<x-filament-widgets::widget>
    <x-filament::section>
        @if ($isAlmostDue)
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow">
        <p><strong>Perhatian!</strong> Masa aktif internet Anda akan berakhir pada <strong>{{ $dueDate->format('d M Y') }}</strong>. Segera lakukan pembayaran ulang untuk menghindari pemutusan layanan.</p>
    </div>
@endif

    </x-filament::section>
</x-filament-widgets::widget>
