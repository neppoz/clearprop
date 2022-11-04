<?php

namespace App\Http\Controllers\Pilot;

use App\Booking;
use App\Parameter;
use App\Services\StatisticsService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController
{
    public function index(Request $request)
    {
        $statistics = (new StatisticsService())->dashboard($request);
        if (Parameter::where('slug', 'check.medical')->value('value') == Parameter::CHECK_MEDICAL_ENABLED) {
            $userMedicalGoingDue = User::whereNotNull('medical_due')
                ->whereBetween('medical_due', [Carbon::now(), Carbon::now()->addDays(40)])
                ->orWhere('medical_due', '<', [Carbon::now(), Carbon::now()])
                ->orderBy('medical_due', 'desc')
                ->get();
        } else {
            $userMedicalGoingDue = '';
        }

        $bookingDates = Booking::with(['plane', 'bookingUsers', 'bookingInstructors', 'slot', 'mode'])
            ->where('reservation_stop', '>=', Carbon::parse(today()))
            ->orderBy('reservation_start', 'asc')
            ->get()
            ->groupBy(function ($booking) {
                return Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->isoFormat('ddd DD MMM');
            });

        $checkinDates = Booking::with(['plane', 'bookingUsers', 'bookingInstructors', 'slot'])
            ->whereDoesntHave('bookingUsers', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->where('reservation_stop', '>=', Carbon::parse(today()))
            ->where('checkin', 1)
            ->where('seats_available', '>', 0)
            ->where('status', 1)
            ->orderBy('reservation_start', 'asc')
            ->get()
            ->groupBy(function ($booking) {
                return $booking->slot->title . ' - ' . Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->isoFormat('dddd, DD MMMM YYYY');
            });

        return view('welcome', compact('statistics', 'bookingDates', 'checkinDates', 'userMedicalGoingDue'));
    }

}
