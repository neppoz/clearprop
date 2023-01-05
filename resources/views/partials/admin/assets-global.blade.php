@forelse($statistics as $plane => $assets)
    <div class="card card-primary card-outline collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ $plane }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach($assets as $asset)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col">
                                <div class="progress-group">
                                    <strong>{{ $asset->name }}</strong>
                                    <span class="float-right"><span
                                                class="text-bold text-{{ $asset->progressBarColor ?? 'primary' }}">{{ $asset->start_hours + $asset->current_running_hours ?? 'N/A ' }}</span>/{{ $asset->end_hours ?? 'N/A ' }} <small><strong>h</strong></small></span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-{{ $asset->progressBarColor ?? 'primary' }}"
                                             style="width: {{ $asset->progressBarInPercent }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex align-items-center">
                                <span class="text-left">{{ trans('global.due_date') }}</span>
                            </div>
                            <div class="col">
                                <h6 class="float-right">
                                    <strong>{{ $asset->daysUntilDueDate }}</strong>
                                </h6>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="card-footer">
            <div class="float-right">

            </div>
        </div>
    </div>
@empty
    <p></p>
@endforelse
@section('scripts')
    @parent
    <script>
        $(function () {

        });
    </script>
@endsection
