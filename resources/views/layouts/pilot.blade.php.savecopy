<!DOCTYPE html>
<html>

<head>
    @production
        @include('partials.analytics')
    @endproduction
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet"/>
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
          rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css" rel="stylesheet"/>
    <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.bootstrap4.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet"/>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>
    @yield('styles')
</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed" style="height: auto;">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        @if(count(config('panel.available_languages', [])) > 1)
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach(config('panel.available_languages') as $langLocale => $langName)
                            <a class="dropdown-item"
                               href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }}
                                ({{ $langName }})</a>
                        @endforeach
                    </div>
                </li>
            </ul>
        @endif

    </nav>

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
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route("pilot.welcome") }}" class="nav-link">
                            <p>
                                <i class="fas fa-fw nav-icon fa-tachometer-alt">

                                </i>
                                <span>{{ trans('global.dashboard') }}</span>
                            </p>
                        </a>
                    </li>
                    @can('activity_access')
                        <li class="nav-item">
                            <a href="{{ route("pilot.activities.index") }}"
                               class="nav-link {{ request()->is('/activities') || request()->is('/activities/*') ? 'active' : '' }}">
                                <i class="fa-fw nav-icon fas fa-plane-departure">

                                </i>
                                <p>
                                    <span>{{ trans('cruds.activity.title') }}</span>
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}"
                               href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_profile_data') }}
                                </p>
                            </a>
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

    <div class="content-wrapper" style="min-height: 917px; background-color: #eeeeee">
        <div class="container-fluid">
            <!-- Main content -->
            <section class="content" style="padding-top: 20px">
                @if(session('message'))
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                @endif
                @if($errors->count() > 0)
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
    </div>

    <footer class="main-footer">
        @include('partials.footer')
    </footer>
    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script>
    $(function () {
        //let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
        //let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
        {{--let excelButtonTrans = '{{ trans('global.datatables.excel') }}'--}}
        //   let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
        {{--        let printButtonTrans = '{{ trans('global.datatables.print') }}'--}}
        {{--        let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'--}}
        //   let selectAllButtonTrans = '{{ trans('global.select_all') }}'
//   let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

        let languages = {
            'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json',
            'de': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/German.json',
            'it': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Italian.json'
        };

        $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {className: 'btn btn-sm'})
        $.extend(true, $.fn.dataTable.moment = function (format, locale) {
            var types = $.fn.dataTable.ext.type;

            // Add type detection
            types.detect.unshift(function (d) {
                return moment(d, format, locale, true).isValid() ?
                    'moment-' + format :
                    null;
            });

            // Add sorting method - use an integer for the sorting
            types.order['moment-' + format + '-pre'] = function (d) {
                return moment(d, format, locale, true).unix();
            };
        });

        $.extend(true, $.fn.dataTable.defaults, {
            //stateSave: true,
            responsive: true,

            language: {
                url: languages['{{ app()->getLocale() }}']
            },
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }, {
                orderable: false,
                searchable: false,
                targets: -1
            }],
            select: {
                style: 'multi+shift',
                selector: 'td:first-child'
            },
            order: [],
            scrollX: true,
            pageLength: 25,
            dom: 'lBfrtip<"actions">',
            buttons: [
                //   {
                //     extend: 'selectAll',
                //     className: 'btn-primary',
                //     text: selectAllButtonTrans,
                //     exportOptions: {
                //       columns: ':visible'
                //     }
                //   },
                //   {
                //     extend: 'selectNone',
                //     className: 'btn-primary',
                //     text: selectNoneButtonTrans,
                //     exportOptions: {
                //       columns: ':visible'
                //     }
                //   },
                //   {
                //     extend: 'copy',
                //     className: 'btn-default',
                //     text: copyButtonTrans,
                //     exportOptions: {
                //       columns: ':visible'
                //     }
                //   },
                //   {
                //     extend: 'csv',
                //     className: 'btn-default',
                //     text: csvButtonTrans,
                //     exportOptions: {
                //       columns: ':visible'
                //     }
                //   },
                // {
                //     extend: 'excel',
                //     className: 'btn-default',
                //     text: excelButtonTrans,
                //     exportOptions: {
                //         columns: ':visible'
                //     }
                // }
                //   {
                //     extend: 'pdf',
                //     className: 'btn-default',
                //     text: pdfButtonTrans,
                //     exportOptions: {
                //       columns: ':visible'
                //     }
                //   },
                //   {
                //     extend: 'print',
                //     className: 'btn-default',
                //     text: printButtonTrans,
                //     exportOptions: {
                //       columns: ':visible'
                //     }
                //   },
                // {
                //     extend: 'colvis',
                //     className: 'btn-default',
                //     text: colvisButtonTrans,
                //     exportOptions: {
                //       columns: ':visible'
                //     }
                //   }
            ]
        });

        $.fn.dataTable.ext.classes.sPageButton = '';

    });

</script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
@include('sweetalert::alert')
@yield('scripts')
</body>

</html>
