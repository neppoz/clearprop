@extends('layouts.admin')
@section('content')

    {{--    <div class="row m-2">--}}
    {{--        @can('user_edit' && ($userMedicalGoingDue[$userMedicalDueInFuture] > 0 OR $userMedicalGoingDue[$userMedicalIsAlreadyDue] > 0))--}}
    {{--            <div class="col">--}}
    {{--                <div class="alert alert-warning alert-dismissible">--}}
    {{--                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
    {{--                <h5><i class="icon fas fa-exclamation-circle"></i> Invalid medical</h5>--}}
    {{--                {{$userMedicalGoingDue[$userMedicalDueInFuture]}} members will be invalidated in less than a month.<br>--}}
    {{--                {{$userMedicalGoingDue[$userMedicalIsAlreadyDue]}} members have no valid medical today.<br>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        @endcan--}}
    {{--    </div>--}}
    {{--    <div class="row m-2 mb-3">--}}
    {{--        <div class="col-12 col-sm-12 col-md-4">--}}
    {{--            <h3 class="m-0 text-dark">{{ trans('cruds.dashboard.greeting') . auth()->user()->name }}</h3>--}}
    {{--        </div><!-- /.col -->--}}
    {{--        <div class="col-12 col-sm-6 col-md-4">--}}
    {{--                @if($statistics['incomeAmountTotal'] > $statistics['activityAmountTotal'])--}}
    {{--                    <div class="info-box shadow-sm">--}}
    {{--                        <span class="info-box-icon bg-success"><i class="fas fa-piggy-bank"></i></span>--}}
    {{--                        <div class="info-box-content">--}}
    {{--                            <span class="info-box-text"><h4>{{  number_format($statistics['granTotal'], 2, ',', '.') }}  &euro;</h4></span>--}}
    {{--                            <span class="info-box-number">{{ trans('cruds.dashboard.grantotal') }}</span>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                @else--}}
    {{--                    <div class="info-box shadow-sm">--}}
    {{--                        <span class="info-box-icon bg-danger"><i class="fas fa-piggy-bank"></i></span>--}}
    {{--                        <div class="info-box-content">--}}
    {{--                            <span class="info-box-text"><h4>{{  number_format($statistics['granTotal'], 2, ',', '.') }}  &euro;</h4></span>--}}
    {{--                            <span class="info-box-number">{{ trans('cruds.dashboard.grantotal') }}</span>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                @endif--}}
    {{--            </div>--}}
    {{--        <div class="col-12 col-sm-6 col-md-4">--}}
    {{--            <div class="info-box shadow-sm">--}}
    {{--                <span class="info-box-icon bg-primary"><i class="fas fa-plane"></i></span>--}}
    {{--                <div class="info-box-content">--}}
    {{--                    <span class="info-box-text"><h4>{{ $statistics['activityHoursAndMinutes'] }}</h4></span>--}}
    {{--                    <span class="info-box-number">{{ trans('cruds.dashboard.activityHoursAndMinutes') }}</span>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <div class="row m-2">--}}
    {{--        @include('partials.stats-top-dashboard')--}}
    {{--    </div>--}}
    {{--    <div class="row m-2">--}}
    {{--        @include('partials.stats-general')--}}
    {{--    </div>--}}
    @can('expense_report_access')
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12">
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-info"></i>{{ trans('global.info') }}</h5>
                    <span>{!! trans('global.service_information_admins') !!}</span>
                    <span><a class="text-white"
                             href="{{ route("admin.expense-reports.index") }}">{{trans('global.link_text_goto')}}</a></span>
                </div>
            </div>
        </div>
    @endcan
    @if(auth()->user()->is_member)
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12">
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-exclamation-circle"></i>{{ trans('global.caution') }}</h5>
                    <span>{!! trans('global.medicalCheck') !!}</span>
                    <span><a class="text-danger"
                             href="{{ route('profile.password.edit') }}">{{trans('global.message_update_profile')}}</a></span>
                </div>
            </div>
        </div>
    @endif
    <div class="row m-2 mb-3">
        <div class="col-12">
            <h5 class="text-dark">{{ trans('cruds.dashboard.reservation_title') }}</h5>
        </div>
    </div>
    <div class="row m-2 mb-3">
        <div class="col-12">
            <div class="btn-group mr-1">
                @can('booking_create')
                    <a class="btn btn-primary btn-block btn-flat"
                       href="{{route('app.bookings.create', ['mode_id' =>1]) }}"><i
                            class="fa fa-plus"></i> {{ trans('cruds.dashboard.create_charter_booking') }}</a>
                @endcan
            </div>
            <div class="btn-group mr-1">
                @can('booking_school_create')
                    <a class="btn btn-secondary btn-block btn-flat"
                       href="{{route('app.bookings.create', ['mode_id' => 2]) }}"><i
                            class="fa fa-plus"></i> {{ trans('cruds.dashboard.create_school_booking') }}</a>
                @endcan
            </div>
            <div class="btn-group mr-1">
                @can('booking_maintenance_create')
                    <a class="btn btn-danger btn-block btn-flat"
                       href="{{route('app.bookings.create', ['mode_id' =>4]) }}"><i
                            class="fa fa-plus"></i> {{ trans('cruds.dashboard.create_maintenance_booking') }}</a>
                @endcan
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
                                        <form action="{{ route('app.bookings.book', $slot->id) }}"
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
                                @if(auth()->user()->can('slot_edit'))
                                    <a class="btn btn-sm btn-outline-success float-right"
                                       href="{{route('app.bookings.edit', $slot->id)}}">
                                        <i class="fas fa-edit"></i>{{trans('global.edit')}}</a>
                                @endif
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
                                        @switch($booking->mode_id)
                                            @case('1')
                                            <span
                                                class="font-weight-bold text-primary">{{ $booking->plane->callsign ?? '' }}</span>
                                            <br>
                                            <span class="badge badge-primary">{{$booking->mode->name ?? ''}}</span><br>
                                            @break
                                            @case('2')
                                            <span
                                                class="font-weight-bold text-secondary">{{ $booking->plane->callsign ?? '' }}</span>
                                            <br>
                                            <span class="badge badge-secondary">{{$booking->mode->name ?? ''}}</span>
                                            <br>
                                            @break
                                            @case('4')
                                            <span
                                                class="font-weight-bold text-danger">{{ $booking->plane->callsign ?? '' }}</span>
                                            <br>
                                            <span class="badge badge-danger">{{$booking->mode->name ?? ''}}</span><br>
                                            @break
                                            @default
                                            <span
                                                class="font-weight-bold text-black">{{ $booking->plane->callsign ?? '' }}</span>
                                            <br>
                                            <span class="badge badge-black">{{$booking->mode->name ?? ''}}</span><br>
                                        @endswitch
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
                                @if(auth()->user()->can('booking_edit'))
                                    <a class="btn btn-sm btn-outline-success float-right"
                                       href="{{route('app.bookings.edit', $booking->id)}}">
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
    {{--    <div class="row m-2">--}}
    {{--        <div class="col-md-6">--}}
    {{--            @if(auth()->user()->can('user_management_access') AND (count($userMedicalGoingDue) > 0))--}}
    {{--                <div class="row m-2">--}}
    {{--                    <div class="col">--}}
    {{--                        <h4 class="text-dark">{{trans('global.deadline_users')}}</h4>--}}
    {{--                    </div><!-- /.col -->--}}
    {{--                </div>--}}
    {{--                <div class="row m-2">--}}
    {{--                    <div class="col">--}}
    {{--                        @include('partials.admin.deadlines-global')--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            @endif--}}
    {{--        </div>--}}
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
