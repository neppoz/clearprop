<div class="col-12 col-sm-6 col-md-3">
    <!-- small box -->
    @if($statistics['incomeAmountTotal'] > $statistics['activityAmountTotal'])
        <div class="small-box bg-gradient-success">
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
        <div class="small-box bg-gradient-danger">
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
<div class="col-12 col-sm-6 col-md-3">
    <!-- small box -->
    <a href="{{ route('pilot.activities.index') }}">
        <div class="small-box bg-gradient-info">
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
<div class="clearfix hidden-md-up"></div>
<div class="col-12 col-sm-6 col-md-3">
    <!-- small box -->
    <div class="small-box bg-gradient-warning">
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
<div class="col-12 col-sm-6 col-md-3">
    <!-- small box -->
    <div class="small-box bg-gradient-dark">
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
