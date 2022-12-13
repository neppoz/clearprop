@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h4 class="m-0 text-dark">
                {{ trans('cruds.asset.title_singular') }}
            </h4>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('app.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a
                            href="{{route('admin.assets.index')}}">{{trans('cruds.asset.title')}}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.create') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>
    <div class="card-transparent">
        <div class="card-header"></div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.assets.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="category_id">{{ trans('cruds.asset.fields.category') }}</label>
                    <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}"
                            name="category_id" id="category_id">
                        @foreach($categories as $id => $category)
                            <option
                                    value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('category'))
                        <span class="text-danger">{{ $errors->first('category') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.asset.fields.category_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="plane_id">{{ trans('cruds.asset.fields.plane') }}</label>
                    <select class="form-control select2 {{ $errors->has('plane') ? 'is-invalid' : '' }}" name="plane_id"
                            id="plane_id">
                        @foreach($planes as $id => $plane)
                            <option
                                    value="{{ $id }}" {{ old('plane_id') == $id ? 'selected' : '' }}>{{ $plane }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('plane'))
                        <span class="text-danger">{{ $errors->first('plane') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.asset.fields.plane_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="serial_number">{{ trans('cruds.asset.fields.serial_number') }}</label>
                    <input class="form-control {{ $errors->has('serial_number') ? 'is-invalid' : '' }}" type="text"
                           name="serial_number" id="serial_number" value="{{ old('serial_number', '') }}">
                    @if($errors->has('serial_number'))
                        <span class="text-danger">{{ $errors->first('serial_number') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.asset.fields.serial_number_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.asset.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                           id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.asset.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="start_hours">{{ trans('cruds.asset.fields.start_hours') }}</label>
                    <input class="form-control {{ $errors->has('start_hours') ? 'is-invalid' : '' }}" type="number"
                           name="start_hours" id="start_hours" value="{{ old('start_hours', '0') }}" step="1" required>
                    @if($errors->has('start_hours'))
                        <span class="text-danger">{{ $errors->first('start_hours') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.asset.fields.start_hours_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="start_date">{{ trans('cruds.asset.fields.start_date') }}</label>
                    <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text"
                           name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                    @if($errors->has('start_date'))
                        <span class="text-danger">{{ $errors->first('start_date') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.asset.fields.start_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="end_hours">{{ trans('cruds.asset.fields.end_hours') }}</label>
                    <input class="form-control {{ $errors->has('end_hours') ? 'is-invalid' : '' }}" type="number"
                           name="end_hours" id="end_hours" value="{{ old('end_hours', '') }}" step="1" required>
                    @if($errors->has('end_hours'))
                        <span class="text-danger">{{ $errors->first('end_hours') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.asset.fields.end_hours_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="end_date">{{ trans('cruds.asset.fields.end_date') }}</label>
                    <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text"
                           name="end_date" id="end_date" value="{{ old('end_date') }}" required>
                    @if($errors->has('end_date'))
                        <span class="text-danger">{{ $errors->first('end_date') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.asset.fields.end_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="photos">{{ trans('cruds.asset.fields.photos') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('photos') ? 'is-invalid' : '' }}"
                         id="photos-dropzone">
                    </div>
                    @if($errors->has('photos'))
                        <span class="text-danger">{{ $errors->first('photos') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.asset.fields.photos_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="status_id">{{ trans('cruds.asset.fields.status') }}</label>
                    <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}"
                            name="status_id" id="status_id" required>
                        @foreach($statuses as $id => $status)
                            <option
                                    value="{{ $id }}" {{ old('status_id') == $id ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('status'))
                        <span class="text-danger">{{ $errors->first('status') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.asset.fields.status_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="location_id">{{ trans('cruds.asset.fields.location') }}</label>
                    <select class="form-control select2 {{ $errors->has('location') ? 'is-invalid' : '' }}"
                            name="location_id" id="location_id">
                        @foreach($locations as $id => $location)
                            <option
                                    value="{{ $id }}" {{ old('location_id') == $id ? 'selected' : '' }}>{{ $location }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('location'))
                        <span class="text-danger">{{ $errors->first('location') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.asset.fields.location_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="notes">{{ trans('cruds.asset.fields.notes') }}</label>
                    <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes"
                              id="notes">{{ old('notes') }}</textarea>
                    @if($errors->has('notes'))
                        <span class="text-danger">{{ $errors->first('notes') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.asset.fields.notes_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="assigned_to_id">{{ trans('cruds.asset.fields.assigned_to') }}</label>
                    <select class="form-control select2 {{ $errors->has('assigned_to') ? 'is-invalid' : '' }}"
                            name="assigned_to_id" id="assigned_to_id">
                        @foreach($assigned_tos as $id => $assigned_to)
                            <option
                                    value="{{ $id }}" {{ old('assigned_to_id') == $id ? 'selected' : '' }}>{{ $assigned_to }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('assigned_to'))
                        <span class="text-danger">{{ $errors->first('assigned_to') }}</span>
                    @endif
                    <span
                            class="help-block text-secondary small">{{ trans('cruds.asset.fields.assigned_to_helper') }}</span>
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
        var uploadedPhotosMap = {}
        Dropzone.options.photosDropzone = {
            url: '{{ route('admin.assets.storeMedia') }}',
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="photos[]" value="' + response.name + '">')
                uploadedPhotosMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedPhotosMap[file.name]
                }
                $('form').find('input[name="photos[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($asset) && $asset->photos)
                var files =
                        {!! json_encode($asset->photos) !!}
                        for(
                var i
            in
                files
            )
                {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="photos[]" value="' + file.file_name + '">')
                }
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@endsection
