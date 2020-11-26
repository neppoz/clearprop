<div class="col-lg-3 col-md-6 col-sm-12">
    <!-- small box -->
    <div
        class="small-box bg-{{$statistics['incomeAmountTotal'] > $statistics['activityAmountTotal'] ? 'success' : 'danger-gradient'}}">
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
<div class="col-lg-3 col-md-6 col-sm-12">
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
<div class="col-lg-3 col-md-6 col-sm-12">
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
<div class="col-lg-3 col-md-6 col-sm-12">
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

@section('scripts')
    @parent

@endsection
