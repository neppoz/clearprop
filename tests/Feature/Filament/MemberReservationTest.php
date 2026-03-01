<?php

use App\Filament\Resources\ReservationResource;
use App\Models\Plane;
use App\Models\User;
use App\Settings\GeneralSettings;
use Carbon\Carbon;

beforeEach(function () {
    $this->member = User::factory()->member()->create([
        'medical_due' => Carbon::now()->addYear()->format('Y-m-d'),
    ]);
    $this->actingAs($this->member);
    $this->settings = app(GeneralSettings::class);
});

// --- validateReservation: airworthiness bypass with instructor ---

it('member without airworthiness can reserve when an instructor is selected', function () {
    $this->settings->check_activities = true;
    $this->settings->check_activities_limit_days = 90;
    $this->settings->save();

    $instructor = User::factory()->instructor()->create();

    $plane = Plane::create([
        'callsign'     => 'MBR-1',
        'vendor'       => 'Test',
        'active'       => true,
        'counter_type' => '060',
    ]);

    $startDate = Carbon::now()->addDay()->format('Y-m-d');

    $data = [
        'mode_id'                => \App\Models\Reservation::IS_CHARTER,
        'plane_id'               => $plane->id,
        'instructor_id'          => $instructor->id,
        'reservation_start_date' => $startDate,
        'reservation_start_time' => '10:00',
        'reservation_stop_date'  => $startDate,
        'reservation_stop_time'  => '12:00',
    ];

    $result = (new ReservationResource())->validateReservation($data);
    expect($result)->toBeTrue();
});

it('member without airworthiness is blocked when no instructor is selected', function () {
    $this->settings->check_activities = true;
    $this->settings->check_activities_limit_days = 90;
    $this->settings->save();

    $plane = Plane::create([
        'callsign'     => 'MBR-2',
        'vendor'       => 'Test',
        'active'       => true,
        'counter_type' => '060',
    ]);

    $startDate = Carbon::now()->addDay()->format('Y-m-d');

    $data = [
        'mode_id'                => \App\Models\Reservation::IS_CHARTER,
        'plane_id'               => $plane->id,
        'reservation_start_date' => $startDate,
        'reservation_start_time' => '10:00',
        'reservation_stop_date'  => $startDate,
        'reservation_stop_time'  => '12:00',
    ];

    $result = (new ReservationResource())->validateReservation($data);
    expect($result)->toBeFalse();
});

it('member without airworthiness can reserve when check_activities is disabled regardless of instructor', function () {
    $this->settings->check_activities = false;
    $this->settings->save();

    $plane = Plane::create([
        'callsign'     => 'MBR-3',
        'vendor'       => 'Test',
        'active'       => true,
        'counter_type' => '060',
    ]);

    $startDate = Carbon::now()->addDay()->format('Y-m-d');

    $data = [
        'mode_id'                => \App\Models\Reservation::IS_CHARTER,
        'plane_id'               => $plane->id,
        'reservation_start_date' => $startDate,
        'reservation_start_time' => '10:00',
        'reservation_stop_date'  => $startDate,
        'reservation_stop_time'  => '12:00',
    ];

    $result = (new ReservationResource())->validateReservation($data);
    expect($result)->toBeTrue();
});
