@extends('hp.common.layouts_app')

@section('pagehead')
@section('title', '求人情報')  
@endsection
@section('content')

<style>

    
</style>

<div id="main" class="mt-3 text-center container">

    <div id="" class="row item-center">

        <textarea id=""  class ="application_requirements" name="Content"> 
        {{$job_information->application_requirements}}   
        </textarea>     

    </div>
    
</div>




@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){




});

</script>
@endsection

