@extends('layouts.admin')
@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        @can('booking_create')
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="{{ route("admin.bookings.create") }}">
                        <i class="fas fa-edit"></i>
                        {{ trans('global.new') }} {{ trans('cruds.booking.title_singular') }}
                    </a>
                </div>
            </div>
        @endcan
        {{-- {{ trans('global.systemCalendar') }} --}}
    </div>

    <div class="card-body">
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.css' />

        <div id='calendar'></div>
    </div>
</div>



@endsection

@section('scripts')
@parent
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/locales-all.min.js'></script>

<script>
    $(document).ready(function () {
        // page is now ready, initialize the calendar...
        events={!! json_encode($events) !!};

        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            height: 'auto', // will activate stickyHeaderDates automatically!
            navLinks: false, // can click day/week names to navigate views
            timeZone: 'UTC',
            slotMinTime: '07:00:00',
            slotMaxTime: '20:00:00',
            eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false, timeZoneName: 'short' },
            locale: '{{ app()->getLocale() }}',
            themeSystem: 'bootstrap',

            initialView: 'listWeek',

            headerToolbar: {
                left: 'today',
                center: 'title',
                right: 'prev,listMonth,listWeek,next'
            },
            views:{
                listWeek: {
                    type: 'listWeek',
                    titleFormat: { day: '2-digit', month: 'short'},
                    duration: { days: 5 },
                    buttonText: '{{ trans("cruds.calendar.week")}}'
                },
                listMonth: {
                    type: 'listMonth',
                    titleFormat: { day: '2-digit', month: 'short'},
                    buttonText: '{{ trans("cruds.calendar.month")}}'
                }
            },
            weekNumbers: true,
            dayMaxEvents: true, // allow "more" link when too many events
            events: events
        });

        calendar.render();
        console.log(events);
    });
</script>
@stop
