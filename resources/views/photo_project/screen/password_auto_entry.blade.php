@extends('photo_project.common.layouts_customer')

@section('pagehead')
@section('title', 'check the photo')  
@endsection
@section('content')

<style>

</style>




<form action="{{ route('photo_project.photo_confirmation') }}" id='approve_form' method="post" enctype="multipart/form-data">
    @csrf                
    <input type="hidden" name="key_code" id="" value="{{$key_code}}" class="form-control">
    <input type="hidden" name="cipher" id="" value="{{$cipher}}" class="form-control">
    <input type="hidden" name="password" id="" value="{{$password}}" class="form-control">
</form>

@endsection

@section('pagejs')
<script type="text/javascript">

  
$(function(){   

  


   
    $(document).ready( function(){               

        // 確認画面へ画面遷移
        $('#approve_form').submit(); 

    });







 
});

</script>
@endsection

