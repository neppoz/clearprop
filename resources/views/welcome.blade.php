@extends('layouts.frontend')
@section('content')

    <div class="row mt-2 mb-2">
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

    <div class="row mt-2 mb-2">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            @if($statistics['incomeAmountTotal'] > $statistics['activityAmountTotal'])
                <div class="small-box bg-success">
                    @else
                        <div class="small-box bg-danger">
                            @endif
                            <div class="inner">
                                <h4>{{  number_format($statistics['granTotal'], 2, ',', '.') }}  &euro;</h4>

                                <p>{{ trans('cruds.dashboard.grantotal') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-fw fa-tachometer-alt"></i>
                            </div>
                            {{--                <a href="{{ url('/admin/expense-reports') }}"--}}
                            {{--                   class="small-box-footer">{{ trans('global.more_info') }} <i--}}
                            {{--                        class="fas fa-arrow-circle-right"></i></a>--}}
                        </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
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
                    <div class="small-box bg-warning">
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
                {{--        <div class="col-12 col-sm-6 col-md-6">--}}
                {{--            <div class="info-box">--}}
                {{--                <span class="info-box-icon bg-gray-light elevation-2"><i class="fas fa-fw fa-tachometer-alt"></i></span>--}}

                {{--                <div class="info-box-content">--}}
                {{--                    @if($statistics['incomeAmountTotal'] > $statistics['activityAmountTotal'])--}}
                {{--                        <span class="info-box-number text-success">{{  number_format($statistics['granTotal'], 2, ',', '.') }} &euro;</span>--}}
                {{--                    @else--}}
                {{--                        <span--}}
                {{--                            class="info-box-number">{{  number_format($statistics['granTotal'], 2, ',', '.') }} &euro;</span>--}}
                {{--                    @endif--}}
                {{--                    <span class="info-box-text">--}}
                {{--                          {{ trans('cruds.dashboard.grantotal') }}--}}
                {{--                    </span>--}}
                {{--                </div>--}}
                {{--                <!-- /.info-box-content -->--}}
                {{--            </div>--}}
                {{--            <!-- /.info-box -->--}}
                {{--        </div>--}}
                {{--        <div class="col-12 col-sm-6 col-md-6">--}}
                {{--            <div class="info-box">--}}
                {{--                <span class="info-box-icon bg-dark-gradient elevation-2"><i class="fas fa-fw fa-clock"></i></span>--}}

                {{--                <div class="info-box-content">--}}
                {{--                <span class="info-box-number">--}}
                {{--                      {{ $statistics['activityHoursAndMinutes'] }}--}}
                {{--                </span>--}}
                {{--                    <span class="info-box-text">{{ trans('cruds.dashboard.activityHoursAndMinutes') }}</span>--}}
                {{--                </div>--}}
                {{--                <!-- /.info-box-content -->--}}
                {{--            </div>--}}
                {{--            <!-- /.info-box -->--}}
                {{--        </div>--}}
        </div>

        <div class="row mt-2 mb-2">
            <div class="col-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h4 class="card-title">{{ trans('cruds.dashboard.personal_reservations') }}</h4>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-valign-middle">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookings as $booking)
                            <tr class="bg-gray-light text-bold">
                                <td>
                                    @if (App\Booking::STATUS_RADIO[$booking->status] == 'pending')
                                        <span
                                            class="badge badge-warning">{{ App\Booking::STATUS_RADIO[$booking->status] }}</span>
                                    @else
                                        <span
                                            class="badge badge-success">{{ App\Booking::STATUS_RADIO[$booking->status] }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($booking->reservation_start)->localeDayOfWeek }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($booking->reservation_start)->format('d.m') }}
                                </td>
                                <td>
                                    {{--                                    <a href="{{ url('#') }}" class="text-muted">--}}
                                    {{--                                        <i class="fas fa-search"></i>--}}
                                    {{--                                    </a>--}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($booking->reservation_start)->format('H:i') }}
                                    &nbsp; {{ \Carbon\Carbon::parse($booking->reservation_stop)->format('H:i') }}
                                </td>
                                <td>
                                    {{ $booking->plane->callsign }}
                                </td>
                                <td colspan="2">
                                    {{ $booking->instructor->name ?? '' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <a class="btn btn-sm btn-secondary float-right" href="{{ route("frontend.bookings.create") }}">
                            <i class="fas fa-edit"></i>
                            {{ trans('global.new') }} {{ trans('cruds.booking.title_singular') }}
                        </a>
                        {{--                    <a href="{{ url('/admin/bookings') }}"--}}
                        {{--                       class="btn btn-sm btn-secondary float-right">{{ trans('cruds.dashboard.show_all_reservations') }}--}}
                        {{--                        <i--}}
                        {{--                            class="fas fa-arrow-circle-right"></i></a>--}}
                    </div>
                    <!-- /.card-footer -->
                </div>
            </div>
        </div>

@endsection
@section('scripts')


@endsection
