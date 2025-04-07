@php
    // Ambil guard berdasarkan panel yang sedang diakses
    $guard = filament()->getCurrentPanel()->getAuthGuard();
    $user = auth($guard)->user(); // Ambil user dari guard yang aktif

    // Ambil avatar user dari database jika tersedia, jika tidak gunakan default avatar
    $avatar = $user->photo
        ? asset('storage/' . $user->photo)
        : filament()->getUserAvatarUrl($user);
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            {{-- Avatar User --}}
            <img src="{{ $avatar }}" alt="User Avatar" class="w-10 h-10 rounded-full">

            <div class="flex-1">
                {{-- Nama User --}}
                <h2 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    {{ $user->name }}
                </h2>
            </div>

            {{-- Tombol Logout --}}
            <form action="{{ filament()->getLogoutUrl() }}" method="post" class="my-auto">
                @csrf
                <x-filament::button
                    color="gray"
                    icon="heroicon-m-arrow-left-on-rectangle"
                    icon-alias="panels::widgets.account.logout-button"
                    labeled-from="sm"
                    tag="button"
                    type="submit"
                >
                    {{ __('filament-panels::widgets/account-widget.actions.logout.label') }}
                </x-filament::button>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
