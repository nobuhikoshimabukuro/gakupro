@extends('photoproject.common.layouts_customer')

@section('pagehead')
@section('title', 'info')  
@endsection
@section('content')

<style>
.syazai{
    margin-top: 5vh;
    width: 100%;

}
</style>

<div id="main" class="mt-3 text-center container">
    
    <div id='' class="row">
     
        @if(session('before_upload_message')) 
            <h6>画像がまだアップロードされておりません。</h6>
            <h6>時間をあけて再度QRコードを読み直してください。</h6>
        @else
            <h6>再度QRコードを読み直してください。</h6>
        @endif

        <div id="">
            <img id='' class="syazai" src='{{ asset('img/photoproject/syazai.png') }}' alt=''>                       
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

