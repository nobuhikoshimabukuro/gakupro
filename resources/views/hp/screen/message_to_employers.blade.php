@extends('hp.common.layouts_app')

@section('pagehead')
@section('title', '雇用者様へ')  
@endsection
@section('content')

<style>

  
  
</style>

<div id="main" class="mt-3 text-center container">

    <div id="" class="row">  
        
        <form action="{{ route('hp.pseudo_job_information') }}" id='upload_form'method="post" enctype="multipart/form-data" target="_blank">
            @csrf

            <input type="file" id='file_input'name="file[]" lang="ja" accept="png,.jpg,.jpeg" multiple>
            <button type="submit">Submit</button>
        </form>

        
    </div>
    
</div>




@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){




});

</script>
@endsection

