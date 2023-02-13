@extends('photoproject.common.layouts_customer')

@section('pagehead')
@section('title', 'info')  
@endsection
@section('content')

<style>
img{
    width: 100%;
}
</style>

<div id="main" class="mt-3 text-center container">
    
    <div id='' class="row">
     
        @if(session('before_upload_message')) 
            <h5>画像がまだアップロードされておりません。</h5>
            <h5>時間をあけて再度QRコードを読み直してください。</h5>
        @else
            <h5>再度QRコードを読み直してください。</h5>
        @endif

        <div id="">
            <img id='' class="" src='{{ asset('img/photoproject/syazai.png') }}' alt=''>                       
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

