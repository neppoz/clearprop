@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-primary card-outline">

                @if($mode_id == 1)
                    @if(auth()->user()->can('booking_charter_create'))
                        @include('app.bookings.partials.charter.admin-create')
                    @endif
                    @if(auth()->user()->can('booking_create'))
                        @include('app.bookings.partials.charter.create')
                    @endif
                @endif
                @if($mode_id == 2)
                    @if(auth()->user()->can('booking_school_create'))
                        @include('app.bookings.partials.school.create')
                    @endif
                @endif
                @if($mode_id == 4)
                    @if(auth()->user()->can('booking_maintenance_create'))
                        @include('app.bookings.partials.maintenance.create')
                    @endif
                @endif
            </div>
        </div>
    </div>

@endsection


