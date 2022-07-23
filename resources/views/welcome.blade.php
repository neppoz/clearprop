@extends('layouts.pilot')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.dashboard.greeting') . auth()->user()->name }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('pilot.welcome')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.dashboard.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>
    <div class="row m-2">
        @include('partials.stats-general')
    </div>
    <div class="row m-2 mb-2">
        <div class="col-12">
            <div class="bg-light">
                <div class="p-2 text-center text-success">
                    <a class="btn btn-default" href="{{ route("pilot.bookings.create") }}">
                        <i class="fas fa-paper-plane text-black-50"></i>
                        {{ trans('cruds.dashboard.create_request') }}
                    </a>
                </div>
            </div>
        </div>
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
    @if(count($bookingDates) > 0)
        <div class="row mt-2 mb-2">
            <div class="col">
                <h4 class="text-dark">{{ trans('cruds.dashboard.personal_title') }}</h4>
            </div><!-- /.col -->
        </div>
        <div class="row mt-2 mb-2">
            <div class="col-12">
                @foreach($bookingDates as $date => $bookings)
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
                                    <div class="col-4 text-lg">
                                        <span
                                            class="h4 text text-{{$booking->mode_id == 4 ? 'danger' : 'black'}}">{{ $booking->plane->callsign ?? '' }}</span><br>
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
                            @if($booking->bookingUsers->contains('id', auth()->user()->id))
                                <div class="card-footer">
                                    <a class="btn btn-secondary float-right"
                                       href="{{ route('pilot.bookings.edit', $booking->id)}}">
                                        <i class="fas fa-edit"></i>{{trans('global.edit')}}</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    @endif
@endsection

