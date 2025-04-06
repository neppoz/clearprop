<x-filament::card class="w-full max-w-none">
    <div class="space-y-6">

        {{-- MEDICAL --}}
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">{{ __('user-info.medical.title') }}</p>

                @if ($hasValidMedical)
                    <p class="text-green-600 font-semibold">
                        {{ __('user-info.medical.valid_until', ['date' => $medicalDueDate]) }}
                    </p>
                @else
                    <p class="text-red-600 font-semibold">
                        {{ __('user-info.medical.invalid') }}
                    </p>
                @endif
            </div>

            <x-filament::badge
                    :color="$hasValidMedical ? 'success' : 'danger'"
                    class="text-xs"
            >
                {{ $hasValidMedical ? __('user-info.status.ok') : __('user-info.status.error') }}
            </x-filament::badge>
        </div>

        {{-- BALANCE --}}
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">{{ __('user-info.balance.title') }}</p>

                @php
                    $balanceTextColor = match($balanceStatusColor) {
                        'danger' => 'text-red-600',
                        'warning' => 'text-yellow-600',
                        default => 'text-green-600',
                    };
                @endphp

                <p class="{{ $balanceTextColor }} font-semibold">
                    {{ number_format($userBalance, 2, ',', '.') }} €
                </p>

                @unless ($isBalanceCheckActive)
                    <p class="text-xs text-gray-400">
                        {{ __('user-info.balance.not_checked') }}
                    </p>
                @endunless
            </div>

            <x-filament::badge
                    :color="$balanceStatusColor"
                    class="text-xs"
            >
                {{ __('user-info.balance.status.' . $balanceStatusColor) }}
            </x-filament::badge>
        </div>

    </div>
</x-filament::card>
