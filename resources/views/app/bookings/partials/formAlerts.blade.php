<div class="form-group">
    <div class="alert alert-warning alert-dismissible" id="warning-medical" style="display: none">
        <h5><i class="icon fas fa-info"></i>{{ trans('global.caution') }}</h5>
        {!! trans('global.medicalCheck') !!}
    </div>
    <div class="alert alert-warning alert-dismissible" id="warning-activity" style="display: none">
        <h5><i class="icon fas fa-info"></i>{{ trans('global.caution') }}</h5>
        {!! trans('global.activityCheck') !!}
    </div>
    <div class="alert alert-info alert-dismissible" id="info-balance" style="display: none">
        <h5><i class="icon fas fa-info"></i>{{ trans('global.info') }}</h5>
        {{ trans('global.balanceCheck') }}
    </div>
    <div class="alert alert-info alert-dismissible" id="info-rating" style="display: none">
        <h5><i class="icon fas fa-info"></i>{{ trans('global.info') }}</h5>
        {{ trans('global.ratingCheck') }}
    </div>
</div>
