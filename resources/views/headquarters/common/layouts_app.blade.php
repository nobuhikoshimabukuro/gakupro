<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">  
    <link href="{{ asset('css/headquarters/common.css') }}" rel="stylesheet">      
    <link href="{{ asset('css/headquarters/footer.css') }}" rel="stylesheet">
    
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
                    <a class="nav-link dropdown-item" href="{{ route('headquarters.index') }}">管理Top</a>
                    <a class="nav-link dropdown-item" href="{{ route('master.index') }}">マスタ一覧</a>
                    <a class="nav-link dropdown-item" href="{{ route('photoproject.index') }}">写真プロジェクト</a>                    
                </div>
            </div>        
        </div>
    </nav>

@yield('content')

<!-- Footer SSTART -->
<footer id="footer">
    <div class="container">
        <div class="copyright text-center">
        &copy; Copyright <strong><span>TEST</span></strong>. All Rights Reserved
        </div>   
    </div> 
</footer>
<!-- Footer END -->

<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/headquarters/common.js') }}"></script>


@yield('pagejs')
{{-- @include('common.footer') --}}
</body>
</html>