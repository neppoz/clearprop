<div class="card-header">
    {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }} <span
        class="badge badge-danger">{{$mode_name->name}}</span>
</div>
<div class="card-body">
    <form method="POST" action="{{ route("app.bookings.store") }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode_id" id="mode_id" value="{{$mode_id}}" readonly>
        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}" readonly>
        @include('app.bookings.partials.formPlane')
        @include('app.bookings.partials.formReservationStartStop')
        @include('app.bookings.partials.formDescription')
        <div class="form-group">
            <button class="btn btn-success" type="submit">
                {{ trans('global.save') }}
            </button>
        </div>
    </form>
</div>

@section('scripts')
    @parent

@endsection

