<x-dynamic-component
    :component="static::isSimple() ? 'filament-panels::page.simple' : 'filament-panels::page'"
>
    {{-- Tombol Back --}}
    <div class="mb-4">
        <a
            href="{{ route('filament.customer.pages.dashboard') }}"
            class="inline-flex items-center px-4 py-2 bg-pink-600 text-gray-800 rounded hover:bg-gray-300 transition"
        >
            ← Kembali
        </a>
    </div>

    <x-filament-panels::form id="form" wire:submit="save">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>
</x-dynamic-component>
