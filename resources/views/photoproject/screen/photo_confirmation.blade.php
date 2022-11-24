@extends('photoproject.common.layouts_customer')

@section('pagehead')
@section('title', '写真取得画面')  
@endsection
@section('content')

<style>

html,body{
  overflow: hidden
}


#Main{
    width: 100%;
    /*jQueryで高さ取得
    height:100vh;  
    */
    background-color: rgb(248, 248, 247);

    position: relative
}


#MainPhotoArea{     
    top: 0;
    left: 0;
    width: 100%;

    /*jQueryで高さ取得
    height:60vh;  
    */      
}


#MainPhoto{       
    padding: 1vh;    
    width: 100%;    
    height:  100%;
    object-fit: contain;        
}


.Transparent{
    opacity:0.6;
}

.Transparent:hover{
    opacity:1;
}

#PhotoSelectArea{        
      
    object-fit: contain;
    
    margin-left:5vw;
    width: 90vw;  
    /*jQueryで高さ取得
    height: 20vh;
    */
    position: relative;
    bottom: 0; /*下に固定*/
}

#PhotoSelectArea table {
   
    display: block;
    overflow-x: scroll;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
       
}


#PhotoSelectArea td {  
  max-width:15vh; 
  max-height:15vh;
  min-width:15vh; 
  min-height:15vh;
  padding: 1px;     
}


#PhotoSelectArea .SubPhoto{ 
    
    width: 80%;    
    object-fit: contain;
}



table {
    border-collapse: separate; /* 枠線(ボーダー)を離して表示 */
    
  }

  #PhotoSelectArea .PhotoNonSelect {
    border: 1px rgb(98, 136, 238) dashed;
    
}
#PhotoSelectArea .PhotoSelect {
    border: 1px rgb(216, 186, 18) solid;
    
}



#DownloadButtonArea {
    
    margin-bottom: 1vh;    

}

.MobileButton{
    padding: 2px;
}

#InformationButton{

    position: fixed; /* 要素の位置を固定する */
    top: 0; /* 基準の位置を画面の一番下に指定する */
    left: 0; /* 基準の位置を画面の一番右に指定する */
    border: none;
    outline: none;
    background: transparent;

}



</style>

@include('photoproject.common.processing_display')

<div id="Main" class="InoperableClass">
    
    <div id="MainPhotoArea">

        <img id='MainPhoto'src='{{$UploadFileInfo[0]["PublicPath"]}}' alt=''>           

    </div>

    <div id="PhotoSelectArea" class="row">


        <div id="DownloadButtonArea" class="row m-0 p-0">

            @if($PC_FLG)

                <div id="" class="col-2 p-0">
                </div>


                <div id="" class="col-3 text-right p-0">                

                    <button type="button" id="AllDownloadButton" class="btn btn-secondary"            
                    >一括Download <i class="fas fa-download"></i>
                    </button> 

                </div>

                <div id="" class="col-2 p-0">
                </div>


                <div id="" class="col-3 text-left p-0">

                    <button type="button" id="SelectDownloadButton" class="btn btn-secondary"
                    data-targetpath="{{$UploadFileInfo[0]["PublicPath"]}}"
                    data-filename="{{$UploadFileInfo[0]["FileName"]}}'"
                    >選択画像Download <i class="fas fa-download"></i>
                    </button> 

                </div>

                <div id="" class="col-2 p-0">
                </div>

            @else

                <div id="" class="col-6 text-left m-0 p-0">

                    <button type="button" id="AllDownloadButton" class="btn btn-secondary MobileButton"            
                    >一括Download <i class="fas fa-download"></i>
                    </button> 

                </div>

                <div id="" class="col-6 text-right m-0 p-0">

                    <button type="button" id="SelectDownloadButton" class="btn btn-secondary MobileButton"
                    data-targetpath="{{$UploadFileInfo[0]["PublicPath"]}}"
                    data-filename="{{$UploadFileInfo[0]["FileName"]}}'"
                    >選択画像Download <i class="fas fa-download"></i>
                    </button> 

                </div>        
             

            @endif
          
        </div>

        <div id="" class="row m-0 p-0">

            <table>

                @foreach ($UploadFileInfo as $Index => $Info)

                    <td id='SubPhoto-td{{$Index}}' class="SubPhoto-td @if($Index == 0) PhotoSelect @else Transparent PhotoNonSelect @endif">                                                

                        <button type="button" id="PhotoButton{{$Index}}" class="PhotoButton" 
                        data-targetindex="{{$Index}}" 
                        data-targetpath="{{$Info["PublicPath"]}}" 
                        data-filename="{{$Info["FileName"]}}">
                            <div id="SubPhotoInnerArea{{$Index}}"class="SubPhotoInnerArea">
                                <img src="{{$Info["PublicPath"]}}" class="SubPhoto" alt="">
                            </div>
                        </button>

                    </td>

                @endforeach

            </table>
        </div>

    </div>


    {{-- <button type="button" id="InformationButton" class="" data-bs-toggle='modal' data-bs-target='#Information_Modal'>
        <i class="fas fa-mobile-alt"></i>スマートフォンの方へ
    </button> --}}


    {{-- インフォメーションモーダル --}}
    <div class="modal fade" id="Information_Modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="Create_Modal_Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="Create_Modal_Label"><span id="Create_Modal_Title"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">  

                    
                    

                </div>

                <div class="modal-footer">                                   
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                </div>  
            </div>
        </div>
    </div>


























    
