@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'PHP情報')  
@endsection
@section('content')





<div id="Main" class="mt-3 text-center container">
    
    {{phpinfo();}}
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){

    

});

</script>
@endsection

