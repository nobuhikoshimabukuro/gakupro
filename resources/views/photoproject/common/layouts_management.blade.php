@php 
    $css_connect = "?" . date('YmdHis');
@endphp

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('css/all.css') . $css_connect }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') . $css_connect }}" rel="stylesheet">  
    <link href="{{ asset('css/photoproject/common.css') . $css_connect }}" rel="stylesheet">          
    
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
                    <a class="nav-link dropdown-item" href="{{ route('photoproject.index') }}">Top</a>
                    <a class="nav-link dropdown-item" href="{{ route('photoproject.create_qrcode') }}">QRコード作成</a>                    
                    <a class="nav-link dropdown-item" href="{{ route('photoproject.password_entry', ['upload_flg' => '1']) }}">写真アップロード</a>
                    <a class="nav-link dropdown-item" href="{{ route('photoproject.password_entry') }}">写真取得画面</a>                    
                </div>
            </div>        
        </div>
        
    </nav>

@yield('content')



<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/photoproject/common.js') }}"></script>


@yield('pagejs')
@include('common.footer')
</body>
</html>