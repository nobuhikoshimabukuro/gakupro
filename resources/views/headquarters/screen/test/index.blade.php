@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'メニュー')  
@endsection
@section('content')

<style>
   
</style>

<div id="main"class="mt-3 text-center container">
    <div class="row">
       

        
        
        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('headquarters.test1') }}">
              
                <div class="bg-dark rounded-lg text-light p-2 ">
                    <i class="fas fa-coins fa-3x mb-1"></i>
                    <h6>TEST1</h6>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('headquarters.test2') }}">
              
                <div class="bg-dark rounded-lg text-light p-2 ">
                    <i class="fas fa-coins fa-3x mb-1"></i>
                    <h6>TEST2</h6>
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

