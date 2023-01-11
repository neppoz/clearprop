<!DOCTYPE html>
<html>

<head>
    @production
        @include('partials.analytics')
    @endproduction
    <meta charset="UTF-8">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
          rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css" rel="stylesheet"/>
    <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"/>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>
    @yield('styles')
</head>

<body class="login-page" style="min-height: auto">
<div class="login-box">
    <!-- Content header -->
    <section class="content-header">
        <div class="container-fluid">
            @yield('content-header')
        </div>
    </section>
    <!-- Main content -->
    <section class="content" style="padding-top: 20px">
        <div class="container-fluid">
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
        </div>
    </section>
</div>

</body>
</html>
