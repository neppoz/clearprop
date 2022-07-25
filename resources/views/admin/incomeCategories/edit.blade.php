@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.incomeCategory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.income-categories.update", [$incomeCategory->id]) }}"
              enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.incomeCategory.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                       id="name" value="{{ old('name', $incomeCategory->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span
                    class="help-block text-secondary small">{{ trans('cruds.incomeCategory.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.incomeCategory.fields.deposit') }}</label>
                @foreach(App\IncomeCategory::DEPOSIT_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('deposit') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="deposit_{{ $key }}" name="deposit"
                               value="{{ $key }}"
                               {{ old('deposit', $incomeCategory->deposit) === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="deposit_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('deposit'))
                    <span class="text-danger">{{ $errors->first('deposit') }}</span>
                @endif
                <span
                    class="help-block text-secondary small">{{ trans('cruds.incomeCategory.fields.deposit_helper') }}</span>
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
