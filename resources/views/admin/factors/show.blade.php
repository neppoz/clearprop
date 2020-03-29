@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.factor.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.factors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.factor.fields.id') }}
                        </th>
                        <td>
                            {{ $factor->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.factor.fields.name') }}
                        </th>
                        <td>
                            {{ $factor->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.factor.fields.description') }}
                        </th>
                        <td>
                            {{ $factor->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.type.title') }}
                        </th>
                        <td>
                            <ul>
                                @foreach($factor->factor_types as $item)
                                    <li>{{ $item->name }} (<strong>{{ $item->pivot->rate }}</strong>{{' €/min. '}})</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.factors.index') }}">
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
            <a class="nav-link" href="#factor_users" role="tab" data-toggle="tab">
                {{ trans('cruds.user.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="factor_users">
            @includeIf('admin.factors.relationships.factorUsers', ['users' => $factor->factorUsers])
        </div>
    </div>
</div>

@endsection
