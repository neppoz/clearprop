@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
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
                            {{ trans('cruds.user.fields.instructor') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->instructor ? 'checked' : '' }}>
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
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#user_activities" role="tab" data-toggle="tab">
                {{ trans('cruds.activity.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_bookings" role="tab" data-toggle="tab">
                {{ trans('cruds.booking.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_incomes" role="tab" data-toggle="tab">
                {{ trans('cruds.income.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="user_activities">
            @includeIf('admin.users.relationships.userActivities', ['activities' => $user->userActivities])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_bookings">
            @includeIf('admin.users.relationships.userBookings', ['bookings' => $user->userBookings])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_incomes">
            @includeIf('admin.users.relationships.userIncomes', ['incomes' => $user->userIncomes])
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.activityReport.title') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.individualReport", $user) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-6">
                    <button class="btn btn-warning" type="submit">{{ trans('cruds.activityReport.fields.generateReport') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
