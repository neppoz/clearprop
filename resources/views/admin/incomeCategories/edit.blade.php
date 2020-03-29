@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.incomeCategory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.income-categories.update", [$incomeCategory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.incomeCategory.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $incomeCategory->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.incomeCategory.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('deposit') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="deposit" id="deposit" value="1" {{ $incomeCategory->deposit || old('deposit', 0) === 1 ? 'checked' : '' }} required>
                    <label class="required form-check-label" for="deposit">{{ trans('cruds.incomeCategory.fields.deposit') }}</label>
                </div>
                @if($errors->has('deposit'))
                    <span class="text-danger">{{ $errors->first('deposit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.incomeCategory.fields.deposit_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection