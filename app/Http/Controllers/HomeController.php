<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Services\BookingDataService;
use App\Services\StatisticsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        $bookingDates = (new BookingDataService())->getBookingDataForCards();
        $bookingCalendarEvents = (new BookingDataService())->getBookingDataForCalendar();

        return view('home', compact('bookingDates', 'bookingCalendarEvents', 'collectionActivityStatistics', 'currentUserMedicalBeyondDueDate'));
    }

    public function redirectToAdminPanel(): \Illuminate\Http\RedirectResponse
    {
        // Weiterleitung zur Filament Admin-Seite
        return redirect('/panel');
    }

}
