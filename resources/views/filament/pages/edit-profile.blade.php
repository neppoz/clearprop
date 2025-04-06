<x-filament::page>
    <div class="space-y-6">
        {{-- Formular --}}
        {{ $this->form }}

        {{-- Aktionen --}}
        <div class="flex items-center justify-end gap-3">
            <x-filament::button wire:click="saveProfile">
                {{ __('Save Profile') }}
            </x-filament::button>

            <x-filament::button wire:click="savePassword" color="gray">
                {{ __('Update Password') }}
            </x-filament::button>
        </div>
    </div>
</x-filament::page>
