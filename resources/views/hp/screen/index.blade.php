@extends('hp.common.layouts_app')

@section('pagehead')
@section('title', '学生応援プロジェクト')  
@endsection
@section('content')

<style>
   
</style>

<div class="mt-3 text-center container">
    
    <div class="row">
    ここにHP作成予定        
    </div>
        
    <div class="col-6 col-md-4 col-xl-3 p-3 ">
        <a href="{{ route('headquarters.index') }}">                                    
            <h6>本部画面</h6>                
        </a>
    </div>

</div>

@endsection

@section('pagejs')
<script src="{{ asset('js/common.js') }}"></script>
<script type="text/javascript">

$(function(){




});

</script>
@endsection

