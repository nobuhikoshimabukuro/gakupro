@php 
    $system_version = "?system_version=" . env('system_version');
@endphp

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no viewport-fit=cover">
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

    <nav class="navbar navbar-expand-md shadow-sm small">

        <div class="container" style="background-color: transparent">
            <div class="dropdown">
                <!-- 切替ボタンの設定 -->
                <a class="btn dropdown-toggle d-none d-md-block"role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    メニュー
                </a>
                <a class="btn d-block d-sm-block d-md-none" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    メニュー
                </a>
                
                <!-- ドロップメニューの設定 -->
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="nav-link dropdown-item" href="{{ route('recruit_project.top') }}">Top</a>           
                    <a class="nav-link dropdown-item" href="{{ route('recruit_project.information_confirmation') }}">雇用者情報</a>
                    <a class="nav-link dropdown-item" href="{{ route('recruit_project.job_information_confirmation') }}">求人情報</a>       
                    
                </div>

            </div>    
            
            
            <div class="">
                <h3>
                    {{session()->get('employer_name')}} 様
                </h3>
                
            </div>

            <div class="">
                <a class="nav-link dropdown-item" href="{{ route('recruit_project.logout') }}">ログアウト</a>                       
            </div>

        </div>
    </nav>

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
{{-- @include('common.footer') --}}
</html>