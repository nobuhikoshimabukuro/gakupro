@extends('recruitproject.common.layouts_beforelogin')

@section('pagehead')
@section('title', 'メニュー')  
@endsection
@section('content')

<style>
   
    
    
    
</style>

<div class="mt-3 text-center container">
    <div class="row">
 
        <div class="col-6 col-md-4 col-xl-3 p-3 menu_btn">
            <a href="{{ route('recruitproject.login') }}">
                <div class="bg-dark rounded-lg text-light p-2 menu-btn">
                    <i class="fas fa-praying-hands fa-3x mb-1"></i>
                    <h6>ログイン画面
                    </h6>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-3 p-3 menu_btn">
            <a href="{{ route('recruitproject.mailaddress_temporary_registration') }}">
                <div class="bg-dark rounded-lg text-light p-2 menu-btn">
                    <i class="fas fa-praying-hands fa-3x mb-1"></i>
                    <h6>雇用者メールチェック画面テスト
                    </h6>
                </div>
            </a>
        </div>

     
        
        </div>
    </div>
</div>
@endsection

@section('pagejs')
<script src="{{ asset('js/common.js') }}"></script>
<script type="text/javascript">

$(function(){



    

    





});

</script>
@endsection

