@php
    $system_version = "?system_version=" . env('system_version');
@endphp

<!doctype html>
<html lang="ja">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no viewport-fit=cover">
    <link href="{{ asset('css/all.css') . $system_version}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') . $system_version}}" rel="stylesheet">
    <link href="{{ asset('css/headquarters/common.css') . $system_version}}" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('img/logo/ssp_logo.ico')}}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('img/logo/ssp_logo.png')}}" sizes="180x180">
    <link rel="icon" type="image/png" href="{{ asset('img/logo/ssp_logo.png')}}" sizes="192x192">

    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- CSRFトークン --}}
    @yield('pagehead')
    <title>@yield('title')</title>
</head>

<body>

   

@yield('content')


<script src="{{ asset('js/bootstrap.js') . $system_version }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js'). $system_version }}"></script>
<script src="{{ asset('js/app.js'). $system_version }}"></script>
<script src="{{ asset('js/headquarters/common.js'). $system_version }}"></script>


@yield('pagejs')

</body>
{{-- @include('common.footer') --}}
</html>