<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{trans('install.installation')}} | LCRM</title>
    @include('layouts._assets')
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('css/custom_install.css') }}">
</head>

<body>
<div id="page-wrapper">
    <div class="container">
        <div class="row top_logo">
            <div class="col-md-6 col-md-offset-3 logo-wrapper">
                <img src="{{ url('img/logo.png') }}" alt="LCRM" class="logo center-block">
            </div>
        </div>
        <div class="row">
        <div class="wizard wizard_section">
            @yield('content')
        </div>
            </div>
    </div>
</div>
<script src="{{ asset('js/libs.js') }}" type="text/javascript"></script>

@yield('scripts')
</body>
</html>
