@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.factor.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.factors.update", [$factor->id]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.factor.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                           id="name" value="{{ old('name', $factor->name) }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.factor.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.factor.fields.description') }}</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              name="description"
                              id="description">{{ old('description', $factor->description) }}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.factor.fields.description_helper') }}</span>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table" id="types_table">
                            <thead>
                            <tr>
                                <th>{{ trans('cruds.type.title_singular') }}</th>
                                <th>{{ trans('cruds.type.price') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach (old('types', $factor->types->count() ? $factor->types : ['']) as $factor_type)
                                <tr id="type{{ $loop->index }}">
                                    <td>
                                        <select name="types[]" class="form-control">
                                            <option value="">{{ trans('cruds.type.title_select') }}</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}"
                                                        @if (old('types.' . $loop->parent->index, optional($factor_type)->id) == $type->id) selected @endif
                                                >{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="rates[]" class="form-control"
                                               value="{{ (old('rates.' . $loop->index) ?? optional(optional($factor_type)->pivot)->rate) ?? '1' }}"
                                               min="0" step="0.01"/>
                                    </td>
                                </tr>
                            @endforeach
                            <tr id="type{{ count(old('types', $factor->types->count() ? $factor->types : [''])) }}"></tr>
                            </tbody>
                        </table>

                        <div class="row mt-2">
                            <div class="col-md-12 text-right">
                                <button id="add_row" class="btn btn-default pull-left">+ Add row</button>
                                <button id='delete_row' class="pull-right btn btn-danger">- Delete row</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary float-right" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            let row_number = {{ count(old('types', $factor->types->count() ? $factor->types : [''])) }};
            $("#add_row").click(function (e) {
                e.preventDefault();
                let new_row_number = row_number - 1;
                $('#type' + row_number).html($('#type' + new_row_number).html()).find('td:first-child');
                $('#types_table').append('<tr id="type' + (row_number + 1) + '"></tr>');
                row_number++;
            });
            $("#delete_row").click(function (e) {
                e.preventDefault();
                if (row_number > 1) {
                    $("#type" + (row_number - 1)).html('');
                    row_number--;
                }
            });
        });
    </script>
@endsection

