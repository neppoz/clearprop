<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown notifications-menu">
        <a href="#" class="nav-link" data-toggle="dropdown">
            <i class="far fa-bell"></i>
            @php($alertsCount = \Auth::user()->userUserAlerts()->where('read', false)->count())
            @if($alertsCount > 0)
                <span class="badge badge-danger navbar-badge" id="alertsCount">
                                    {{ $alertsCount }}
                                </span>
            @endif
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
            @if(count($alerts = \Auth::user()->userUserAlerts()->withPivot('read')->wherePivot('read', 0)->limit(10)->orderBy('created_at', 'ASC')->get()->reverse()) > 0)
                <span
                    class="dropdown-item dropdown-header bg-gray-light">{{count($alerts) > 1 ? trans('global.messages') : trans('global.message')}}</span>
                <div class="dropdown-divider"></div>
                @foreach($alerts as $alert)
                    <div id="dropdown_{{ $alert->pivot->user_alert_id }}" class="dropdown-item">
                        <a class="text-wrap text-{{ $alert->pivot->read ? 'secondary' : 'primary' }}"
                           href="{{ $alert->alert_link ? $alert->alert_link : "#" }}" target="_self">
                            <i class="fas fa-envelope mr-2"></i>
                            {{ $alert->alert_text }}<br>
                            <span class="text-muted text-sm">Da implementare 2 giorni fa</span>
                            <input class="float-right" name="updateRead"
                                   id="updateRead_{{ $alert->pivot->user_alert_id }}"
                                   type="{{ $alert->pivot->read ? 'hidden' : 'radio' }}"
                                   value="{{ $alert->pivot->user_alert_id }}"/>
                        </a>
                    </div>
                    <div class="dropdown-divider"></div>
                @endforeach

                <a href="{{route('admin.user-alerts.index')}}"
                   class="dropdown-item dropdown-footer bg-light">{{trans('global.all_notifications')}}</a>
            @else
                <div class="bg-light">
                    <div class="pt-4 text-center"><i
                            class="fas fa-envelope-open mr-2 text-black-50"></i>
                    </div>
                    <a href="{{route('admin.user-alerts.index')}}"
                       class="dropdown-item dropdown-footer bg-light">{{trans('global.all_notifications')}}</a>
                </div>

            @endif
        </div>
    </li>
</ul>


