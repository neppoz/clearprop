<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SystemCalendarController extends Controller
{
    // public $sources = [
    //     [
    //         'model'      => '\\App\\Booking',
    //         'date_field' => 'reservation_start',
    //         'end_field'  => 'reservation_stop',
    //         'field'      => 'description',
    //         'prefix'     => '',
    //         'suffix'     => '',
    //         'route'      => 'admin.bookings.edit',
    //     ],
    // ];

    // public function index()
    // {
    //     $events = [];

    //     foreach ($this->sources as $source) {
    //         debug(Carbon::now()->subDay());
    //         // ->where($source['date_field'] >= Carbon::now()->subDay())
    //         foreach ($source['model']::with(['user', 'plane'])->orderby($source['date_field'], 'asc')->get() as $model) {
    //             $crudFieldValue = $model->getOriginal($source['date_field']);
    //             $crudEndFieldValue = $model->getOriginal($source['end_field']);

    //             if (!$crudFieldValue) {
    //                 continue;
    //             }

    //             $events[] = [
    //                 'title' => trim($source['prefix'] . " " . $model->plane->callsign
    //                     . ": " . $model->user->name
    //                     . " " .$model->{$source['field']}
    //                     . " " . $source['suffix']),
    //                 'start' => $crudFieldValue,
    //                 'end' => $crudEndFieldValue,
    //                 'url'   => route($source['route'], $model->id),
    //             ];
    //         }
    //     }

    //     return view('admin.calendar.calendar', compact('events'));
    // }
}
