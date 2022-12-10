<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Parameter;
use App\Services\StatisticsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $collectionActivityStatistics = new \Illuminate\Support\Collection();
        if (\Gate::allows('dashboard_global_activity_access')) {
            $getGlobalActivityStatistics = (new StatisticsService())->getGlobalActivityStatistics();
            $collectionActivityStatistics->push($getGlobalActivityStatistics);
        }
        if (\Gate::allows('dashboard_instructor_activity_access')) {
            $getInstructorActivityStatistics = (new StatisticsService())->getInstructorActivityStatistics();
            $collectionActivityStatistics->push($getInstructorActivityStatistics);
        }
        if (\Gate::allows('dashboard_personal_activity_access')) {
            $getPersonalActivityStatistics = (new StatisticsService())->getPersonalActivityStatistics();
            $collectionActivityStatistics->push($getPersonalActivityStatistics);
        }

        $currentUserMedicalBeyondDueDate = false;
        if (Parameter::where('slug', 'check.medical')->value('value') == Parameter::CHECK_MEDICAL_ENABLED) {
            $currentUserMedical = Auth::user()->medical_due;
            if (!empty($currentUserMedical)) {
                $currentUserMedical = Carbon::createFromFormat('d/m/Y', $currentUserMedical);
                if ($currentUserMedical <= Carbon::today()) {
                    $currentUserMedicalBeyondDueDate = true;
                }
            }
        }

        $bookingDates = Booking::with(['plane', 'bookingUsers', 'bookingInstructors', 'slot', 'mode'])
            ->where('reservation_stop', '>=', Carbon::parse(today()))
            ->orderBy('reservation_start', 'asc')
            ->get()
            ->groupBy(function ($booking) {
                return Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->isoFormat('ddd DD MMM');
            });

        return view('home', compact('bookingDates', 'collectionActivityStatistics', 'currentUserMedicalBeyondDueDate'));
    }

}