</div>


<form id="batch_download_form" method="post" class="d-none" action="{{ route('photoproject.batch_download') }}">  
    @csrf
    <input type="hidden" name="key_code" id="" value="{{$key_code}}">
    <input type="hidden" name="Cipher" id="" value="{{$Cipher}}">    
</form>


@endsection

@section('pagejs')
<script src="{{ asset('js/common.js') }}"></script>
<script type="text/javascript">

  
$(function(){   

    window.addEventListener('load', function(){
        
        PhotoSwitching();
        LoaderEnd();
    });


    // 画面幅が変更されたときに実行させたい処理内容
    $(window).resize(function(){ 

        PhotoSwitching();        
      
    });

    function PhotoSwitching(){

        var MainPhotoArea_vh = 0.77;
        var PhotoSelectArea_vh = 0.21;

        var vh = $(window).height();

        $('#Main').outerHeight(vh);
        $('#MainPhotoArea').outerHeight(vh * MainPhotoArea_vh);
        $('#PhotoSelectArea').outerHeight(vh * PhotoSelectArea_vh);
    }
   

    $(".PhotoButton").on('click',function(e){
        
        var targetindex = $(this).data('targetindex');
        var targetpath = $(this).data('targetpath');
        var filename = $(this).data('filename');

        $('.PhotoSelect').removeClass('PhotoSelect');			
        $('.PhotoNonSelect').removeClass('PhotoNonSelect');		

        $('.SubPhoto-td').addClass('PhotoNonSelect');
        $('#SubPhoto-td' + targetindex).removeClass('PhotoNonSelect');
        $('#SubPhoto-td' + targetindex).addClass('PhotoSelect');	

		$('.SubPhoto-td').addClass('Transparent');
        $('#SubPhoto-td' + targetindex).removeClass('Transparent');
        

        $("#MainPhotoArea").empty();

        var Element = "";

        Element +="<img id='MainPhoto'src='" + targetpath + "' alt=''>";

        $('#MainPhotoArea').append(Element);


        $('#SelectDownloadButton').data('targetpath', targetpath);
        $('#SelectDownloadButton').data('filename', filename);
       

    });

    $("#SelectDownloadButton").on('click',function(e){    

        var targetpath = $(this).data('targetpath');
        var filename = $(this).data('filename');

        if(targetpath == "" || filename == ""){

            alert('画面下部から画像を再選択してください。');
            return false;
        }

        var a = document.createElement('a');
        a.download = filename;
        a.href = targetpath;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        

    });


    $('#AllDownloadButton').click(function () {

        var key_code = $("#key_code").val();
        var Cipher = $("#Cipher").val();

        let f = $('#batch_download_form');

        $.ajax({
            url: f.prop('action'), // 送信先
            type: f.prop('method'),
            dataType: 'json',
            data: f.serialize(),
        })
            // 送信成功
            .done(function (data, textStatus, jqXHR) {
                
                var ResultArray = data.ResultArray;

                var Result = ResultArray["Result"];

                if(Result=='success'){

                    var ZipName = ResultArray["ZipName"];
                    var ZipDownloadPath = ResultArray["ZipDownloadPath"];

                    var a = document.createElement('a');
                    a.download = ZipName;
                    a.href = ZipDownloadPath;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);

                }else{

                  

                }

            
            })

                // 送信失敗
                .fail(function (data, textStatus, errorThrown) {
                    
                

                });



    });




 
});

</script>
@endsection

