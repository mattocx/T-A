<x-filament-panels::page>
    <div class="flex w-full flex-col">
        <div class="mb-5">
            @livewire(\App\Filament\Widgets\CustomersDueTodayAdmin::class)
        </div>
    </div>
    <div class="flex w-full flex-col">
        <div class="mb-5">
            @livewire(\App\Filament\Widgets\TotalRevenueThisMonthWidget::class)
        </div>
        <div class="mb-5">
            @livewire(\App\Filament\Widgets\ThisMonthRevenueLineChart::class)
        </div>
    </div>

    <div class="flex w-full flex-col">
        <div class="mb-5">
            @livewire(\App\Filament\Widgets\PackagePopularityChart::class)
        </div>
    </div>
</x-filament-panels::page>
