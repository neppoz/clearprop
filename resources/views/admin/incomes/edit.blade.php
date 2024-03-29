@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.income.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.incomes.update", [$income->id]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="entry_date">{{ trans('cruds.income.fields.entry_date') }}</label>
                    <input class="form-control date {{ $errors->has('entry_date') ? 'is-invalid' : '' }}" type="text"
                           name="entry_date" id="entry_date" value="{{ old('entry_date', $income->entry_date) }}"
                           required>
                    @if($errors->has('entry_date'))
                        <span class="text-danger">{{ $errors->first('entry_date') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.income.fields.entry_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="user_id">{{ trans('cruds.income.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id"
                            id="user_id" required>
                        @foreach($users as $id => $user)
                            <option
                                    value="{{ $id }}" {{ ($income->user ? $income->user->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $user }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <span class="text-danger">{{ $errors->first('user') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.income.fields.user_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="income_category_id">{{ trans('cruds.income.fields.income_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('income_category') ? 'is-invalid' : '' }}"
                            name="income_category_id" id="income_category_id">
                        @foreach($income_categories as $id => $income_category)
                            <option
                                    value="{{ $id }}" {{ ($income->income_category ? $income->income_category->id : old('income_category_id')) == $id ? 'selected' : '' }}>{{ $income_category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('income_category'))
                        <span class="text-danger">{{ $errors->first('income_category') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.income.fields.income_category_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="amount">{{ trans('cruds.income.fields.amount') }}</label>
                    <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number"
                           name="amount"
                           id="amount" value="{{ old('amount', $income->amount) }}" step="0.01" required>
                    @if($errors->has('amount'))
                        <span class="text-danger">{{ $errors->first('amount') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.income.fields.amount_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.income.fields.description') }}</label>
                    <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text"
                           name="description" id="description" value="{{ old('description', $income->description) }}">
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.income.fields.description_helper') }}</span>
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
