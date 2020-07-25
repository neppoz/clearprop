@extends('layouts.admin')
@section('content')
<div class="row pb-2">
    <div class="col-lg-12">
        <h3 class="page-title">{{ trans('cruds.dashboard.greeting') . auth()->user()->name }}</h3>
    </div>
</div>
<div class="row pt-2">
    <div class="col-md-3 col-sm-6 col-xs-12">
        @if($statistics['incomeAmountTotal'] > $statistics['activityAmountTotal'])
            <div class="info-box bg-success">
        @else
            <div class="info-box bg-danger">
        @endif
            <span class="info-box-icon"><i class="fas fa-fw fa-tachometer-alt"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">{{trans('cruds.dashboard.grantotal')}}</span>
                <span class="info-box-number">{{  number_format($statistics['granTotal'], 2, ',', '.') }}  &euro;</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>

                <span class="progress-description">

                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-info">
            <span class="info-box-icon"><i class="fa-fw fas fa-plane-departure"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">{{trans('cruds.dashboard.activityAmountTotal')}}</span>
                <span class="info-box-number">{{  number_format($statistics['activityAmountTotal'], 2, ',', '.') }} &euro;</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>

                <span class="progress-description">

                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-warning">
            <span class="info-box-icon"><i class="fas fa-fw fa-money-bill-alt"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">{{trans('cruds.dashboard.incomeAmountTotal')}}</span>
                <span class="info-box-number">{{  number_format($statistics['incomeAmountTotal'], 2, ',', '.') }} &euro;</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>

                <span class="progress-description">

                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-dark">
            <span class="info-box-icon"><i class="fas fa-fw fa-clock"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">{{trans('cruds.dashboard.activityHoursAndMinutes')}}</span>
                <span class="info-box-number">{{ $statistics['activityHoursAndMinutes'] }}</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>

                <span class="progress-description">

                </span>
            </div>
            <!-- /.info-box-content -->
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
