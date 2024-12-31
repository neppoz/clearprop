<?php

namespace App\Filament\Resources\ReservationResource\Widgets;

use App\Filament\Resources\ReservationResource;
use App\Models\Plane;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class BookingsCalendar extends FullCalendarWidget
{
    protected static ?int $sort = 3;
    public Model|string|null $model = Reservation::class;

    public function config(): array
    {
        return [
            'initialView' => 'resourceTimelineDay', // Default timeline view
            'scrollTime' => Carbon::now(config('panel.timezone'))->format('H:i:s'), // Default scroll time
            'resourceAreaHeaderContent' => 'Sign', // Resource header title
            'resourceAreaWidth' => '65px', // Resource header smaller
            'resources' => $this->getResources(), // Resource data for timeline
            'aspectRatio' => 0.75, // Calendar aspect ratio
            'responsive' => true, // for mobile
            'dayHeaders' => true, // Display day headers in the calendar
            'timeZone' => config('panel.timezone'), // Use application timezone
            'views' => [
                'resourceTimelineDay' => [
                    'type' => 'resourceTimeline',
                    'buttonText' => 'day',
                    'slotDuration' => '02:00', // Slots of 1 hour
                ],
                'resourceTimelineTenDay' => [
                    'type' => 'resourceTimeline',
                    'duration' => ['days' => 10], // 10-day duration
                    'buttonText' => '10 days',
                    'slotDuration' => '04:00', // Slots of 1 hour
                ],
                'resourceTimelineMonth' => [
                    'type' => 'resourceTimeline',
                    'duration' => ['days' => 30], // 30-day duration
                    'buttonText' => 'Month',
                    'slotDuration' => '12:00', // Slots of 4 hours
                ],
            ],
            'headerToolbar' => [
                'left' => 'prev,today,next', // Navigation buttons
                'center' => 'title',   // Centered calendar title
                'right' => 'resourceTimelineDay,resourceTimelineTenDay' // View options
            ],
            'allDaySlot' => false, // Disable all-day slot
            'height' => "auto", // Automatically adjust calendar height
            'slotLabelFormat' => [
                [
                    'weekday' => 'short', // Abbreviated weekday name
                    'month' => '2-digit', // Two-digit month
                    'day' => '2-digit',   // Two-digit day
                    'omitCommas' => true, // Remove commas in formatting
                ],
                [
                    'hour' => '2-digit',  // Two-digit hour
                    'minute' => '2-digit', // Two-digit minutes
                    'hour12' => false,     // 24-hour format
                ]
            ],
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false, // Use 24-hour format
            ],
            'titleFormat' => [
//                'year' => '2-digit', // Jahr im Kurzformat (z. B. '24' statt '2024')
                'month' => 'short',  // Abbreviation month (z. B. 'Jan')
                'day' => 'numeric',  // Day
            ],
            'displayEventTime' => false, // Hide event time in the display
            'eventDisplay' => 'block', // Display events as full blocks
        ];
    }

    protected function getFullCalendarOptions(): array
    {
        return [
            'resourceAreaHeaderContent' => 'Res.', // Kompakter Header
            'resourceAreaWidth' => '80px',        // Schlankere Ressourcenspalte
        ];
    }

    /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */
    public function fetchEvents(array $info): array
    {
        return Reservation::query()
            ->where(function ($query) use ($info) {
                $query->where('reservation_start', '<', $info['end'])
                    ->where('reservation_stop', '>', $info['start']);
            })
            ->get()
            ->map(fn(Reservation $reservation) => [
                'resourceId' => $reservation->plane_id,
                'title' => $this->getReservationTitle($reservation->id),
                'description' => $reservation->description,
                'start' => $reservation->reservation_start,
                'end' => $reservation->reservation_stop,
                'color' => $this->getBookingColor($reservation->mode_id),
                'url' => ReservationResource::getUrl('view', ['record' => $reservation->id]),
            ])
            ->all();
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

    private function getReservationTitle($id): \Illuminate\Support\Collection
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
