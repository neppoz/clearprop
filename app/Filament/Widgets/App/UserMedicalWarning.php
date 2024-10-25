<?php

namespace App\Filament\Widgets\App;

use App\Parameter;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

//class UserMedicalWarning extends Widget
//{
////    protected static string $view = 'filament.widgets.user-medical-warning';
////    protected static ?int $sort = -1;
////    protected static ?string $pollingInterval = null;
////    protected int|string|array $columnSpan = 'full';
////
////    public static function canView(): bool
////    {
////        $currentUserMedicalBeyondDueDate = true;
////        if (Parameter::where('slug', 'check.medical')->value('value') == Parameter::CHECK_MEDICAL_ENABLED) {
////            $currentUserMedical = Auth::user()->medical_due;
////            if (!empty($currentUserMedical)) {
////                $currentUserMedical = Carbon::createFromFormat('d/m/Y', $currentUserMedical);
////                if ($currentUserMedical <= Carbon::today()) {
////                    $currentUserMedicalBeyondDueDate = true;
////                }
////            }
////        }
////        //ToDo: change to false for production
////        return $currentUserMedicalBeyondDueDate;
////    }
//
//}
