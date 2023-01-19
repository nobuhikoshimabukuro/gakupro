@extends('recruitproject.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'メニュー')  
@endsection
@section('content')

<style>
   
    
    
    
</style>

<div id="Main" class="mt-3 text-center container">
    <div class="row">
 
        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('recruitproject.employer_information_confirmation') }}">                
                <div class="bg-primary rounded-lg text-light p-2 ">
                    <i class="fas fa-user-cog fa-3x mb-1"></i>
                    <h6>雇用者情報</h6>
                </div>
            </a>
        </div>    

        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('recruitproject.job_information_confirmation') }}">
                <div class="bg-primary rounded-lg text-light p-2 ">
                    <i class="fas fa-clipboard-list fa-3x mb-1"></i>
                    <h6>求人情報</h6>
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

