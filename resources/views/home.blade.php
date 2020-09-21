@extends('layouts.admin')
@section('content')

    <div class="row m-2">
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

    <div class="row m-2">
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
                            <a href="{{ url('/admin/expense-reports') }}"
                               class="small-box-footer">{{ trans('global.more_info') }} <i
                                    class="fas fa-arrow-circle-right"></i></a>
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
                        <a href="{{ url('/admin/activities') }}"
                           class="small-box-footer">{{ trans('global.more_info') }} <i
                                class="fas fa-arrow-circle-right"></i></a>
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
                {{--        <div class="card">--}}
                {{--            <div class="card-header border-0">--}}
                {{--                <h3 class="card-title">Products</h3>--}}
                {{--                <div class="card-tools">--}}
                {{--                    <a href="#" class="btn btn-tool btn-sm">--}}
                {{--                        <i class="fas fa-download"></i>--}}
                {{--                    </a>--}}
                {{--                    <a href="#" class="btn btn-tool btn-sm">--}}
                {{--                        <i class="fas fa-bars"></i>--}}
                {{--                    </a>--}}
                {{--                </div>--}}
                {{--            </div>--}}
                {{--            <div class="card-body table-responsive p-0">--}}
                {{--                <table class="table table-striped table-valign-middle">--}}
                {{--                    <thead>--}}
                {{--                    <tr>--}}
                {{--                        <th>Product</th>--}}
                {{--                        <th>Price</th>--}}
                {{--                        <th>Sales</th>--}}
                {{--                        <th>More</th>--}}
                {{--                    </tr>--}}
                {{--                    </thead>--}}
                {{--                    <tbody>--}}
                {{--                    <tr>--}}
                {{--                        <td>--}}
                {{--                            <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">--}}
                {{--                            Some Product--}}
                {{--                        </td>--}}
                {{--                        <td>$13 USD</td>--}}
                {{--                        <td>--}}
                {{--                            <small class="text-success mr-1">--}}
                {{--                                <i class="fas fa-arrow-up"></i>--}}
                {{--                                12%--}}
                {{--                            </small>--}}
                {{--                            12,000 Sold--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            <a href="#" class="text-muted">--}}
                {{--                                <i class="fas fa-search"></i>--}}
                {{--                            </a>--}}
                {{--                        </td>--}}
                {{--                    </tr>--}}
                {{--                    <tr>--}}
                {{--                        <td>--}}
                {{--                            <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">--}}
                {{--                            Another Product--}}
                {{--                        </td>--}}
                {{--                        <td>$29 USD</td>--}}
                {{--                        <td>--}}
                {{--                            <small class="text-warning mr-1">--}}
                {{--                                <i class="fas fa-arrow-down"></i>--}}
                {{--                                0.5%--}}
                {{--                            </small>--}}
                {{--                            123,234 Sold--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            <a href="#" class="text-muted">--}}
                {{--                                <i class="fas fa-search"></i>--}}
                {{--                            </a>--}}
                {{--                        </td>--}}
                {{--                    </tr>--}}
                {{--                    <tr>--}}
                {{--                        <td>--}}
                {{--                            <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">--}}
                {{--                            Amazing Product--}}
                {{--                        </td>--}}
                {{--                        <td>$1,230 USD</td>--}}
                {{--                        <td>--}}
                {{--                            <small class="text-danger mr-1">--}}
                {{--                                <i class="fas fa-arrow-down"></i>--}}
                {{--                                3%--}}
                {{--                            </small>--}}
                {{--                            198 Sold--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            <a href="#" class="text-muted">--}}
                {{--                                <i class="fas fa-search"></i>--}}
                {{--                            </a>--}}
                {{--                        </td>--}}
                {{--                    </tr>--}}
                {{--                    <tr>--}}
                {{--                        <td>--}}
                {{--                            <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">--}}
                {{--                            Perfect Item--}}
                {{--                            <span class="badge bg-danger">NEW</span>--}}
                {{--                        </td>--}}
                {{--                        <td>$199 USD</td>--}}
                {{--                        <td>--}}
                {{--                            <small class="text-success mr-1">--}}
                {{--                                <i class="fas fa-arrow-up"></i>--}}
                {{--                                63%--}}
                {{--                            </small>--}}
                {{--                            87 Sold--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            <a href="#" class="text-muted">--}}
                {{--                                <i class="fas fa-search"></i>--}}
                {{--                            </a>--}}
                {{--                        </td>--}}
                {{--                    </tr>--}}
                {{--                    </tbody>--}}
                {{--                </table>--}}
                {{--            </div>--}}
                {{--        </div>--}}
            </div>
            <div class="col-lg-6 col-6">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">{{ trans('cruds.dashboard.personal_reservations') }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                <tr>
                                    <th>{{ trans('cruds.booking.fields.reservation_start') }}</th>
                                    <th>{{ trans('cruds.booking.fields.plane') }}</th>
                                    <th>{{ trans('cruds.booking.fields.status') }}</th>
                                    <th>{{ trans('cruds.booking.fields.user') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>
                                            <a href="{{ url('/admin/bookings/' . $booking->id .'/edit') }}">{{ $booking->reservation_start }}</a>
                                        </td>
                                        <td>{{ $booking->plane->callsign }}</td>
                                        <td>
                                            @if (App\Booking::STATUS_RADIO[$booking->status] == 'pending')
                                                <span
                                                    class="badge badge-warning">{{ App\Booking::STATUS_RADIO[$booking->status] }}</span>
                                        </td>
                                        @else
                                            <span
                                                class="badge badge-success">{{ App\Booking::STATUS_RADIO[$booking->status] }}</span></td>
                                        @endif
                                        <td>{{ $booking->user->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <a href="{{ url('/admin/bookings') }}"
                           class="btn btn-sm btn-secondary float-right">{{ trans('global.more_info') }}</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
            </div>
        </div>



    {{-- <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">{{trans('cruds.dashboard.title_linechart')}}</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-8">

                        </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                </div>
            </div>
        </div>
    </div> --}}
@endsection
@section('scripts')


@endsection
