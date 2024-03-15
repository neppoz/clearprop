<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReservationResource;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class BookingsCalendar extends FullCalendarWidget
{
    protected static ?int $sort = 3;

    public Model|string|null $model = Reservation::class;

    /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */
    public function fetchEvents(array $fetchInfo): array
    {
        return Reservation::query()
            ->where('reservation_start', '>=', $fetchInfo['start'])
            ->where('reservation_stop', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn(Reservation $reservation) => [
                    'title' => $reservation->plane->callsign,
                    'description' => $reservation->description,
                    'start' => $reservation->reservation_start,
                    'end' => $reservation->reservation_stop,
                    'color' => $this->getBookingColor($reservation->mode_id),
                    'url' => ReservationResource::getUrl(name: 'edit', parameters: ['record' => $reservation]),
                ]
            )->all();
    }

    private function getBookingColor(mixed $mode_id): string
    {
        return match ($mode_id) {
            2 => 'gray',
            4 => 'danger',
            default => 'primary',
        };
    }
}
