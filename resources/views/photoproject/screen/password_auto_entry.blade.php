@extends('photoproject.common.layouts_customer')

@section('pagehead')
@section('title', 'お待ちください')  
@endsection
@section('content')

<style>

</style>




<form action="{{ route('photoproject.photo_confirmation') }}" id='ApproveForm' method="post" enctype="multipart/form-data">
    @csrf                
    <input type="hidden" name="key_code" id="" value="{{$key_code}}" class="form-control">
    <input type="hidden" name="Cipher" id="" value="{{$Cipher}}" class="form-control">
    <input type="hidden" name="password" id="" value="{{$password}}" class="form-control">
</form>

@endsection

@section('pagejs')
<script type="text/javascript">

  
$(function(){   

  


   
    $(document).ready( function(){               

        // 確認画面へ画面遷移
        $('#ApproveForm').submit(); 

    });







 
});

</script>
@endsection

