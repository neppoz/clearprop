<x-filament::page>
    <div class="space-y-6">
        <x-filament::card>
            <!-- Header -->
            <div class="px-4 py-3 border-b bg-gray-50 dark:bg-gray-800">
                <h3 class="text-lg font-medium">Profile & Password Settings</h3>
                <p class="text-sm text-gray-500">
                    Update your account information and security settings.
                </p>
            </div>

            <!-- Body -->
            <div class="p-4">
                {{ $this->form }}
            </div>

            <!-- Footer -->
            <div class="px-4 py-3 border-t bg-gray-50 dark:bg-gray-800 flex justify-end space-x-2">
                <x-filament::button wire:click="saveProfile">
                    Save Profile
                </x-filament::button>
                <x-filament::button wire:click="savePassword">
                    Update Password
                </x-filament::button>
            </div>
        </x-filament::card>
    </div>
</x-filament::page>
