@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.dashboard.greeting') . auth()->user()->name }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.dashboard.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>
    <div class="row m-2">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            @if($statistics['incomeAmountTotal'] > $statistics['activityAmountTotal'])
                <div class="small-box bg-success">
                    @else
                        <div class="small-box bg-danger-gradient">
                            @endif
                            <div class="inner">
                                <h4>{{  number_format($statistics['granTotal'], 2, ',', '.') }}  &euro;</h4>

                                <p>{{ trans('cruds.dashboard.grantotal') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-fw fa-tachometer-alt"></i>
                            </div>
                            <a href="{{ url('/admin/expense-reports') }}"
                               class="small-box-footer">{{ trans('global.more_info') }} <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                </div>
                <!-- ./col -->
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
                        <a href="{{ url('/admin/activities') }}"
                           class="small-box-footer">{{ trans('global.more_info') }} <i
                                class="fas fa-arrow-circle-right"></i></a>
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
                        <a href="{{ url('/admin/incomes') }}" class="small-box-footer">{{ trans('global.more_info') }}
                            <i class="fas fa-arrow-circle-right"></i></a>
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
                        <a href="{{ url('/admin/activity-reports') }}"
                           class="small-box-footer">{{ trans('global.more_info') }} <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
        </div>

        <div class="row m-2">
            <div class="col-lg-6 col-6">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">{{ trans('cruds.user.title') }} {{ trans('cruds.user.fields.medical_due') }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.license') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.medical_due') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($userMedicals as $user)
                                    <tr>
                                        <td>
                                            <a href="{{ url('/admin/users/' . $user->id) }}">{{ $user->name }}</a>
                                        </td>
                                        <td>
                                            {{ $user->license }}
                                        </td>
                                        <td>
                                            {{ $user->medical_due }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{--            <div class="col-lg-6 col-6">--}}
            {{--                <div class="card">--}}
            {{--                    <div class="card-header border-transparent">--}}
            {{--                        <h3 class="card-title">{{ trans('cruds.dashboard.personal_title') }}</h3>--}}

            {{--                        <div class="card-tools">--}}
            {{--                            <button type="button" class="btn btn-tool" data-card-widget="collapse">--}}
            {{--                                <i class="fas fa-minus"></i>--}}
            {{--                            </button>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                    <!-- /.card-header -->--}}
            {{--                    <div class="card-body p-0">--}}
            {{--                        <div class="table-responsive">--}}
            {{--                            <table class="table m-0">--}}
            {{--                                <thead>--}}
            {{--                                <tr>--}}
            {{--                                    <th>{{ trans('cruds.booking.fields.reservation_start') }}</th>--}}
            {{--                                    <th>{{ trans('cruds.booking.fields.plane') }}</th>--}}
            {{--                                    <th>{{ trans('cruds.booking.fields.user') }}</th>--}}
            {{--                                    <th>{{ trans('cruds.booking.fields.status') }}</th>--}}
            {{--                                </tr>--}}
            {{--                                </thead>--}}
            {{--                                <tbody>--}}
            {{--                                @foreach($bookings as $booking)--}}
            {{--                                    <tr>--}}
            {{--                                        <td>--}}
            {{--                                            <a href="{{ url('/admin/bookings/' . $booking->id .'/edit') }}">{{ $booking->reservation_start }}</a>--}}
            {{--                                        </td>--}}
            {{--                                        <td>--}}
            {{--                                            {{ $booking->plane->callsign ?? '' }}--}}
            {{--                                        </td>--}}
            {{--                                        <td>{{ $booking->user->name ?? '' }}</td>--}}
            {{--                                        <td>--}}
            {{--                                            @if (App\Booking::STATUS_RADIO[$booking->status] == 'pending')--}}
            {{--                                                <span--}}
            {{--                                                    class="badge badge-warning">{{ App\Booking::STATUS_RADIO[$booking->status] }}</span>--}}
            {{--                                            @else--}}
            {{--                                                <span--}}
            {{--                                                    class="badge badge-success">{{ App\Booking::STATUS_RADIO[$booking->status] }}</span>--}}
            {{--                                            @endif--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}
            {{--                                @endforeach--}}
            {{--                                </tbody>--}}
            {{--                            </table>--}}
            {{--                        </div>--}}
            {{--                        <!-- /.table-responsive -->--}}
            {{--                    </div>--}}
            {{--                    <!-- /.card-body -->--}}
            {{--                    <div class="card-footer clearfix">--}}
            {{--                        <a href="{{ url('/admin/bookings') }}"--}}
            {{--                           class="btn btn-sm btn-secondary float-right">{{ trans('global.more_info') }}</a>--}}
            {{--                    </div>--}}
            {{--                    <!-- /.card-footer -->--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>

@endsection
@section('scripts')

@endsection
