<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="{{route('app.home')}}" class="brand-link">
        {{--        <img src="{{ url('/images/ClearProp_textdown.svg') }}" alt="ClearProp Logo" class="brand-image img-circle elevation-3" style="opacity: .8">--}}
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                {{--<img src="" class="img-circle elevation-2" alt="User Image">--}}
            </div>
            <div class="info">
                <a href="{{route('profile.password.edit')}}" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route("app.home") }}" class="nav-link">
                        <p>
                            <i class="fas fa-fw nav-icon fa-tachometer-alt">

                            </i>
                            <span>{{ trans('global.dashboard') }}</span>
                        </p>
                    </a>
                </li>
                @can('activity_access')
                    <li class="nav-item">
                        <a href="{{ route("app.activities.index")  }}"
                           class="nav-link {{ request()->is('app/activities') || request()->is('app/activities/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon fas fa-plane-departure">

                            </i>
                            <p>
                                <span>{{ trans('cruds.activity.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('activity_report_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.activity-reports.index") }}"
                           class="nav-link {{ request()->is('admin/activity-reports') || request()->is('admin/activity-reports/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon fas fa-chart-area">

                            </i>
                            <p>
                                <span>{{ trans('cruds.activityReport.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('user_access')
                    <li class="nav-item">
                        <a href="{{route("admin.users.index")}}"
                           class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon fas fa-user">

                            </i>
                            <p>
                                <span>{{ trans('cruds.user.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('expense_management_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/expense-categories*') ? 'menu-open' : '' }} {{ request()->is('admin/income-categories*') ? 'menu-open' : '' }} {{ request()->is('admin/expenses*') ? 'menu-open' : '' }} {{ request()->is('admin/incomes*') ? 'menu-open' : '' }} {{ request()->is('admin/expense-reports*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-money-check"></i>
                            <p>
                                <span>{{ trans('cruds.expenseManagement.title') }}</span>
                                <i class="right fa fa-fw nav-icon fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-2">
                            @can('expense_report_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.expense-reports.index") }}"
                                       class="nav-link {{ request()->is('admin/expense-reports') || request()->is('admin/expense-reports/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-chart-line">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.expenseReport.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('expense_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.expenses.index") }}"
                                       class="nav-link {{ request()->is('admin/expenses') || request()->is('admin/expenses/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            <span>{{ trans('cruds.expense.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('income_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.incomes.index") }}"
                                       class="nav-link {{ request()->is('admin/incomes') || request()->is('admin/incomes/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            <span>{{ trans('cruds.income.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('expense_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.expense-categories.index") }}"
                                       class="nav-link {{ request()->is('admin/expense-categories') || request()->is('admin/expense-categories/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            <span>{{ trans('cruds.expenseCategory.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('income_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.income-categories.index") }}"
                                       class="nav-link {{ request()->is('admin/income-categories') || request()->is('admin/income-categories/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            <span>{{ trans('cruds.incomeCategory.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('asset_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/assets") ? "menu-open" : "" }} {{ request()->is("admin/planes") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-book"></i>
                            <p>
                                <span>{{ trans('cruds.assetManagement.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-2">
                            @can('asset_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.assets.index") }}"
                                       class="nav-link {{ request()->is("admin/assets") || request()->is("admin/assets/") ? "active" : "" }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            {{ trans('cruds.asset.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('plane_access')
                                <li class="nav-item">
                                    <a href="{{  Request::route()->getPrefix() . "/planes" }}"
                                       class="nav-link {{ request()->is('admin/planes') || request()->is('admin/planes/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            <span>{{ trans('cruds.plane.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('setting_access')
                    <li class="nav-item has-treeview
                        {{ request()->is('admin/parameters*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/permissions*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/roles*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/user-alerts*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/types*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/factors*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/slots*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/asset-categories*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/asset-statuses*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/asset-locations*') ? 'menu-open' : '' }}
                            ">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-cog">

                            </i>
                            <p>
                                <span>{{ trans('cruds.setting.title') }}</span>
                                <i class="right fa fa-fw nav-icon fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-2">
                            @can('type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.types.index") }}"
                                       class="nav-link {{ request()->is('admin/types') || request()->is('admin/types/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            <span>{{ trans('cruds.type.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('factor_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.factors.index") }}"
                                       class="nav-link {{ request()->is('admin/factors') || request()->is('admin/factors/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            <span>{{ trans('cruds.factor.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('slot_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.slots.index") }}"
                                       class="nav-link {{ request()->is("admin/slots") || request()->is("admin/slots/*") ? "active" : "" }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            {{ trans('cruds.slot.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('asset_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.asset-categories.index") }}"
                                       class="nav-link {{ request()->is("admin/asset-categories") || request()->is("admin/asset-categories/*") ? "active" : "" }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            {{ trans('cruds.assetCategory.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('asset_status_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.asset-statuses.index") }}"
                                       class="nav-link {{ request()->is("admin/asset-statuses") || request()->is("admin/asset-statuses/*") ? "active" : "" }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            {{ trans('cruds.assetStatus.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('asset_location_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.asset-locations.index") }}"
                                       class="nav-link {{ request()->is("admin/asset-locations") || request()->is("admin/asset-locations/*") ? "active" : "" }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            {{ trans('cruds.assetLocation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('parameter_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.parameters.index") }}"
                                       class="nav-link {{ request()->is('admin/parameters') || request()->is('admin/parameters/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            <span>{{ trans('cruds.parameter.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}"
                                       class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            <span>{{ trans('cruds.role.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="#" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw nav-icon fa-sign-out-alt">

                            </i>
                            <span>{{ trans('global.logout') }}</span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
