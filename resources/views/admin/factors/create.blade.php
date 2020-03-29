@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.factor.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.factors.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.factor.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.factor.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.factor.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.factor.fields.description_helper') }}</span>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table" id="types_table">
                        <thead>
                            <tr>
                                <th>{{ trans('cruds.type.title_select') }}</th>
                                <th>{{ trans('cruds.type.title_price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="type0">
                                <td>
                                    <select name="types[]" class="form-control">
                                        <option value="">{{ trans('cruds.type.title_select') }}</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}">
                                                {{ $type->name }} (${{ number_format($type->rate, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="rates[]" class="form-control" value="0" />
                                </td>
                            </tr>
                            <tr id="type1"></tr>
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
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
  $(document).ready(function(){
    let row_number = 1;
    $("#add_row").click(function(e){
      e.preventDefault();
      let new_row_number = row_number - 1;
      $('#type' + row_number).html($('#type' + new_row_number).html()).find('td:first-child');
      $('#types_table').append('<tr id="type' + (row_number + 1) + '"></tr>');
      row_number++;
    });

    $("#delete_row").click(function(e){
      e.preventDefault();
      if(row_number > 1){
        $("#type" + (row_number - 1)).html('');
        row_number--;
      }
    });
  });
</script>
@endsection
