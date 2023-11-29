@php 
    $update_now = "?" . date('YmdHis');
@endphp

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no viewport-fit=cover">    
    <link href="{{ asset('css/all.css') . $update_now}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') . $update_now }}" rel="stylesheet">  
    <link href="{{ asset('css/recruit_project/common.css') . $update_now }}" rel="stylesheet">          
    
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


<script src="{{ asset('js/bootstrap.js') . $update_now }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js'). $update_now }}"></script>
<script src="{{ asset('js/app.js'). $update_now }}"></script>
<script src="{{ asset('js/recruit_project/common.js'). $update_now }}"></script>



<!--▽▽jQuery▽▽-->
<script>

    $(window).on('load', function (){       
        end_loader();
    });

  
    $(window).on('scroll', function() {//スクロールしたとき、
        if ($(this).scrollTop() > 100) { //スクロール量が500px以上なら、
            $('.pagetop').addClass('active');    //activeクラスを付与し、
        } else {                         //500px未満なら、
            $('.pagetop').removeClass('active'); //activeクラスを外します。
        }
    });
  
</script>
<!--△△jQuery△△-->

@yield('pagejs')


</body>

</html>