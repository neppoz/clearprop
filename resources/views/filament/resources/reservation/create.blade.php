<x-filament::page>
    {{-- Das Modal wird hier eingefügt --}}
    <x-filament.modal.warning
            :visible="$showWarningModal"
            :title="$warningTitle"
            :description="$warningDescription"
            :action="'redirectToIndex'"
    />
</x-filament::page>
