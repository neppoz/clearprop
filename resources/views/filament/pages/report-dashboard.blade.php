<x-filament::page>
    {{-- Filterformular anzeigen --}}
    <div class="mb-4">
        {{ $this->form }}
    </div>
    @foreach ($this->getFooterWidgets() as $widget)
        @livewire($widget)
    @endforeach
</x-filament::page>
