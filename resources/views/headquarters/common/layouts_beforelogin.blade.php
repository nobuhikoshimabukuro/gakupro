@php
    $css_connect = "?" . date('YmdHis');
@endphp

<!doctype html>
<html lang="ja">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('css/all.css') . $css_connect}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') . $css_connect}}" rel="stylesheet">
    <link href="{{ asset('css/headquarters/common.css') . $css_connect}}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- CSRFトークン --}}
    @yield('pagehead')
    <title>@yield('title')</title>
</head>

<body>

   

@yield('content')



<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/headquarters/common.js') }}"></script>


@yield('pagejs')

</body>
{{-- @include('common.footer') --}}
</html>