@php
    $update_now = "?" . date('YmdHis');
@endphp

<!doctype html>
<html lang="ja">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('css/all.css') . $update_now}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') . $update_now}}" rel="stylesheet">
    <link href="{{ asset('css/headquarters/common.css') . $update_now}}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- CSRFトークン --}}
    @yield('pagehead')
    <title>@yield('title')</title>
</head>

<body>

    <nav id="header" class="navbar navbar-expand-md shadow-sm small">

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
                        <label for="target1">管理▼</label>
                        <input type="checkbox" id="target1" class="switch1" />
                        <!-- ↓↓最初隠したいコンテンツ↓↓ -->
                        <div class="content">
                            <a class="nav-link dropdown-item" href="{{ route('headquarters.index') }}">管理Top</a>
                            <a class="nav-link dropdown-item" href="{{ route('master.index') }}">マスタ一覧</a>
                        </div>
                        <!-- ↑↑最初隠したいコンテンツ ↑↑-->
                    </div>

                    <div class="dropdown-submenu">
                        <label for="target2">PhotoPro▼</label>
                        <input type="checkbox" id="target2" class="switch2" />
                        <!-- ↓↓最初隠したいコンテンツ↓↓ -->
                        <div class="content">
                            <a class="nav-link dropdown-item" href="{{ route('photoproject.index') }}">フォトプロTop</a>
                            <a class="nav-link dropdown-item" href="{{ route('photoproject.create_qrcode') }}">QRコード管理画面</a>
                        </div>
                        <!-- ↑↑最初隠したいコンテンツ ↑↑-->
                    </div>

                    <div class="dropdown-submenu">
                        <label for="target3">RecruitPro▼</label>
                        <input type="checkbox" id="target3" class="switch2" />
                        <!-- ↓↓最初隠したいコンテンツ↓↓ -->
                        <div class="content">
                            <a class="nav-link dropdown-item" href="{{ route('recruitproject.index') }}">リクプロTop</a>
                            <a class="nav-link dropdown-item" href="{{ route('recruitproject.login') }}">雇用者ログイン画面</a>
                            <a class="nav-link dropdown-item" href="{{ route('recruitproject.mailaddress_temporary_registration') }}">新規登録画面</a>
                        </div>
                        <!-- ↑↑最初隠したいコンテンツ ↑↑-->
                    </div>

                </div>

            </div>

            <div class="">
                <h3>
                    {{session()->get('staff_name')}}
                </h3>
            </div>

            <div class="">
                <a class="nav-link dropdown-item" href="{{ route('headquarters.logout') }}">ログアウト</a>
            </div>

        </div>
    </nav>

@yield('content')


<link href="{{ asset('css/headquarters/common.css') . $update_now}}" rel="stylesheet">

<script src="{{ asset('js/bootstrap.js') . $update_now }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js'). $update_now }}"></script>
<script src="{{ asset('js/app.js'). $update_now }}"></script>
<script src="{{ asset('js/headquarters/common.js'). $update_now }}"></script>


@yield('pagejs')

</body>
{{-- @include('common.footer') --}}
</html>