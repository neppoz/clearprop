@extends('layouts.pilot')
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


    <div class="row m-1">
        <div class="col-12 col-sm-12 col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h4 class="card-title text-primary">{{ trans('cruds.dashboard.slot_title') }}</h4>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-valign-middle">
                        <thead>
                        </thead>
                        <tbody>
                        @forelse($slotDates as $date => $slots)
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
                                        {{ $slot->plane->callsign ?? '' }}
                                    </td>
                                    {{--                                    <td>--}}
                                    {{--                                        @if (App\Booking::STATUS_RADIO[$slot->status] == 'pending')--}}
                                    {{--                                            <i class="fa fa-question-circle text-warning" aria-hidden="true"></i>--}}
                                    {{--                                        @else--}}
                                    {{--                                            <i class="fa fa-check-circle text-success" aria-hidden="true"></i>--}}
                                    {{--                                        @endif--}}
                                    {{--                                    </td>--}}
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
                                        {{--                                        <a href="{{ route('pilot.bookings.edit', $slot->id) }}"--}}
                                        {{--                                           class="text-muted">--}}
                                        {{--                                            <i class="fas fa-search"></i>--}}
                                        {{--                                        </a>--}}
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr class="bg-light">
                                <td>
                                    <i class="fa fa-check text-black-50"></i>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{--                    <a class="btn btn-sm btn-secondary float-right" href="{{ route("pilot.bookings.create") }}">--}}
                    {{--                        <i class="fas fa-edit"></i>--}}
                    {{--                        {{ trans('global.new') }} {{ trans('cruds.booking.title_singular') }}--}}
                    {{--                    </a>--}}
                    {{--                                        <a href="{{ url('/admin/bookings') }}"--}}
                    {{--                                           class="btn btn-sm btn-secondary float-right">{{ trans('cruds.dashboard.show_all_reservations') }}--}}
                    {{--                                            <i--}}
                    {{--                                                class="fas fa-arrow-circle-right"></i></a>--}}
                </div>
                <!-- /.card-footer -->
            </div>
        </div>
    </div>

    <div class="row m-2 mb-4">
        <div class="col-sm-6">
            <h4 class="m-0 text-dark">{{ trans('cruds.dashboard.personal_reservations') }}</h4>
        </div><!-- /.col -->
        <div class="col-sm-6">

            {{--            <ol class="breadcrumb float-sm-right">--}}
            {{--                <a class="btn btn-sm btn-secondary float-right" href="{{ route("pilot.bookings.create") }}">--}}
            {{--                    <i class="fas fa-edit"></i>--}}
            {{--                    {{ trans('global.new') }} {{ trans('cruds.booking.title_singular') }}--}}
            {{--                </a>--}}
            {{--                <li class="breadcrumb-item"><a href="#">Home</a></li>--}}
            {{--                <li class="breadcrumb-item active">{{ trans('cruds.dashboard.title') }}</li>--}}
            {{--            </ol>--}}
        </div><!-- /.col -->
    </div>

    <div class="row m-1">
        <div class="col-12 col-sm-12 col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route("pilot.bookings.create") }}">
                        <i class="fas fa-edit"></i>
                        {{ trans('global.create') }}
                    </a>
                    {{--                    <h4 class="card-title text-primary">{{ trans('cruds.dashboard.personal_reservations') }}</h4>--}}
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
                                <tr>
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
                                    <td>
                                        @if (App\Booking::STATUS_RADIO[$booking->status] == 'pending')
                                            <i class="fa fa-question-circle text-warning" aria-hidden="true"></i>
                                        @else
                                            <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                    {{--                                    <td>--}}
                                    {{--                                        <a href="{{ route('pilot.bookings.edit', $booking->id) }}"--}}
                                    {{--                                           class="text-muted">--}}
                                    {{--                                            <i class="fas fa-search"></i>--}}
                                    {{--                                        </a>--}}
                                    {{--                                    </td>--}}
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td class="text-center" colspan="3">
                                    Uuuups..
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a class="btn btn-sm btn-secondary float-right" href="{{ route("pilot.bookings.create") }}">
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
