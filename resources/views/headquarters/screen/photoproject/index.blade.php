@extends('headquarters.common.layouts_app')

@section('pagehead')
@section('title', 'フォトプロメニュー')  
@endsection
@section('content')

<style>
   
    
    
    
</style>

<div id="Main" class="mt-3 text-center container">
    <div class="row">
              
       
        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('photoproject.create_qrcode') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="fas fa-qrcode fa-3x mb-1"></i>
                    <h6>QRコード管理画面</h6>
                </div>
            </a>
        </div>      
        
        </div>
    </div>
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){



    

    





});

</script>
@endsection

