
<x-filament-panels::page>

    <div class="flex w-full flex-row">
        <div class="mb-5 w-1/2 mr-3">
            @livewire(\App\Filament\Customer\Widgets\CustomerAlert::class)
        </div>
        <div class="mb-5 w-1/2 mr-3">
            @livewire(\App\Filament\Customer\Widgets\CustomerPackageWidget::class)
        </div>
    </div>

    <div class="flex w-full flex-row">
        <div class="mb-5 w-full">
            @livewire(\App\Filament\Customer\Widgets\CustomerPaymentButton::class)
        </div>
    </div>

</x-filament-panels::page>

