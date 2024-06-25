<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;

class BookingsCalendar extends FullCalendarWidget
{
    protected static ?int $sort = 3;

    public Model|string|null $model = Reservation::class;

    public function config(): array
    {
        return [
            'initialView' => "timelineWeek",
            'aspectRatio' => 1.2,
            'dayHeaders' => true,
            'headerToolbar' => [
                'left' => 'prev,next',
                'center' => 'title',
                'right' => 'timelineDay,timelineWeek',
            ],
            'allDaySlot' => false,
            'slotMinTime' => "07:00:00",
            'slotMaxTime' => "19:00:00",
            'slotDuration' => "00:30:00",
            'height' => "auto",
            'slotLabelFormat' => [
                [
                    'weekday' => 'short',
                    'month' => '2-digit',
                    'day' => '2-digit',
                    'omitCommas' => true,
                ],
                [
                    'hour' => '2-digit',
                    'minute' => '2-digit',
                    'hour12' => false,
                ]
            ],
            'displayEventTime' => true,
            'firstDay' => 1,
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false,
            ]
        ];
    }

    public function resolveEventRecord(array $data): Reservation
    {
        return Reservation::find($data['id']);
    }

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
//                    'overlap' => 'false',
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
            /* tailwind colors, only hex values supported
            https://tailwindcss.com/docs/customizing-colors#color-palette-reference
            */
            2 => '#64748b',
            4 => '#f43f5e',
            default => '#3b82f6',
        };
    }

    public function getFormSchema(): array
    {
        return (new ReservationResource())->getReusableForm();
    }

    protected function getFormModel(): Model|string|null
    {
        return $this->event ?? Reservation::class;
    }

    protected function headerActions(): array
    {
        return [
            /* Did not work! Problem with relationship */
//            Actions\CreateAction::make()
//                ->mutateFormDataUsing(function (array $data): array {
//                    return [
//                        'reservation_start' => $data['reservation_start_date'] . ' ' . $data['reservation_start_time_hour'] . ':' . $data['reservation_start_time_minute'] . ':00',
//                        'reservation_stop' => $data['reservation_stop_date'] . ' ' . $data['reservation_stop_time_hour'] . ':' . $data['reservation_stop_time_minute'] . ':00',
//                        'created_by_id' => auth()->id()
//                    ];
//                })
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

}
