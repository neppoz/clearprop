<?php

use App\Filament\Resources\ReservationResource;
use App\Models\Plane;
use App\Models\Reservation;
use App\Models\User;
use App\Policies\NavigationPolicy;
use App\Policies\ReservationPolicy;
use App\Settings\GeneralSettings;
use Carbon\Carbon;

beforeEach(function () {
    $this->mechanic = User::factory()->mechanic()->create([
        'medical_due' => Carbon::now()->addYear()->format('Y-m-d'),
    ]);
    $this->actingAs($this->mechanic);
    $this->settings = app(GeneralSettings::class);
});

// --- NavigationPolicy ---

it('mechanic can view reservations navigation', function () {
    $policy = new NavigationPolicy();
    expect($policy->viewReservations($this->mechanic))->toBeTrue();
});

it('mechanic can view activities navigation', function () {
    $policy = new NavigationPolicy();
    expect($policy->viewActivities($this->mechanic))->toBeTrue();
});

it('mechanic can view payments navigation', function () {
    $policy = new NavigationPolicy();
    expect($policy->viewPayments($this->mechanic))->toBeTrue();
});

// --- ReservationPolicy: create ---

it('mechanic with valid medical can create a reservation when check_medical is enabled', function () {
    $this->settings->check_medical = true;
    $this->settings->save();

    $policy = new ReservationPolicy();
    expect($policy->create($this->mechanic))->toBeTrue();
});

it('mechanic with expired medical cannot create a reservation when check_medical is enabled', function () {
    $this->mechanic->medical_due = Carbon::now()->subDay()->format('Y-m-d');
    $this->mechanic->save();

    $this->settings->check_medical = true;
    $this->settings->save();

    $policy = new ReservationPolicy();
    expect($policy->create($this->mechanic))->toBeFalse();
});

it('mechanic without medical due date cannot create a reservation when check_medical is enabled', function () {
    $this->mechanic->medical_due = null;
    $this->mechanic->save();

    $this->settings->check_medical = true;
    $this->settings->save();

    $policy = new ReservationPolicy();
    expect($policy->create($this->mechanic))->toBeFalse();
});

it('mechanic can create a reservation regardless of medical when check_medical is disabled', function () {
    $this->mechanic->medical_due = null;
    $this->mechanic->save();

    $this->settings->check_medical = false;
    $this->settings->save();

    $policy = new ReservationPolicy();
    expect($policy->create($this->mechanic))->toBeTrue();
});

// --- ReservationPolicy: update ---

it('mechanic can update their own reservation', function () {
    $plane = Plane::create(['callsign' => 'UPD-1', 'vendor' => 'Test', 'active' => true, 'counter_type' => '060']);
    $reservation = Reservation::create([
        'reservation_start' => Carbon::now()->addDay(),
        'reservation_stop'  => Carbon::now()->addDay()->addHours(2),
        'mode_id'           => Reservation::IS_CHARTER,
        'plane_id'          => $plane->id,
        'status'            => 1,
    ]);
    $reservation->bookingUsers()->attach($this->mechanic->id);

    $policy = new ReservationPolicy();
    expect($policy->update($this->mechanic, $reservation))->toBeTrue();
});

it('mechanic cannot update a reservation they are not associated with', function () {
    $otherUser = User::factory()->member()->create();
    $plane = Plane::create(['callsign' => 'UPD-2', 'vendor' => 'Test', 'active' => true, 'counter_type' => '060']);
    $reservation = Reservation::create([
        'reservation_start' => Carbon::now()->addDay(),
        'reservation_stop'  => Carbon::now()->addDay()->addHours(2),
        'mode_id'           => Reservation::IS_CHARTER,
        'plane_id'          => $plane->id,
        'status'            => 1,
    ]);
    $reservation->bookingUsers()->attach($otherUser->id);

    $policy = new ReservationPolicy();
    expect($policy->update($this->mechanic, $reservation))->toBeFalse();
});

// --- validateReservation ---

it('mechanic with maintenance type bypasses balance check even when check_balance is enabled', function () {
    $this->settings->check_balance = true;
    $this->settings->check_balance_limit_amount = 99999999;
    $this->settings->save();

    $plane = Plane::create([
        'callsign'     => 'TEST-M',
        'vendor'       => 'Test',
        'active'       => true,
        'counter_type' => '060',
    ]);

    $startDate = Carbon::now()->addDay()->format('Y-m-d');

    $data = [
        'mode_id'                => Reservation::IS_MAINTENANCE,
        'plane_id'               => $plane->id,
        'reservation_start_date' => $startDate,
        'reservation_start_time' => '10:00',
        'reservation_stop_date'  => $startDate,
        'reservation_stop_time'  => '12:00',
    ];

    $result = (new ReservationResource())->validateReservation($data);
    expect($result)->toBeTrue();
});

it('mechanic with maintenance type bypasses airworthiness check even when check_activities is enabled', function () {
    $this->settings->check_activities = true;
    $this->settings->check_activities_limit_days = 90;
    $this->settings->save();

    $plane = Plane::create([
        'callsign'     => 'TEST-M2',
        'vendor'       => 'Test',
        'active'       => true,
        'counter_type' => '060',
    ]);

    $startDate = Carbon::now()->addDay()->format('Y-m-d');

    $data = [
        'mode_id'                => Reservation::IS_MAINTENANCE,
        'plane_id'               => $plane->id,
        'reservation_start_date' => $startDate,
        'reservation_start_time' => '10:00',
        'reservation_stop_date'  => $startDate,
        'reservation_stop_time'  => '12:00',
    ];

    $result = (new ReservationResource())->validateReservation($data);
    expect($result)->toBeTrue();
});

it('mechanic with charter type is blocked by balance check when check_balance is enabled and balance is insufficient', function () {
    $this->settings->check_balance = true;
    $this->settings->check_balance_limit_amount = 99999999;
    $this->settings->save();

    $plane = Plane::create([
        'callsign'     => 'TEST-C',
        'vendor'       => 'Test',
        'active'       => true,
        'counter_type' => '060',
    ]);

    $startDate = Carbon::now()->addDay()->format('Y-m-d');

    $data = [
        'mode_id'                => Reservation::IS_CHARTER,
        'plane_id'               => $plane->id,
        'reservation_start_date' => $startDate,
        'reservation_start_time' => '10:00',
        'reservation_stop_date'  => $startDate,
        'reservation_stop_time'  => '12:00',
    ];

    $result = (new ReservationResource())->validateReservation($data);
    expect($result)->toBeFalse();
});

it('mechanic with charter type is blocked by airworthiness check when check_activities is enabled and no prior activity exists', function () {
    $this->settings->check_balance = false;
    $this->settings->check_activities = true;
    $this->settings->check_activities_limit_days = 90;
    $this->settings->save();

    $plane = Plane::create([
        'callsign'     => 'TEST-C2',
        'vendor'       => 'Test',
        'active'       => true,
        'counter_type' => '060',
    ]);

    $startDate = Carbon::now()->addDay()->format('Y-m-d');

    $data = [
        'mode_id'                => Reservation::IS_CHARTER,
        'plane_id'               => $plane->id,
        'reservation_start_date' => $startDate,
        'reservation_start_time' => '10:00',
        'reservation_stop_date'  => $startDate,
        'reservation_stop_time'  => '12:00',
    ];

    $result = (new ReservationResource())->validateReservation($data);
    expect($result)->toBeFalse();
});
