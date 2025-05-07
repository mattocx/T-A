<x-filament-widgets::widget>
    <x-filament::section>
        <div class="payment-button-widget">
            @if($showPayButton)
                <div class="bg-warning-50 border border-warning-300 rounded-xl p-4 mb-4">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                <x-filament::icon 
                                    icon="heroicon-o-exclamation-triangle"
                                    class="h-6 w-6 text-warning-500" 
                                />
                            </div>
                            <div>
                                <h3 class="text-base font-medium text-warning-800">
                                    @if($status === 'active' && $daysLeft > 0)
                                        Langganan Anda akan berakhir dalam {{ $daysLeft }} hari
                                    @elseif($status === 'inactive')
                                        Langganan Anda telah berakhir
                                    @else
                                        Langganan Anda telah berakhir
                                    @endif
                                </h3>
                                <p class="text-sm text-warning-600 mt-1">
                                    @if($status === 'active' && $daysLeft > 0)
                                        Silakan lakukan pembayaran sebelum {{ $jatuhTempo }} untuk menghindari pemutusan layanan.
                                    @elseif($status === 'inactive')
                                        Layanan internet Anda telah dinonaktifkan. Silakan lakukan pembayaran untuk mengaktifkan kembali.
                                    @else
                                        Silakan lakukan pembayaran untuk mengaktifkan kembali layanan Anda.
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <a href="{{ url('/payment/create') }}" class="inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button h-9 px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
                                <span>Bayar Sekarang</span>
                                <x-filament::icon
                                    icon="heroicon-m-arrow-right"
                                    class="h-5 w-5"
                                />
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
