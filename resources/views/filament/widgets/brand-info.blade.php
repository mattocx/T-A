<x-filament-widgets::widget>
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 flex items-center justify-between">
        {{-- Kiri: Konten asli --}}
        <div class="flex items-center gap-4">
            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8.53 16.11a6 6 0 016.95 0M5.1 12.67a10 10 0 0113.8 0M1.67 9.24a14 14 0 0120.66 0M12 20h.01" />
            </svg>
            <div>
                <h2 class="text-xl font-semibold text-blue-500 dark:text-white">WiFi Elsa Prioritas</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300">Solusi internet cepat dan stabil</p>
            </div>
        </div>

        {{-- Garis pemisah --}}
        <div class="h-14 w-px bg-gray-300 dark:bg-gray-600 mx-8"></div>

        <div class="flex-shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 ">
        </div>
    </div>
</x-filament-widgets::widget>
