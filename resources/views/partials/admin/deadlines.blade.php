<div class="col-lg-4 col-md-12 col-sm-12">
    <div class="card">
        <div class="card-header border-transparent">
            <h3 class="card-title">Soci</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                    {{--                    <thead>--}}
                    {{--                    <tr>--}}
                    {{--                        <th>--}}
                    {{--                            {{ trans('cruds.user.fields.name') }}--}}
                    {{--                        </th>--}}
                    {{--                        <th>--}}
                    {{--                            {{ trans('cruds.user.fields.medical_due') }}--}}
                    {{--                        </th>--}}
                    {{--                    </tr>--}}
                    {{--                    </thead>--}}
                    <tbody>
                    @forelse($userMedicalGoingDue as $user)
                        <tr>
                            <td>
                                <a href="{{ url('/admin/users/' . $user->id) }}">{{ $user->name }}</a>
                            </td>
                            <td>
                                {{ $user->medical_due }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-0 bg-light text-center text-secondary" colspan="2">
                                <i class="pt-4 fas fa-paper-plane fa-2x text-black-50"></i><br>
                                <p class="pt-4">{{trans('global.no_deadline')}}</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
{{--<div class="col-lg-4 col-md-12 col-sm-12">--}}
{{--    <div class="card">--}}
{{--        <div class="card-header border-transparent">--}}
{{--            <h3 class="card-title">Assets</h3>--}}

{{--            <div class="card-tools">--}}
{{--                <button type="button" class="btn btn-tool" data-card-widget="collapse">--}}
{{--                    <i class="fas fa-minus"></i>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="card-body p-0">--}}
{{--            <div class="table-responsive">--}}
{{--                <table class="table m-0">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.user.fields.name') }}--}}
{{--                        </th>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.user.fields.medical_due') }}--}}
{{--                        </th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @forelse($userMedicalGoingDue as $user)--}}
{{--                        <tr>--}}
{{--                            <td>--}}
{{--                                <a href="{{ url('/admin/users/' . $user->id) }}">{{ $user->name }}</a>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                {{ $user->medical_due }}--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr>--}}
{{--                            <td class="p-0 bg-light text-center text-secondary" colspan="2">--}}
{{--                                <i class="pt-4 fas fa-paper-plane fa-2x text-black-50"></i><br>--}}
{{--                                <p class="pt-4">{{trans('global.no_deadline')}}</p>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}
{{--                    </tbody>--}}
{{--                </table>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="col-lg-4 col-md-12 col-sm-12">--}}
{{--    <div class="card">--}}
{{--        <div class="card-header border-transparent">--}}
{{--            <h3 class="card-title">Finanziaria</h3>--}}

{{--            <div class="card-tools">--}}
{{--                <button type="button" class="btn btn-tool" data-card-widget="collapse">--}}
{{--                    <i class="fas fa-minus"></i>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="card-body p-0">--}}
{{--            <div class="table-responsive">--}}
{{--                <table class="table m-0">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.user.fields.name') }}--}}
{{--                        </th>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.user.fields.medical_due') }}--}}
{{--                        </th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @forelse($userMedicalGoingDue as $user)--}}
{{--                        <tr>--}}
{{--                            <td>--}}
{{--                                <a href="{{ url('/admin/users/' . $user->id) }}">{{ $user->name }}</a>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                {{ $user->medical_due }}--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr>--}}
{{--                            <td class="p-0 bg-light text-center text-secondary" colspan="2">--}}
{{--                                <i class="pt-4 fas fa-paper-plane fa-2x text-black-50"></i><br>--}}
{{--                                <p class="pt-4">{{trans('global.no_deadline')}}</p>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}
{{--                    </tbody>--}}
{{--                </table>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

@section('scripts')
    @parent

@endsection
