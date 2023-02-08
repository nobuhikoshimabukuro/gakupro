@extends('photoproject.common.layouts_customer')

@section('pagehead')
@section('title', 'info')  
@endsection
@section('content')

<style>

</style>

<div id="main" class="mt-3 text-center container">
    
    <div id='' class="row">
     
        @if(session('before_upload_message')) 
            <h4>画像がまだアップロードされておりません。</h4>           
            <h4>時間をあけて再度QRコードを読み直してください。</h4>
        @else
            <h4>再度QRコードを読み直してください。</h4>
        @endif

        <div id="">
            <img id=''src='{{ asset('img/photoproject/syazai.png') }}' alt=''>                       
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

