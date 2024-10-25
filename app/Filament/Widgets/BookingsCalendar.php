<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReservationResource;
use App\Models\Plane;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;

class BookingsCalendar extends FullCalendarWidget
{
    protected static ?int $sort = 3;
    protected static ?string $pollingInterval = null;

    public Model|string|null $model = Reservation::class;

    public function config(): array
    {
        return [
            'initialView' => 'resourceTimelineDay',
            'resourceAreaHeaderContent' => 'Callsign',
            'resources' => $this->getResources(),
            'aspectRatio' => 1.2,
            'dayHeaders' => true,
            'timeZone' => config('panel.timezone'),
            'scrollTime' => Carbon::now(config('panel.timezone'))->format('H:i'),
            'headerToolbar' => [
                'left' => 'prev,next',
                'center' => 'title',
                'right' => 'resourceTimelineDay,resourceTimelineWeek',
            ],
            'allDaySlot' => false,
            'slotMinTime' => $this->getSunrise(config('panel.latitude'), config('panel.longitude'), config('panel.timezone')),
            'slotMaxTime' => $this->getSunset(config('panel.latitude'), config('panel.longitude'), config('panel.timezone')),
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

    private function getResources(): array
    {
        return Plane::select('id', 'callsign as title')->get()->toArray();
    }

    private function getSunrise($latitude, $longitude, $timezone): string
    {
        $date = Carbon::now($timezone);
        $sun_info = date_sun_info($date->timestamp, $latitude, $longitude);
        $twilight_begin_minute = Carbon::createFromTimestamp($sun_info['civil_twilight_begin'], $timezone)->format('i');

        if ($twilight_begin_minute < 15) {
            $additionalMinutes = -$twilight_begin_minute; // Rundet nach unten zur vollen Stunde
        } else {
            $additionalMinutes = 60 - $twilight_begin_minute; // Rundet nach oben zur nächsten vollen Stunde
        }

        return Carbon::createFromTimestamp($sun_info['civil_twilight_begin'], $timezone)->addMinutes($additionalMinutes)->format('H:i');
    }

    private function getSunset($latitude, $longitude, $timezone): string
    {
        $date = Carbon::now($timezone);
        $sun_info = date_sun_info($date->timestamp, $latitude, $longitude);
        $twilight_begin_minute = Carbon::createFromTimestamp($sun_info['civil_twilight_end'], $timezone)->format('i');

        if ($twilight_begin_minute < 30) {
            $additionalMinutes = -$twilight_begin_minute; // Rundet nach unten zur vollen Stunde
        } else {
            $additionalMinutes = 60 - $twilight_begin_minute; // Rundet nach oben zur nächsten vollen Stunde
        }

        return Carbon::createFromTimestamp($sun_info['civil_twilight_end'], $timezone)->addMinutes($additionalMinutes)->format('H:i');
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
                    'resourceId' => $reservation->plane_id,
                    'title' => $this->getReservationTitle($reservation->id),
                    'description' => $reservation->description,
                    'start' => $reservation->reservation_start,
                    'end' => $reservation->reservation_stop,
                    'color' => $this->getBookingColor($reservation->mode_id),
                    'url' => ReservationResource::getUrl(name: 'edit', parameters: ['record' => $reservation]),
                ]
            )->all();
    }

    private function getReservationTitle($id)
    {
        $reservation = Reservation::find($id);
        return $reservation->bookingUsers()->pluck('name');
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
