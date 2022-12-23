@extends('layouts.admin')
@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h2 class="m-0">{{ trans('cruds.dashboard.greeting') . auth()->user()->name }}</h2>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('app.home')}}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    @if($currentUserMedicalBeyondDueDate)
        <div class="row">
            <div class="col-12">
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex p-0 border-none">
                    <h3 class="card-title p-3">
                        <i class="fas fa-plane mr-1"></i>
                        {{ trans('cruds.activity.title') }}
                    </h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        @foreach($collectionActivityStatistics as $activityStatistics)
                            <li class="nav-item"><a
                                        class="nav-link {{$loop->first ? 'active' : ''}}"
                                        href="#tab_{{$activityStatistics['id']}}"
                                        data-toggle="tab">{{$activityStatistics['name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        @foreach($collectionActivityStatistics as $activityStatistics)
                            <div class="tab-pane {{$loop->first ? 'active' : ''}}"
                                 id="tab_{{$activityStatistics['id']}}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="info-box mb-3">
                        <span class="info-box-icon bg-navy elevation-1"><i
                                    class="fas fa-plane"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">{{trans('cruds.dashboard.statistics.totalAirtime')}}</span>
                                                <span class="info-box-number h4">
                                                    {{sprintf("%02d", intval($activityStatistics['sum'] / 60)) . 'h : ' . sprintf("%02d", $activityStatistics['sum'] % 60) . 'm'}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box mb-3">
                        <span class="info-box-icon bg-navy elevation-1"><i
                                    class="fas fa-list-ol"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">{{trans('cruds.dashboard.statistics.loggedMissions')}}</span>
                                                <span class="info-box-number h4">{{$activityStatistics['count']}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box mb-3">
                        <span class="info-box-icon bg-navy elevation-1"><i
                                    class="fas fa-tachometer-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">{{trans('cruds.dashboard.statistics.avgdurationpermission')}}</span>
                                                <span class="info-box-number h4">{{sprintf("%02d", intval($activityStatistics['avg'] / 60)) . 'h : ' . sprintf("%02d", $activityStatistics['avg'] % 60) . 'm'}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header d-flex p-0 border-none">
                    <h3 class="card-title p-3">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ trans('cruds.dashboard.reservation_title') }}
                    </h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a
                                    class="nav-link"
                                    href="#tab_card"
                                    data-toggle="tab">Card</a></li>
                        <li class="nav-item"><a
                                    class="nav-link active"
                                    href="#tab_calendar"
                                    data-toggle="tab">Calendar</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane"
                             id="tab_card">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="btn-group mr-1">
                                        @can('booking_create')
                                            <a class="btn btn-primary btn-block btn-flat"
                                               href="{{route('app.bookings.create', ['mode_id' =>1]) }}"><i
                                                        class="fa fa-plus"></i> {{ trans('cruds.dashboard.create_charter_booking') }}
                                            </a>
                                        @endcan
                                    </div>
                                    <div class="btn-group mr-1">
                                        @can('booking_school_create')
                                            <a class="btn btn-secondary btn-block btn-flat"
                                               href="{{route('app.bookings.create', ['mode_id' => 2]) }}"><i
                                                        class="fa fa-plus"></i> {{ trans('cruds.dashboard.create_school_booking') }}
                                            </a>
                                        @endcan
                                    </div>
                                    <div class="btn-group mr-1">
                                        @can('booking_maintenance_create')
                                            <a class="btn btn-danger btn-block btn-flat"
                                               href="{{route('app.bookings.create', ['mode_id' =>4]) }}"><i
                                                        class="fa fa-plus"></i> {{ trans('cruds.dashboard.create_maintenance_booking') }}
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
                                                            <div class="col-3 h6">
                                                                @switch($booking->mode_id)
                                                                    @case('1')
                                                                    <span
                                                                            class="font-weight-bold text-primary">{{ $booking->plane->callsign ?? '' }}</span>
                                                                    <br>
                                                                    <span class="badge badge-primary">{{$booking->mode->name ?? ''}}</span>
                                                                    <br>
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
                                                                    <span class="badge badge-danger">{{$booking->mode->name ?? ''}}</span>
                                                                    <br>
                                                                    @break
                                                                    @default
                                                                    <span
                                                                            class="font-weight-bold text-black">{{ $booking->plane->callsign ?? '' }}</span>
                                                                    <br>
                                                                    <span class="badge badge-black">{{$booking->mode->name ?? ''}}</span>
                                                                    <br>
                                                                @endswitch
                                                            </div>
                                                            <div class="col-5">
                                                                @foreach($booking->bookingInstructors as $instructorBookings)
                                                                    <span
                                                                            class="{{ $instructorBookings->id == auth()->user()->id ? 'font-weight-bold' : 'font-weight-light'}}">{{ $instructorBookings->name ?? '' }}</span>
                                                                    <br>
                                                                @endforeach
                                                                @foreach($booking->bookingUsers as $userBookings)
                                                                    <span
                                                                            class="{{ $userBookings->id == auth()->user()->id ? 'font-weight-bold' : 'font-weight-light'}}">{{ $userBookings->name ?? '' }}</span>
                                                                    <br>
                                                                    @if($loop->last)
                                                                        @if($booking->checkin == 1 && $booking->seats_available > 0 && $booking->status == 1 && $userBookings->id != auth()->user()->id)
                                                                            <div
                                                                                    class="pt-2 font-weight-bold text-secondary small">{{ trans('cruds.booking.fields.seats_available')}} {{$booking->seats_available}}</div>
                                                                            <form action="{{ route('app.bookings.book', $booking->id) }}"
                                                                                  method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="_method"
                                                                                       value="POST">
                                                                                <button type="submit"
                                                                                        class="btn btn-outline-success btn-block"
                                                                                        id="show_confirm_book"
                                                                                        data-toggle="tooltip"
                                                                                        title="{{ trans('cruds.dashboard.book_slot') }}">
                                                                                    <i class="fas fa-check-circle"></i>{{ trans('cruds.dashboard.book_slot') }}
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                        @if($booking->checkin == 1 && $booking->status == 1 && $userBookings->id == auth()->user()->id)
                                                                            <div
                                                                                    class="pt-2 font-weight-bold text-secondary small">{{ trans('cruds.booking.fields.seats_available')}} {{$booking->seats_available}}</div>
                                                                            <form action="{{ route('app.bookings.revoke', $booking->id) }}"
                                                                                  method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="_method"
                                                                                       value="POST">
                                                                                <button type="submit"
                                                                                        class="btn btn-outline-danger btn-block"
                                                                                        id="show_revoke_book"
                                                                                        data-toggle="tooltip"
                                                                                        title="{{ trans('cruds.dashboard.book_slot') }}">
                                                                                    <i class="fas fa-trash"></i> {{ trans('cruds.dashboard.revoke_slot') }}
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                                <span
                                                                        class="font-weight-lighter text-black-50 small">{{$booking->description ?? ''}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="row">
                                                            <div class="col-6 float-left">
                                                                @if(!empty($booking->slot->title))
                                                                    <span class="text-black small">{{$booking->slot->title}}</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-6 float-right">
                                                                @can('booking_edit')
                                                                    <a class="btn btn-sm btn-outline-info float-right"
                                                                       href="{{route('app.bookings.edit', $booking->id)}}">
                                                                        <i class="fas fa-edit"></i>{{trans('global.edit')}}
                                                                    </a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane active"
                             id="tab_calendar">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="btn-group mr-1">
                                        @can('booking_create')
                                            <a class="btn btn-primary btn-block btn-flat"
                                               href="{{route('app.bookings.create', ['mode_id' =>1]) }}"><i
                                                        class="fa fa-plus"></i> {{ trans('cruds.dashboard.create_charter_booking') }}
                                            </a>
                                        @endcan
                                    </div>
                                    <div class="btn-group mr-1">
                                        @can('booking_school_create')
                                            <a class="btn btn-secondary btn-block btn-flat"
                                               href="{{route('app.bookings.create', ['mode_id' => 2]) }}"><i
                                                        class="fa fa-plus"></i> {{ trans('cruds.dashboard.create_school_booking') }}
                                            </a>
                                        @endcan
                                    </div>
                                    <div class="btn-group mr-1">
                                        @can('booking_maintenance_create')
                                            <a class="btn btn-danger btn-block btn-flat"
                                               href="{{route('app.bookings.create', ['mode_id' =>4]) }}"><i
                                                        class="fa fa-plus"></i> {{ trans('cruds.dashboard.create_maintenance_booking') }}
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    @parent
    <script src="//cdn.jsdelivr.net/npm/fullcalendar@6.0.0/index.global.js"></script>
    <script>
        $(document).ready(function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                allDaySlot: false,
                slotMinTime: '07:00:00',
                slotMaxTime: '20:00:00',
                slotDuration: '01:00:00',
                slotLabelFormat: {hour: '2-digit', minute: '2-digit', hour12: false},
                eventTimeFormat: {hour: '2-digit', minute: '2-digit', hour12: false},
                locale: '{{ app()->getLocale() }}',
                height: "auto",
                themeSystem: 'bootstrap',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {!! $bookingCalendarEvents !!},

            });
            calendar.render();

            $('#show_confirm_book').click(function (event) {
                var form = $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                Swal.fire({
                    title: '{{ trans('global.areYouSure') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5cb85c',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ trans('global.yesConfirm') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
            $('#show_revoke_book').click(function (event) {
                var form = $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                Swal.fire({
                    title: '{{ trans('global.areYouSure') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ trans('global.yesDelete') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    </script>
@endsection
