<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">  
    <link href="{{ asset('css/hp/common.css') }}" rel="stylesheet">          
    
    <link href="{{ asset('css/hp/style.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- CSRFトークン --}}
    @yield('pagehead')
    <title>@yield('title')</title>
</head>

<body>

    {{-- <nav id="header" class="navbar navbar-expand-md shadow-sm small">

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
                <!-- クリックしても閉じないようにkeep-open-on-click付与 -->                
                <div class="dropdown-menu keep-open-on-click" aria-labelledby="dropdownMenuLink">

                    <div class="dropdown-submenu">
                        <label for="target1">未実装</label>
                        <input type="checkbox" id="target1" class="switch1" />
                        <!-- ↓↓最初隠したいコンテンツ↓↓ -->
                        <div class="content">
                            <a class="nav-link dropdown-item" href="">未実装</a>
                            <a class="nav-link dropdown-item" href="">未実装</a>                          
                        </div>
                        <!-- ↑↑最初隠したいコンテンツ ↑↑-->
                    </div>                    

                </div>

            </div>            
            
      

        </div>
    </nav> --}}

@yield('content')



<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/hp/common.js') }}"></script>

<script src="{{ asset('js/hp/main.js') }}"></script>
<script src="{{ asset('js/hp/slick.js') }}"></script>


@yield('pagejs')

</body>

</html>