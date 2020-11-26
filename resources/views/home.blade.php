@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.dashboard.greeting') . auth()->user()->name }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.dashboard.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>
    <div class="row m-2">
        @include('partials.admin.stats-general')
    </div>
    <div class="row m-2">
        {{--        @include('partials.admin.stats-minutes')--}}
    </div>
    <div class="row m-2">
        @include('partials.admin.deadlines')
    </div>
    <div class="row m-2">
        @include('partials.admin.assets-global')
    </div>


@endsection

@section('scripts')
    @parent

@endsection
