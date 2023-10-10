@extends('hp.common.layouts_app')

@section('pagehead')
@section('title', '求人情報お試し')  
@endsection
@section('content')

<style>

  
  
</style>

<div id="main" class="mt-3 text-center container">

    <div id="" class="row">  

        
        @foreach ($base64imagesArray as $base64image)
            <img id="" src="{{$base64image}}" class="" alt="">
        @endforeach
    </div>
    
</div>




@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){




});

</script>
@endsection

