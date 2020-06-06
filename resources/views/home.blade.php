@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-title">{{ trans('cruds.dashboard.title') }}</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text"></span>
            {{-- <span class="info-box-number">90<small>%</small></span> --}}
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text"></span>
            {{-- <span class="info-box-number">90<small>%</small></span> --}}
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text"></span>
            {{-- <span class="info-box-number">90<small>%</small></span> --}}
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text"></span>
            {{-- <span class="info-box-number">90<small>%</small></span> --}}
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
</div>
<div class="content">
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
                        <h1>{{ $chart1->options['chart_title'] }}</h1>
                        {!! $chart1->renderHtml() !!}
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
</div>
@endsection
@section('scripts')
@parent
{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}

@endsection
