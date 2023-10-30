@php 
    $update_now = "?" . date('YmdHis');
@endphp

<!doctype html>
<html lang="ja">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no viewport-fit=cover">
    <link href="{{ asset('css/all.css') . $update_now}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') . $update_now}}" rel="stylesheet">  
    <link href="{{ asset('css/headquarters/common.css') . $update_now}}" rel="stylesheet">          
    
    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- CSRFトークン --}}
    
    <title></title>
</head>

<style>

</style>

<body>
    
    <form action="{{ route('headquarters.pdf_test') }}" id='approve_form' method="post" enctype="multipart/form-data">
        @csrf
        <button type="submit" id='approve_button' class="btn btn-secondary">GO</button>

    </form>



</body>
</html>



<script src="http://127.0.0.1:8000/js/bootstrap.js"></script>
<script src="http://127.0.0.1:8000/js/jquery-3.6.0.min.js"></script>
<script src="http://127.0.0.1:8000/js/app.js"></script>
<script src="http://127.0.0.1:8000/js/headquarters/common.js"></script>



<script type="text/javascript">

$(function(){




});

</script>

