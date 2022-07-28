<div class="card card-outline card-warning collapsed-card">
    <div class="card-header">
        <h3 class="card-title">{{trans('global.deadline_medicals')}}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
                <i class="fas fa-user-doctor"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
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
                                <p class="pt-4">{{trans('global.no_deadline_medical')}}</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@section('scripts')
    @parent

@endsection
