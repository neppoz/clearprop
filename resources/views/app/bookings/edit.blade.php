@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-primary card-outline">
                @if($mode_id == 1)
                    @if(auth()->user()->can('booking_charter_admin_edit'))
                        @include('app.bookings.partials.charter.admin-edit')
                    @elseif(auth()->user()->can('booking_charter_edit') && $booking->bookingUsers->contains('id', auth()->user()->id))
                        @include('app.bookings.partials.charter.edit')
                    @endif
                @endif
                @if($mode_id == 2)
                    @if(auth()->user()->can('booking_school_edit'))
                        @include('app.bookings.partials.school.edit')
                    @endif
                @endif
                @if($mode_id == 3)
                    @if(auth()->user()->can('booking_promotion_edit'))
                        @include('app.bookings.partials.promotion.edit')
                    @endif
                @endif
                @if($mode_id == 4)
                    @if(auth()->user()->can('booking_maintenance_edit'))
                        @include('app.bookings.partials.maintenance.edit')
                    @endif
                @endif
            </div>
        </div>
    </div>

@endsection


@section('scripts')

@endsection
