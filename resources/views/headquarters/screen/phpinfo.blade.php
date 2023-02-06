@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'PHP情報')  
@endsection
@section('content')

<style>
   
</style>

<div id="Main"class="mt-3 text-center container">
    <div class="row">
       
        {{phpinfo()}}
    </div>
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){




});

</script>
@endsection

