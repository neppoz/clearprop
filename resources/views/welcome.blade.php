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

    @if(count($checkinDates) > 0)
        <div class="row mt-1 mb-4">
            <div class="col-sm-6">
            </div><!-- /.col -->
            <div class="col-sm-6">
            </div><!-- /.col -->
        </div>
        <div class="row mt-1">
            <div class="col-12 col-sm-12 col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header"></div>
                    <div class="card-body p-1">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                </thead>
                                <tbody>
                                @forelse($checkinDates as $date => $slots)
                                    <tr>
                                        <td class="bg-gray-light text-bold text-left" colspan="4">
                                            {{ $date }}
                                        </td>
                                    </tr>
                                    @foreach($slots as $slot)
                                        <tr>
                                            <td>
                                                <span>{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $slot->reservation_start)->format('H:i') }}</span><br>
                                                <span>{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $slot->reservation_stop)->format('H:i') }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="text text-{{$slot->mode_id == 4 ? 'danger' : 'black'}}">{{ $slot->plane->callsign ?? '' }}</span><br>
                                                <span
                                                    class="badge badge-{{$slot->mode_id == 4 ? 'danger' : 'secondary'}}">{{$slot->slot->title ?? ''}}</span>
                                            </td>
                                            <td>
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
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="4">
                                                 <span
                                                     class="font-weight-lighter text-black-50 small">{{ trans('cruds.booking.fields.seats_available') . ': +' . $slot->seats_available ?? ''}}</span><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="4">
                                                <form action="{{ route('pilot.bookings.book', $slot->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                      style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="POST">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-outline-success btn-block"><i
                                                            class="fas fa-check-circle"></i>{{ trans('cruds.dashboard.book_slot') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <div class="bg-light">
                                        <div class="p-4 text-center">
                                            <i class="fas fa-paper-plane fa-2x text-black-50"></i>
                                        </div>
                                    </div>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
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

                        </div><!-- /.col -->
                        <div class="col-6 float-right">
                            @can('booking_create')
                                @if(count($bookingDates) > 0)
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
                        <table class="table">
                            <tbody>
                            @forelse($bookingDates as $date => $bookings)
                                <tr>
                                    <td class="bg-gray-light text-bold text-left" colspan="4">
                                        {{ $date }}
                                    </td>
                                </tr>
                                @foreach($bookings as $booking)
                                    <tr class="{{ $booking->bookingUsers->contains('id', auth()->user()->id) ? 'table-tr-edit' : 'table-tr' }}"
                                        data-url="{{ route('pilot.bookings.edit', $booking->id)}}">
                                        <td>
                                            <span>{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_start)->format('H:i') }}</span><br>
                                            <span>{{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $booking->reservation_stop)->format('H:i') }}</span>
                                        </td>
                                        <td>
                                        <span
                                            class="text text-{{$booking->mode_id == 4 ? 'danger' : 'black'}}">{{ $booking->plane->callsign ?? '' }}</span><br>
                                            <span
                                                class="badge badge-{{$booking->mode_id == 4 ? 'danger' : 'secondary'}}">{{$booking->mode->name ?? ''}}</span>
                                        </td>
                                        <td>
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
                                        </td>
                                        <td>
                                            <i class="fa fa-lg fa-{{ $booking->status === 0 ? 'question-circle text-warning' : 'check-circle text-success'}}"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <div class="bg-light">
                                    <div class="pt-4 text-center"><i
                                            class="fas fa-paper-plane fa-2x text-black-50"></i>
                                    </div>

                                    <div class="p-4 text-center text-success">
                                        <a class="btn btn-default" href="{{ route("pilot.bookings.create") }}">
                                            <i class="fas fa-edit"></i>
                                            {{ trans('cruds.dashboard.create_request') }}
                                        </a>
                                    </div>
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
    <script>
        $(function () {
            $('table.table').on("click", "tr.table-tr-edit", function () {
                window.location = $(this).data("url");
            });
        });
    </script>
@endsection
