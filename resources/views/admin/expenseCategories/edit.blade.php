@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.expenseCategory.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.expense-categories.update", [$expenseCategory->id]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.expenseCategory.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                           id="name" value="{{ old('name', $expenseCategory->name) }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.expenseCategory.fields.name_helper') }}</span>
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
