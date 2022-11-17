@extends('photoproject.common.layouts_management')

@section('pagehead')
@section('title', 'メニュー')  
@endsection
@section('content')

<style>
   
    
    
    
</style>

<div class="mt-3 text-center container">
    <div class="row">
              
       
        <div class="col-6 col-md-4 col-xl-3 p-3 menu_btn">
            <a href="{{ route('photoproject.create_qrcode') }}">
                <div class="bg-dark rounded-lg text-light p-2 menu-btn">                    
                    <i class="fas fa-qrcode fa-3x mb-1"></i>
                    <h6>QRコード作成</h6>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-3 p-3 menu_btn">
            <a href="{{ route('photoproject.password_entry', ['upload_flg' => '1']) }}">
                <div class="bg-dark rounded-lg text-light p-2 menu-btn">                    
                    <i class="fas fa-upload fa-3x mb-1"></i>                    
                    <h6>写真アップロード</h6>
                </div>
            </a>
        </div>


        <div class="col-6 col-md-4 col-xl-3 p-3 menu_btn">
            <a href="{{ route('photoproject.password_entry') }}">
                <div class="bg-dark rounded-lg text-light p-2 menu-btn">                    
                    <i class="fas fa-download fa-3x mb-1"></i>
                    <h6>写真取得画面</h6>
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

