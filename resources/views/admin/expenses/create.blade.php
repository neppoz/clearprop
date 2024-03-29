@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.expense.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.expenses.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="expense_category_id">{{ trans('cruds.expense.fields.expense_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('expense_category') ? 'is-invalid' : '' }}"
                            name="expense_category_id" id="expense_category_id">
                        @foreach($expense_categories as $id => $expense_category)
                            <option
                                    value="{{ $id }}" {{ old('expense_category_id') == $id ? 'selected' : '' }}>{{ $expense_category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('expense_category'))
                        <span class="text-danger">{{ $errors->first('expense_category') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.expense.fields.expense_category_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="entry_date">{{ trans('cruds.expense.fields.entry_date') }}</label>
                    <input class="form-control date {{ $errors->has('entry_date') ? 'is-invalid' : '' }}" type="text"
                           name="entry_date" id="entry_date" value="{{ old('entry_date') }}" required>
                    @if($errors->has('entry_date'))
                        <span class="text-danger">{{ $errors->first('entry_date') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.expense.fields.entry_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="amount">{{ trans('cruds.expense.fields.amount') }}</label>
                    <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number"
                           name="amount"
                           id="amount" value="{{ old('amount', '') }}" step="0.01" required>
                    @if($errors->has('amount'))
                        <span class="text-danger">{{ $errors->first('amount') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.expense.fields.amount_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.expense.fields.description') }}</label>
                    <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text"
                           name="description" id="description" value="{{ old('description', '') }}">
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.expense.fields.description_helper') }}</span>
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
