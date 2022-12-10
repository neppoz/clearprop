@extends('layouts.admin')
@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ $user->name }}</h3>
            <h6 class="m-0 text-dark">{{ trans('cruds.user.fields.email') }} : {{ $user->email }}</h6>
            <h6 class="m-0 text-dark">{{ trans('cruds.user.fields.id') }} : {{ $user->id }}</h6>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('app.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{trans('cruds.user.title')}}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
                        <li class="nav-item">
                            <a class="nav-link active show" href="#user" role="tab" aria-controls="user"
                               data-toggle="pill"
                               aria-selected="true">
                                {{ trans('global.general') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#user_activities" role="tab" aria-controls="user_activities"
                               data-toggle="pill" aria-selected="false">
                                {{ trans('cruds.activity.title') }}
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="#user_bookings" role="tab" aria-controls="user_bookings" data-toggle="pill" aria-selected="false">
                                {{ trans('cruds.booking.title') }}
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="#user_incomes" role="tab" aria-controls="user_incomes"
                               data-toggle="pill"
                               aria-selected="false">
                                {{ trans('global.subscription-payments') }}
                            </a>
                        </li>
                        @if($user->is_instructor)
                            <li class="nav-item">
                                <a class="nav-link" href="#instructor_activities" role="tab" data-toggle="pill">
                                    {{ trans('cruds.activity.title_lessons') }}
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="#actions" role="tab" aria-controls="actions" data-toggle="pill"
                               aria-selected="false">
                                {{ trans('global.actions') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" role="tabpanel" id="user" aria-labelledby="user">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.lang') }}
                                    </th>
                                    <td>
                                        {{ App\User::LANG_SELECT[$user->lang] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.taxno') }}
                                    </th>
                                    <td>
                                        {{ $user->taxno }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.phone_1') }}
                                    </th>
                                    <td>
                                        {{ $user->phone_1 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.phone_2') }}
                                    </th>
                                    <td>
                                        {{ $user->phone_2 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.address') }}
                                    </th>
                                    <td>
                                        {{ $user->address }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.city') }}
                                    </th>
                                    <td>
                                        {{ $user->city }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.factor') }}
                                    </th>
                                    <td>
                                        {{ $user->factor->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.plane') }}
                                    </th>
                                    <td>
                                        @foreach($user->planes as $key => $plane)
                                            <span class="label label-info">{{ $plane->callsign }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.license') }}
                                    </th>
                                    <td>
                                        {{ $user->license }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.medical_due') }}
                                    </th>
                                    <td>
                                        {{ $user->medical_due }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.roles') }}
                                    </th>
                                    <td>
                                        @foreach($user->roles as $key => $roles)
                                            <span class="label label-info">{{ $roles->title }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.email_verified_at') }}
                                    </th>
                                    <td>
                                        {{ $user->email_verified_at }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="user_activities" aria-labelledby="user_activities">
                            @includeIf('admin.users.relationships.userActivities', ['user_id' => $user->id])
                        </div>
                        <div class="tab-pane" role="tabpanel" id="user_incomes" aria-labelledby="user_incomes">
                            @includeIf('admin.users.relationships.userIncomes', ['user_id' => $user->id])
                        </div>
                        @if($user->is_instructor)
                            <div class="tab-pane" role="tabpanel" id="instructor_activities"
                                 aria-labelledby="instructor_activities">
                                @includeIf('admin.users.relationships.instructorActivities', ['user_id' => $user->id])
                            </div>
                        @endif
                        <div class="tab-pane" role="tabpanel" id="actions" aria-labelledby="actions">
                            <div class="callout callout-warning">
                                <h5>{{ trans('cruds.activityReport.title') }}</h5>
                                <p>{{ trans('cruds.activityReport.description_text') }}<strong>{{$user->email}}</strong>
                                </p>
                                <form method="POST" action="{{ route("admin.users.individualReport", $user) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-warning"
                                                    type="submit">{{ trans('cruds.activityReport.fields.generateReport') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
