@php 
    $system_version = "?system_version=" . env('system_version');
@endphp

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no viewport-fit=cover">

    <link href="{{ asset('css/all.css') . $system_version}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') . $system_version}}" rel="stylesheet">
    <link href="{{ asset('css/hp/common.css') . $system_version}}" rel="stylesheet">    
    <link href="{{ asset('css/hp/style.css') . $system_version}}" rel="stylesheet">    

    <link rel="shortcut icon" href="{{ asset('img/logo/ssp_logo.ico')}}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('img/logo/ssp_logo.png')}}" sizes="180x180">
    <link rel="icon" type="image/png" href="{{ asset('img/logo/ssp_logo.png')}}" sizes="192x192">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- CSRFトークン --}}
    @yield('pagehead')
    <title>@yield('title')</title>
</head>



<style>




</style>


<div class="loader-area">
    <div class="loader">
    </div>
</div>


<body>


    {{-- PC --}}
    <div class="d-none d-md-block w-100">

        <!--ヘッダー-->
        <header class="m-0 p-0">

            
            <!--▽▽ヘッダーロゴ▽▽-->
                <div class="">
                    <a class="" href="{{ route('hp.index') }}">
                        <img id="" src="{{ asset('img/hp/ssp_logo.png') }}" class="gakupro_logo" alt="gakupro_logo">
                    </a>
                </div>
            
            <!--△△ヘッダーロゴ△△-->


            
                <h3 class="m-0 p-0" style="line-height: 60px;">
                    学生応援プロジェクト
                </h3>              
    


            <!--▽▽ヘッダーリスト▽▽-->
            
                <nav class="pc">  <!--pcクラスを追記-->
                    <ul>
                        <li>
                            <a href="{{ route('headquarters.login') }}">
                                管理者
                            </a>
                        </li>

                        <li>
                            <a class="" href="{{ route('hp.job_information') }}">
                                求人情報
                            </a>
                        </li>

                        <li>
                            <a class="" href="{{ route('hp.message_to_employers') }}">
                                雇用者様へ
                            </a>
                        </li>
    
                        <li>
                            <a class="" href="{{ route('hp.image_resize') }}">
                                画像リサイズ
                            </a>
                        </li>
    
                          


                    </ul>
                </nav>
            
            <!--△△ヘッダーリスト△△-->
            
        </header>

    </div>


    {{-- スマホ --}}
    <div class="d-block d-md-none w-100">

        <header class="p-0 m-0">

             <!--▽▽ヘッダーロゴ▽▽-->
             <div class="">
                <a class="p-0 m-0" href="{{ route('hp.index') }}">                    
                    <img id="" src="{{ asset('img/hp/ssp_logo.png') }}" class="gakupro_logo" alt="gakupro_logo">
                </a>
            </div>
            <!--△△ヘッダーロゴ△△-->
    
         
            
            <!--▽▽ハンバーガーメニュー▽▽-->
            <div id="hamburger">                       
                <div class="icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <!--△△ハンバーガーメニュー△△-->
    
    
            <!--▽▽ハンバーガーメニューのリスト▽▽-->
            <nav class="sm">
                <ul>
                    <li>
                        <a href="{{ route('headquarters.login') }}">
                            <img id="" src="{{ asset('img/hp/ssp_logo.png') }}" class="navi_logo" alt="">
                            管理者
                        </a>
                    </li>                    

                    <li>
                        <a class="" href="{{ route('hp.job_information') }}">
                            求人情報
                        </a>
                    </li>
                    
                    <li>
                        <a class="" href="{{ route('hp.message_to_employers') }}">
                            雇用者様へ
                        </a>
                    </li>

                    <li>
                        <a class="" href="{{ route('hp.image_resize') }}">
                            画像リサイズ
                        </a>
                    </li>
                 


                </ul>
            </nav>
            <!--△△ハンバーガーメニューのリスト△△-->

        </header>
        
    </div>

        
    

    <div id="empty_space" class="row p-0 m-0">

      
        
    </div>


    
    <div class="warning-statement">
        web開発中
    </div>  



    <!-- ページトップへ戻るボタン -->
    {{-- <div id="page_top"><a href="#"></a></div> --}}
    <a class="pagetop" href="#" style="display: flex;"><div class="pagetop__arrow"></div></a>
    {{-- </div> --}}

@yield('content')


<script src="{{ asset('js/bootstrap.js') . $system_version }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js'). $system_version }}"></script>
<script src="{{ asset('js/app.js'). $system_version }}"></script>
<script src="{{ asset('js/hp/common.js'). $system_version }}"></script>
<script src="{{ asset('js/hp/main.js'). $system_version }}"></script>





<!--▽▽jQuery▽▽-->
<script>

$(window).on('load', function (){       
        end_loader();
    });

    $('#hamburger').on('click', function(){
        $('.icon').toggleClass('close');
        $('.sm').slideToggle();
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