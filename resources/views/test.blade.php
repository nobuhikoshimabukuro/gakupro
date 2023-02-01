@php 
    $css_connect = "?" . date('YmdHis');
@endphp

<!doctype html>
<html lang="ja">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('css/all.css') . $css_connect}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') . $css_connect}}" rel="stylesheet">  
    <link href="{{ asset('css/headquarters/common.css') . $css_connect}}" rel="stylesheet">          
    
    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- CSRFトークン --}}
    
    <title></title>
</head>

<style>

#DataDisplayArea{

    min-width: 100vw;
    max-width: 100vw;

    min-height: 100vh;
    max-height: 100vh;
}

.DataInfoTable{
    min-width: 100vw;
    max-width: 100vw;

    min-height: 100vh;
    max-height: 100vh;

}
.pdf-td{

    min-width: 100vw;
    max-width: 100vw;

    min-height: 100vh;
    max-height: 100vh;

}

.pdf{

    min-width: 100vw;
    max-width: 100vw;

    min-height: 100vh;
    max-height: 100vh;

}
</style>

<body>
    <a href="{{$picturebook_info[0]['PublicPath']}}">pdfを表示</a>
    <div id="DataDisplayArea" class="Table-Wrap m-0">

        <table id='' class='DataInfoTable'>
            
            
            
            <tr>

                @foreach($picturebook_info as $info)
                    <td class="pdf-td">
                        <embed src='{{$info['PublicPath']}}'class="pdf" alt="">    
                    </td>                
                @endforeach
                
            </tr>

        </table>

    </div>



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

