@php 
    $system_version = "?system_version=" . env('system_version');
@endphp

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    
    <link href="{{ asset('css/all.css') . $system_version}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') . $system_version }}" rel="stylesheet">  
    <link href="{{ asset('css/recruit_project/common.css') . $system_version }}" rel="stylesheet">          
    
    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- CSRFトークン --}}
    @yield('pagehead')
    <title>@yield('title')</title>
</head>

<div class="loader-area">
    <div class="loader">
    </div>
</div>


<body>



@yield('content')


<script src="{{ asset('js/bootstrap.js') . $system_version }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js'). $system_version }}"></script>
<script src="{{ asset('js/app.js'). $system_version }}"></script>
<script src="{{ asset('js/recruit_project/common.js'). $system_version }}"></script>



<!--▽▽jQuery▽▽-->
<script>

    $(window).on('load', function (){       
        end_loader();
    });

  
  
</script>
<!--△△jQuery△△-->

@yield('pagejs')


</body>

</html>