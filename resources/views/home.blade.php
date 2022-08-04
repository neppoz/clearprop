@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.dashboard.greeting') . auth()->user()->name }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a
                        href="{{route(Route::current()->getName())}}">{{trans('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.dashboard.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>
    <div class="row m-2">
        @include('partials.stats-general')
    </div>
    <div class="row m-2">
        <div class="col">
            <h4 class="text-dark">{{ trans('cruds.dashboard.reservation_title') }}</h4>
        </div><!-- /.col -->
    </div>
    <div class="row m-2">
        <div class="col-12">
            <div class="bg-light">
                <div class="p-2 text-center text-success">
                    <a class="btn btn-default" href="{{Request::route()->getPrefix() . "/bookings/create" }}">
                        <i class="fas fa-paper-plane text-black-50"></i>
                        {{ trans('cruds.dashboard.create_request') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-2">
        @if(count($checkinDates) > 0)
            @foreach($checkinDates as $date => $slots)
                <div class="col-12 col-sm-6 col-md-4">
                    @foreach($slots as $slot)
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <div class="float-left">
                                    <span class="font-weight-normal">{{$slot->slot->title ?? ''}}</span>
                                </div>
                                <div class="float-lg-right">
                                    <span
                                        class="font-weight-bolder">{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $slot->reservation_start)->isoFormat('ddd DD MMM') }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 text-lg">
                                        <span>{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $slot->reservation_start)->format('H:i') }}</span><br>
                                        <span>{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $slot->reservation_stop)->format('H:i') }}</span>
                                    </div>
                                    <div class="col-4 h6">
                                        <span
                                            class="font-weight-bold text-{{$slot->mode_id == 4 ? 'danger' : 'black'}}">{{ $slot->plane->callsign ?? '' }}</span><br>
                                    </div>
                                    <div class="col-5">
                                        @foreach($slot->bookingInstructors as $instructorBookings)
                                            <span
                                                class="text text-black">{{ $instructorBookings->name ?? '' }}</span>
                                            <br>
                                        @endforeach
                                        @foreach($slot->bookingUsers as $bookingUser)
                                            <span
                                                class="text text-black">{{ $bookingUser->name ?? '' }}</span>
                                            <br>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row text-center mt-2">
                                    <div
                                        class="col font-weight-lighter text-black-50 small">{{ trans('cruds.booking.fields.seats_available') . ': +' . $slot->seats_available ?? ''}}</div>
                                    <br>
                                </div>
                                <div class="row text-center">
                                    <div class="col">
                                        <form action="{{ route('pilot.bookings.book', $slot->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                              style="display: inline-block;">
                                            <input type="hidden" name="_method" value="POST">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-outline-success btn-block">
                                                <i class="fas fa-check-circle"></i>{{ trans('cruds.dashboard.book_slot') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
    <div class="row m-2">
        @if(count($bookingDates) > 0)
            @foreach($bookingDates as $date => $bookings)
                <div class="col-12 col-sm-6 col-md-4">
                    @foreach($bookings as $booking)
                        <div class="card card-dark">
                            <div class="h5 card-header">
                                <div class="float-left">
                                    @if((Carbon\Carbon::createFromFormat('d/m/Y H:i',$booking->reservation_start))->isSameDay(Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_stop)))
                                        {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->isoFormat('ddd DD MMM') }}
                                    @else
                                        {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->isoFormat('ddd DD MMM') }}
                                        <i class="fas fa-arrow-right"></i>
                                        {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_stop)->isoFormat('ddd DD MMM') }}
                                    @endif
                                </div>
                                <div class="float-right">
                                    <i class="fa fa-{{ $booking->status === 0 ? 'question-circle text-warning' : 'check-circle text-success'}}"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 text-lg">
                                        <i class="fas fa-plane-departure"></i><br>
                                        <span>{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->format('H:i') }}</span><br>
                                        <i class="fas fa-plane-arrival"></i><br>
                                        <span>{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_stop)->format('H:i') }}</span>
                                    </div>
                                    <div class="col-4 h6">
                                    <span
                                        class="font-weight-bold text-{{$booking->mode_id == 4 ? 'danger' : 'black'}}">{{ $booking->plane->callsign ?? '' }}</span><br>
                                        <span
                                            class="badge badge-{{$booking->mode_id == 4 ? 'danger' : 'secondary'}}">{{$booking->mode->name ?? ''}}</span><br>
                                    </div>
                                    <div class="col-5">
                                        @foreach($booking->bookingInstructors as $instructorBookings)
                                            <span
                                                class="text {{ $instructorBookings->id == auth()->user()->id ? 'text-primary' : 'text-black'}}">{{ $instructorBookings->name ?? '' }}</span>
                                            <br>
                                        @endforeach
                                        @foreach($booking->bookingUsers as $userBookings)
                                            <span
                                                class="text {{ $userBookings->id == auth()->user()->id ? 'text-primary' : 'text-black'}}">{{ $userBookings->name ?? '' }}</span>
                                            <br>
                                        @endforeach
                                        <span
                                            class="font-weight-lighter text-black-50 small">{{$booking->description ?? ''}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                @if(auth()->user()->can('booking_edit') && $booking->bookingUsers->contains('id', auth()->user()->id))
                                    <a class="btn btn-sm btn-outline-success float-right"
                                       href="{{route(Route::getCurrentRoute()->uri().'.bookings.edit', $booking->id)}}">
                                        <i class="fas fa-edit"></i>{{trans('global.edit')}}</a>
                                @endif
                                @if(auth()->user()->can('booking_all_users_edit'))
                                    <a class="btn btn-sm btn-outline-success float-right"
                                       href="{{route(Route::getCurrentRoute()->uri().'.bookings.edit', $booking->id)}}">
                                        <i class="fas fa-edit"></i>{{trans('global.edit')}}</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
    <!-- conditional data -->
    <div class="row m-2">
        <div class="col-md-6">
            @if(auth()->user()->can('user_management_access') AND (count($userMedicalGoingDue) > 0))
                <div class="row m-2">
                    <div class="col">
                        <h4 class="text-dark">{{trans('global.deadline_users')}}</h4>
                    </div><!-- /.col -->
                </div>
                <div class="row m-2">
                    <div class="col">
                        @include('partials.admin.deadlines-global')
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            @if(auth()->user()->can('asset_show') AND (count($statistics['assetsOverhaulData']) > 0))
                <div class="row m-2">
                    <div class="col">
                        <h4 class="text-dark">{{trans('global.deadline_assets')}}</h4>
                    </div><!-- /.col -->
                </div>
                <div class="row m-2">
                    <div class="col">
                        @include('partials.admin.assets-global')
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @parent

@endsection
