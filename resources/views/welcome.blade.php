@extends('layouts.pilot')
@section('content')

    <div class="row mt-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.dashboard.greeting') . auth()->user()->name }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.dashboard.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>

    <div class="row mt-2">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            @if($statistics['incomeAmountTotal'] > $statistics['activityAmountTotal'])
                <div class="small-box bg-success">
                    <div class="inner">
                        <h4>{{  number_format($statistics['granTotal'], 2, ',', '.') }}  &euro;</h4>

                        <p>{{ trans('cruds.dashboard.grantotal') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                    </div>
                    <div class="small-box-footer">
                        <i class="far fa-circle"></i>
                    </div>
                </div>
            @else
                <div class="small-box bg-danger-gradient">
                    <div class="inner">
                        <h4>{{  number_format($statistics['granTotal'], 2, ',', '.') }}  &euro;</h4>

                        <p>{{ trans('cruds.dashboard.grantotal') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                    </div>
                    <div class="small-box-footer">
                        <i class="far fa-circle"></i>
                    </div>
                </div>
            @endif
        </div>
        <!-- ./col -->


        <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{ route('pilot.activities.index') }}">
                <div class="small-box bg-info-gradient">
                    <div class="inner">
                        <h4>{{  number_format($statistics['activityAmountTotal'], 2, ',', '.') }} &euro;</h4>

                        <p>{{ trans('cruds.dashboard.activityAmountTotal') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-fw fas fa-plane-departure"></i>
                    </div>
                    <div class="small-box-footer">
                        <i class="fas fa-info-circle"></i>
                    </div>
                </div>
            </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning-gradient">
                <div class="inner">
                    <h4>{{  number_format($statistics['incomeAmountTotal'], 2, ',', '.') }} &euro;</h4>

                    <p>{{ trans('cruds.dashboard.incomeAmountTotal') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fw fa-money-bill-alt"></i>
                </div>
                <div class="small-box-footer">
                    <i class="far fa-circle"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-dark-gradient">
                <div class="inner">
                    <h4>{{ $statistics['activityHoursAndMinutes'] }}</h4>

                    <p>{{ trans('cruds.dashboard.activityHoursAndMinutes') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fw fa-clock"></i>
                </div>
                <div class="small-box-footer">
                    <i class="far fa-circle"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>

    @if(count($slotsDates) > 0)
        <div class="row mt-1 mb-4">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">{{ trans('cruds.dashboard.slot_title') }}</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
            </div><!-- /.col -->
        </div>
        <div class="row mt-1">
            <div class="col-12 col-sm-12 col-md-12">
                <div class="card card-primary card-outline">
                    {{--                <div class="card-header">--}}
                    {{--                        <h4 class="card-title text-primary">{{ trans('cruds.dashboard.slot_title') }}</h4>--}}
                    {{--                </div>--}}
                    <div class="card-body table-responsive p-0">
                        <table class="table table-valign-middle">
                            <thead>
                            </thead>
                            <tbody>
                            @forelse($slotsDates as $date => $slots)
                                <tr>
                                    <td class="bg-gray-light text-bold text-left" colspan="4">
                                        {{ $date }}
                                    </td>
                                </tr>
                                @foreach($slots as $slot)
                                    <tr>
                                        <td width="10">
                                            {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $slot->reservation_start)->format('H:i') }}
                                        </td>
                                        <td width="10">
                                            {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $slot->reservation_stop)->format('H:i') }}
                                        </td>
                                        <td>
                                            {{ $slot->instructor->name ?? '' }}
                                        </td>
                                        <td class="text-right">
                                            <form action="{{ route('pilot.bookings.slot', $slot->id) }}" method="POST"
                                                  onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                  style="display: inline-block;">
                                                <input type="hidden" name="_method" value="POST">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fas fa-check-circle"></i> {{ trans('cruds.dashboard.book_slot') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <div class="bg-light">
                                    <div class="p-4 text-center"><i class="fas fa-paper-plane fa-2x text-black-50"></i>
                                    </div>
                                </div>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-footer -->
                </div>
            </div>
        </div>
    @endif

    <div class="row mt-1 mb-4">
        <div class="col-sm-6">
            <h4 class="m-0 text-dark">{{ trans('cruds.dashboard.personal_title') }}</h4>
        </div><!-- /.col -->
        <div class="col-sm-6">
        </div><!-- /.col -->
    </div>

    <div class="row mt-1">
        <div class="col-12 col-sm-12 col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            {{--                            <h4 class="m-0 text-dark">{{ trans('cruds.calendar.title') }}</h4>--}}
                        </div><!-- /.col -->
                        <div class="col-6 float-right">
                            @can('booking_create')
                                @if(count($bookingsDates) > 0)
                                    <a class="float-right" href="{{ route("pilot.bookings.create") }}">
                                        <i class="fas fa-edit"></i>
                                        {{ trans('cruds.dashboard.create_request') }}
                                    </a>
                                @endif
                            @endcan
                        </div><!-- /.col -->
                    </div>
                </div>
                <div class="card-body p-1">
                    <div class="table-responsive">
                        <table class="table table-responsive">
                            <tbody>
                            @forelse($bookingsDates as $date => $bookings)
                                <tr>
                                    <td class="bg-gray-light text-bold text-left" colspan="4">
                                        {{ $date }}
                                    </td>
                                </tr>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>
                                            {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->format('H:i') }}
                                            {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_stop)->format('H:i') }}
                                        </td>
                                        {{--                                        <td>--}}
                                        {{--                                            {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_stop)->format('H:i') }}--}}
                                        {{--                                        </td>--}}
                                        <td>
                                            {{ $booking->plane->callsign ?? '' }}
                                        </td>

                                        @if(!empty($booking->user->name))
                                            @if($booking->user->id == auth()->user()->id)
                                                <td class="text-bold">
                                                    {{ $booking->user->name ?? '' }}
                                                </td>
                                            @else
                                                <td class="text-black-50">
                                                    {{ $booking->user->name ?? '' }}
                                                </td>
                                            @endif
                                            <td style="width: 10%">
                                                @if($booking->user->id != auth()->user()->id)
                                                    @if (App\Booking::STATUS_RADIO[$booking->status] == 'pending')
                                                        <i class="fa fa-question-circle text-warning"
                                                           aria-hidden="true"></i>
                                                    @else
                                                        <i class="fa fa-check-circle text-success"
                                                           aria-hidden="true"></i>
                                                    @endif
                                                @endif
                                                @if($booking->user->id == auth()->user()->id)
                                                    <a href="{{ route('pilot.bookings.edit', $booking->id) }}">
                                                        @if (App\Booking::STATUS_RADIO[$booking->status] == 'pending')
                                                            <i class="fa fa-edit text-warning" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa fa-edit text-success" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                @endif
                                            </td>
                                        @else
                                            @if($booking->modus === 1)
                                                <td>
                                                    <span
                                                        class="badge badge-sm badge-secondary">{{ $booking->slot->title ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <i class="fa fa-check-circle text-black-50" aria-hidden="true"></i>
                                                </td>
                                            @elseif ($booking->modus === 2)
                                                <td>
                                                    <span
                                                        class="badge badge-sm badge-secondary">{{ $booking->slot->title ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <i class="fa fa-times-circle text-black-50" aria-hidden="true"></i>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach

                            @empty
                                <div class="bg-light">
                                    <div class="pt-4 text-center"><i
                                            class="fas fa-paper-plane fa-2x text-black-50"></i>
                                    </div>
                                    {{--                                <div class="p-2 text-center text-black-50">{{ trans('cruds.dashboard.no_personal_title') }}</div>--}}
                                    <div class="p-4 text-center text-success">
                                        <a class="btn btn-default" href="{{ route("pilot.bookings.create") }}">
                                            <i class="fas fa-edit"></i>
                                            {{ trans('cruds.dashboard.create_request') }}
                                        </a>
                                    </div>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>



@endsection
@section('scripts')


@endsection
