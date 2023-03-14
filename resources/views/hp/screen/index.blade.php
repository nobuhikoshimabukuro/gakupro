@extends('hp.common.layouts_app')

@section('pagehead')
@section('title', '学生応援プロジェクト')  
@endsection
@section('content')

<style>
   #movie{
    width: 100%;
    height: auto;
   }
</style>

<div id="main" class="mt-3 text-center container">

    <a class="nav-link dropdown-item" href="{{ route('headquarters.login') }}">管理者</a>

    <div class="row">   

        <div class="col-1">
        </div>
        <div class="col-10 text-center">
            <video id="movie" src="{{ asset('movie/hp/test.mp4')}}" controls></video>
        </div>
        <div class="col-1">
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

