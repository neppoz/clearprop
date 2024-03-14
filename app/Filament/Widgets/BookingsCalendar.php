<?php

namespace App\Filament\Widgets;

use App\Booking;
use App\Filament\Resources\BookingResource;
use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class BookingsCalendar extends FullCalendarWidget
{
    protected static ?int $sort = 3;

    public Model|string|null $model = Booking::class;

//    public function getFormSchema(): array
//    {
//        return [
//            TextInput::make('name'),
//
//            Grid::make()
//                ->schema([
//                    DateTimePicker::make('reservation_start'),
//                    DateTimePicker::make('reservation_stop'),
//                ]),
//        ];
//    }


    /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */
    public function fetchEvents(array $fetchInfo): array
    {
        return Booking::query()
            ->where('reservation_start', '>=', $fetchInfo['start'])
            ->where('reservation_stop', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn(Booking $booking) => [
                    'title' => $booking->plane->callsign,
                    'description' => $booking->id,
                    'start' => Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $booking->reservation_start)->format('Y-m-d H:i:s'),
                    'end' => Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $booking->reservation_stop)->format('Y-m-d H:i:s'),
                    'color' => $this->getBookingColor($booking->mode_id),
                    'url' => BookingResource::getUrl(name: 'edit', parameters: ['record' => $booking]),
                    'shouldOpenUrlInNewTab' => true
                ]
            )->all();
    }

    private function getBookingColor(mixed $mode_id): string
    {
        return match ($mode_id) {
            2 => "#6c757d",
            4 => "#dc3545",
            default => "#007bff",
        };
    }
}
