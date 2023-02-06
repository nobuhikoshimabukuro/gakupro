@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'メニュー')  
@endsection
@section('content')

<style>
   
</style>

<div id="Main"class="mt-3 text-center container">
    <div class="row">
       

        
        
        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('master.index') }}">
              
                <div class="bg-dark rounded-lg text-light p-2 ">
                    <i class="fas fa-coins fa-3x mb-1"></i>
                    <h6>各マスタ</h6>
                </div>
            </a>
        </div>

        
       
        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('photoproject.index') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">
                    <i class="fas fa-camera fa-3x mb-1"></i>
                    <h6>写真プロジェクト                        
                    </h6>
                </div>
            </a>
        </div>


        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('recruitproject.index') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">
                    <i class="fas fa-praying-hands fa-3x mb-1"></i>
                    <h6>リクルートプロジェクト                        
                    </h6>
                </div>
            </a>
        </div>
        
        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('headquarters.test') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="fas fa-school fa-3x mb-1"></i>
                    <h6>TEST</h6>
                </div>
            </a>
        </div>
      

      
        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('headquarters.phpinfo') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="fas fa-school fa-3x mb-1"></i>
                    <h6>PHP情報</h6>
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

