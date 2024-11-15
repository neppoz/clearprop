<x-filament::modal
        :visible="$visible"
        close-button="false"
        :actions="[
        [
            'label' => 'Zurück zur Übersicht',
            'action' => '',
            'color' => 'primary',
        ],
    ]"
>
    <x-slot name="header">
        <div class="flex items-center">
            {{--            <x-heroicon-o-exclamation class="w-6 h-6 text-warning-600"/>--}}
            <h2 class="ml-3 text-lg font-medium">
                {{ $title }}
            </h2>
        </div>
    </x-slot>

    <p class="text-sm text-gray-500">
        {{ $description }}
    </p>
</x-filament::modal>
