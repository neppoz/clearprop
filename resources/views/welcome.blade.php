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
                </div>
            @endif
        </div>
        <!-- ./col -->

        {{--                <a href="{{ url('/admin/expense-reports') }}"--}}
        {{--                   class="small-box-footer">{{ trans('global.more_info') }} <i--}}
        {{--                        class="fas fa-arrow-circle-right"></i></a>--}}

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info-gradient">
                <div class="inner">
                    <h4>{{  number_format($statistics['activityAmountTotal'], 2, ',', '.') }} &euro;</h4>

                    <p>{{ trans('cruds.dashboard.activityAmountTotal') }}</p>
                </div>
                <div class="icon">
                    <i class="fa-fw fas fa-plane-departure"></i>
                </div>
                {{--                <a href="{{ url('/activities') }}"--}}
                {{--                   class="small-box-footer">{{ trans('global.more_info') }} <i--}}
                {{--                        class="fas fa-arrow-circle-right"></i></a>--}}
            </div>
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
                {{--                <a href="{{ url('/incomes') }}" class="small-box-footer">{{ trans('global.more_info') }}--}}
                {{--                    <i class="fas fa-arrow-circle-right"></i></a>--}}
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
                {{--                                        <a href="{{ url('/admin/activity-reports') }}"--}}
                {{--                                           class="small-box-footer">{{ trans('global.more_info') }} <i--}}
                {{--                                                class="fas fa-arrow-circle-right"></i></a>--}}
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
                                    <td>
                                        {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $slot->reservation_start)->format('H:i') }}
                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $slot->reservation_stop)->format('H:i') }}
                                    </td>
                                    <td>
                                        {{ $slot->instructor->name ?? '' }}
                                    </td>
                                    <td>
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
                    @if(count($bookingsDates) > 0)
                        <a class="btn btn-success float-right" href="{{ route("pilot.bookings.create") }}">
                            <i class="fas fa-edit"></i>
                            {{ trans('global.create') }}
                        </a>
                    @endif
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-valign-middle">
                        <thead>
                        </thead>
                        <tbody>
                        @forelse($bookingsDates as $date => $bookings)
                            <tr>
                                <td class="bg-gray-light text-bold text-left" colspan="5">
                                    {{ $date }}
                                </td>
                            </tr>
                            @foreach($bookings as $booking)
                                @if($booking->user->id != auth()->user()->id)
                                    <tr class="text-black-50">
                                @else
                                    <tr>
                                        @endif
                                        <td>
                                            {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->format('H:i') }}
                                        </td>
                                        <td>
                                            {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_stop)->format('H:i') }}
                                        </td>

                                        <td>
                                            {{ $booking->user->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $booking->plane->callsign ?? '' }}
                                    </td>
                                        <td width="10">
                                            @if (App\Booking::STATUS_RADIO[$booking->status] == 'pending')
                                            <i class="fa fa-question-circle text-warning" aria-hidden="true"></i>
                                        @else
                                            <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <div class="bg-light">
                                <div class="pt-4 text-center"><i class="fas fa-paper-plane fa-2x text-black-50"></i>
                                </div>
                                {{--                                <div class="p-2 text-center text-black-50">{{ trans('cruds.dashboard.no_personal_title') }}</div>--}}
                                <div class="p-4 text-center text-success">
                                    <a class="btn btn-default" href="{{ route("pilot.bookings.create") }}">
                                        <i class="fas fa-edit"></i>
                                        {{ trans('global.create') }}
                                    </a>
                                </div>
                            </div>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>




@endsection
@section('scripts')


@endsection
