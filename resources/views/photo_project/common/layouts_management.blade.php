@php 
    $system_version = "?system_version=" . env('system_version');
@endphp

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no viewport-fit=cover">
    <link href="{{ asset('css/all.css') . $system_version }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') . $system_version }}" rel="stylesheet">  
    <link href="{{ asset('css/photo_project/common.css') . $system_version }}" rel="stylesheet">          
    
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
                    <a class="nav-link dropdown-item" href="{{ route('photo_project.index') }}">Top</a>
                    <a class="nav-link dropdown-item" href="{{ route('photo_project.create_qrcode') }}">QRコード作成</a>                    
                    <a class="nav-link dropdown-item" href="{{ route('photo_project.password_entry', ['upload_flg' => '1']) }}">写真アップロード</a>
                    <a class="nav-link dropdown-item" href="{{ route('photo_project.password_entry') }}">写真取得画面</a>                    
                </div>
            </div>        
        </div>
        
    </nav>

@yield('content')

<script src="{{ asset('js/bootstrap.js') . $system_version }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js'). $system_version }}"></script>
<script src="{{ asset('js/app.js'). $system_version }}"></script>
<script src="{{ asset('js/photo_project/common.js'). $system_version }}"></script>



<!--▽▽jQuery▽▽-->
<script>

    $(window).on('load', function (){       
            end_loader();
        });
    

      
    </script>
    <!--△△jQuery△△-->


@yield('pagejs')
{{-- @include('common.footer') --}}
</body>
</html>