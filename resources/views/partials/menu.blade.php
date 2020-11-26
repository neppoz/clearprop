<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route("admin.home") }}" class="nav-link">
                        <p>
                            <i class="fas fa-fw nav-icon fa-tachometer-alt">

                            </i>
                            <span>{{ trans('global.dashboard') }}</span>
                        </p>
                    </a>
                </li>
                @can('booking_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.bookings.index") }}"
                           class="nav-link {{ request()->is("admin/bookings") || request()->is("admin/bookings/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-calendar-alt"></i>
                            <p>
                                {{ trans('cruds.planning.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('activity_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.activities.index") }}"
                           class="nav-link {{ request()->is('admin/activities') || request()->is('admin/activities/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon fas fa-plane-departure">

                            </i>
                            <p>
                                <span>{{ trans('cruds.activity.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('user_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}"
                           class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon fas fa-user">

                            </i>
                        <p>
                            <span>{{ trans('cruds.user.title') }}</span>
                        </p>
                    </a>
                </li>
                @endcan
                @can('plane_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.planes.index") }}" class="nav-link {{ request()->is('admin/planes') || request()->is('admin/planes/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon fas fa-plane">

                            </i>
                            <p>
                                <span>{{ trans('cruds.plane.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('activity_management_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/types*') ? 'menu-open' : '' }} {{ request()->is('admin/factors*') ? 'menu-open' : '' }} {{ request()->is('admin/activity-reports*') ? 'menu-open' : '' }} {{ request()->is('admin/slots*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-plane-departure">

                            </i>
                            <p>
                                <span>{{ trans('cruds.activityManagement.title') }}</span>
                                <i class="right fa fa-fw nav-icon fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('activity_report_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.activity-reports.index") }}" class="nav-link {{ request()->is('admin/activity-reports') || request()->is('admin/activity-reports/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-chart-area">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.activityReport.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.types.index") }}" class="nav-link {{ request()->is('admin/types') || request()->is('admin/types/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
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
                                        <i class="fa-fw nav-icon fas fa-user-check">

                                        </i>
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
                                        <i class="fa-fw nav-icon fas fa-braille">

                                        </i>
                                        <p>
                                            {{ trans('cruds.slot.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('expense_management_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/expense-categories*') ? 'menu-open' : '' }} {{ request()->is('admin/income-categories*') ? 'menu-open' : '' }} {{ request()->is('admin/expenses*') ? 'menu-open' : '' }} {{ request()->is('admin/incomes*') ? 'menu-open' : '' }} {{ request()->is('admin/expense-reports*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-money-bill-alt">

                            </i>
                            <p>
                                <span>{{ trans('cruds.expenseManagement.title') }}</span>
                                <i class="right fa fa-fw nav-icon fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('expense_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.expense-categories.index") }}" class="nav-link {{ request()->is('admin/expense-categories') || request()->is('admin/expense-categories/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-list">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.expenseCategory.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('income_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.income-categories.index") }}" class="nav-link {{ request()->is('admin/income-categories') || request()->is('admin/income-categories/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-list">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.incomeCategory.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('expense_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.expenses.index") }}" class="nav-link {{ request()->is('admin/expenses') || request()->is('admin/expenses/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-arrow-circle-right">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.expense.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('income_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.incomes.index") }}" class="nav-link {{ request()->is('admin/incomes') || request()->is('admin/incomes/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-arrow-circle-right">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.income.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('expense_report_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.expense-reports.index") }}" class="nav-link {{ request()->is('admin/expense-reports') || request()->is('admin/expense-reports/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-chart-line">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.expenseReport.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                                @endcan
                        </ul>
                    </li>
                @endcan
                @can('asset_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/assets*") ? "menu-open" : "" }} {{ request()->is("admin/asset-categories*") ? "menu-open" : "" }} {{ request()->is("admin/asset-statuses*") ? "menu-open" : "" }} {{ request()->is("admin/assets-histories*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-book">

                            </i>
                            <p>
                                {{ trans('cruds.assetManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('asset_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.assets.index") }}"
                                       class="nav-link {{ request()->is("admin/assets") || request()->is("admin/assets/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-book">

                                        </i>
                                        <p>
                                            {{ trans('cruds.asset.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('asset_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.asset-categories.index") }}"
                                       class="nav-link {{ request()->is("admin/asset-categories") || request()->is("admin/asset-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-tags">

                                        </i>
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
                                        <i class="fa-fw nav-icon fas fa-server">

                                        </i>
                                        <p>
                                            {{ trans('cruds.assetStatus.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            {{--                            @can('assets_history_access')--}}
                            {{--                                <li class="nav-item">--}}
                            {{--                                    <a href="{{ route("admin.assets-histories.index") }}" class="nav-link {{ request()->is("admin/assets-histories") || request()->is("admin/assets-histories/*") ? "active" : "" }}">--}}
                            {{--                                        <i class="fa-fw nav-icon fas fa-th-list">--}}

                            {{--                                        </i>--}}
                            {{--                                        <p>--}}
                            {{--                                            {{ trans('cruds.assetsHistory.title') }}--}}
                            {{--                                        </p>--}}
                            {{--                                    </a>--}}
                            {{--                                </li>--}}
                            {{--                            @endcan--}}
                        </ul>
                    </li>
                @endcan
                @can('setting_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/parameters*') ? 'menu-open' : '' }} {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/user-alerts*') ? 'menu-open' : '' }} {{ request()->is('admin/asset-locations*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-cog">

                            </i>
                            <p>
                                <span>{{ trans('cruds.setting.title') }}</span>
                                <i class="right fa fa-fw nav-icon fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('asset_location_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.asset-locations.index") }}"
                                       class="nav-link {{ request()->is("admin/asset-locations") || request()->is("admin/asset-locations/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-map-marker">

                                        </i>
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
                                        <i class="fa-fw nav-icon fas fa-sliders-h">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.parameter.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.permission.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
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
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
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
