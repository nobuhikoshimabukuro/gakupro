@extends('recruitproject.common.layouts_beforelogin')

@section('pagehead')
@section('title', 'info')  
@endsection
@section('content')

<style>

</style>

<div class="mt-3 text-center container">
    
    <div id='' class="row">
     
        @if(session('infomessage'))             
            <h4>{{session('infomessage')}}</h4>
        @endif

    </div>
</div>
@endsection

@section('pagejs')
<script src="{{ asset('js/common.js') }}"></script>
<script type="text/javascript">

$(function(){

    $(window).on('load', function() { 

        LoaderEnd();

    });

});

</script>
@endsection

