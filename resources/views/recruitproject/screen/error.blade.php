@extends('recruitproject.common.layouts_beforelogin')

@section('pagehead')
@section('title', 'エラー画面')  
@endsection
@section('content')

<style>

.PhotoArea{       
       padding: 3px;
    }

    .Photo{       
       width: 100%;
    }
</style>

<div class="mt-3 text-center container">
    
    <div id='' class="row">
        <h4>処理エラー</h4>
        @if(session('errormessage'))            
        <h5>{{session('errormessage')}}</h5>
        @endif

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

