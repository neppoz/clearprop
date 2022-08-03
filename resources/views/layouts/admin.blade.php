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
    <link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" rel="stylesheet"/>
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
        <ul class="navbar-nav ml-auto">
            @can('user_alert_access')
                <li class="nav-item dropdown notifications-menu">
                    <a href="#" class="nav-link" data-toggle="dropdown">
                        <i class="far fa-bell"></i>
                        @php($unreadNotifications = (new \App\Services\NotificationService())->getUnreadNotificationsForLoggedInUser())
                        @if(($unreadNotifications->count() > 0))
                            <span class="badge badge-danger navbar-badge" id="alertsCount">
                                {{ $unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                        <span
                            class="dropdown-item dropdown-header bg-gray-light">{{ trans('global.notifications')}}</span>
                        <div class="dropdown-divider"></div>

                        @forelse($unreadNotifications as $notification)
                            <div class="dropdown-item">
                                <a class="text-wrap" href="#" target="_self">
                                    @switch($notification->type)
                                        @case('App\Notifications\UserDataMedicalEmailNotification')
                                        <i class="fas fa-comment-medical fa-lg"></i>
                                        <span
                                            class="ml-2">{{ $notification->data['name'] . trans('global.notification_medical') . \Carbon\Carbon::createFromFormat('Y-m-d', $notification->data['medical_due'])->format(config('panel.date_format'))}}</span>
                                        <br>
                                        @break
                                        @case('App\Notifications\UserDataBalanceEmailNotification')
                                        <i class="fas fa-comment-dots fa-lg"></i>
                                        <span
                                            class="ml-2">{{ $notification->data['name'] . trans('global.notification_balance') . $notification->data['balance']}}</span>
                                        <br>
                                        @break
                                        @default
                                    @endswitch

                                    <span
                                        class="text-muted text-sm">{{\Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</span>
                                    <input class="float-right mark-as-read" type="radio"
                                           data-id="{{ $notification->id }}"/>
                                </a>
                            </div>
                            <div class="dropdown-divider"></div>
                        @empty
                            <div class="bg-light">
                                <div class="pt-4 text-center"><i
                                        class="fas fa-paper-plane fa-2x text-black-50"></i>
                                </div>

                                <div class="p-4 text-center text-secondary">
                                    {{trans('global.you_have_no_messages')}}
                                </div>
                            </div>
                        @endforelse
                        <span class="dropdown-item dropdown-footer bg-gray-light"></span>
                    </div>
                </li>
            @endcan
        <!-- Notification bell -->
            @if(count(config('panel.available_languages', [])) > 1)

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

        @endif
        <!-- Lang switcher -->
        </ul>
    </nav>

    @include('partials.menu')
    <div class="content-wrapper" style="min-height: 917px;">
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
<script src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>
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
        let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
        //   let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
        let printButtonTrans = '{{ trans('global.datatables.print') }}'
        let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
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
                {
                    extend: 'excel',
                    className: 'btn-default',
                    text: excelButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                }
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
<script>
    function sendMarkRequest(id = null) {
        return $.ajax("{{ route('admin.user-alerts.markNotification') }}", {
            method: 'POST',
            data: {
                _token,
                id
            }
        });
    }

    function getAlertCount() {
        let alertsCount = $('#alertsCount');
        $.ajax({
            url: "{{ route('admin.user-alerts.getAlertCount') }}",
            method: 'GET',
            success: function (data) {
                if (data >= 1) {
                    alertsCount.text(data);
                } else {
                    alertsCount.hide();
                }
            }
        });
    }

    $(function () {
        $('.mark-as-read').click(function () {
            let request = sendMarkRequest($(this).data('id'));
            request.done(() => {
                $(this).parents('div.dropdown-item').remove();
                getAlertCount();
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

@include('sweetalert::alert')
@yield('scripts')
</body>

</html>
