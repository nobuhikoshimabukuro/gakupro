@php 
    $update_now = "?" . date('YmdHis');
@endphp

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('css/all.css') . $update_now}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') . $update_now }}" rel="stylesheet">  
    <link href="{{ asset('css/recruit_project/common.css') . $update_now }}" rel="stylesheet">          
    
    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- CSRFトークン --}}
    @yield('pagehead')
    <title>@yield('title')</title>
</head>

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
                    <a class="nav-link dropdown-item" href="{{ route('member.top') }}">Top</a>           
                    
                    
                </div>

            </div>    
            
            
            <div class="">
                <h3>
                    {{session()->get('member_name')}} 様
                </h3>
                
            </div>

            <div class="">
                <a class="nav-link dropdown-item" href="{{ route('member.logout') }}">ログアウト</a>                       
            </div>

        </div>
    </nav>

@yield('content')

<script src="{{ asset('js/bootstrap.js') . $update_now }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js'). $update_now }}"></script>
<script src="{{ asset('js/app.js'). $update_now }}"></script>
<script src="{{ asset('js/recruit_project/common.js'). $update_now }}"></script>


@yield('pagejs')
</body>
{{-- @include('common.footer') --}}
</html>