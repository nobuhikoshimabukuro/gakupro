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

    position: relative;
    
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


#InformationButtonArea{

    position:absolute;
	bottom: 50vh;
	right: 50vw;
	z-index: 100;
	padding: 1vh;
	
	width: 10vh;
	height:10vh;	
background-color: red;
}


#InformationButton{

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

                <div id="" class="col-3 p-0">
                </div>


                <div id="" class="col-2 text-left p-0">                

                    <button type="button" id="AllDownloadButton" class="btn btn-secondary"            
                    >All DL <i class="fas fa-download"></i>
                    </button> 

                </div>
                <div id="" class="col-2 text-center m-0 p-0">

                    <button type="button" id="InformationButton" class="btn btn-secondary" data-bs-toggle='modal' data-bs-target='#Information_Modal'>
                        Info <i class="fas fa-info"></i>
                    </button>

                </div>


                <div id="" class="col-2 text-right p-0">

                    <button type="button" id="SelectDownloadButton" class="btn btn-secondary"
                    data-targetpath="{{$UploadFileInfo[0]["PublicPath"]}}"
                    data-filename="{{$UploadFileInfo[0]["FileName"]}}'"
                    >Select DL <i class="fas fa-download"></i>
                    </button> 

                </div>

                <div id="" class="col-3 p-0">
                </div>

            @else

                <div id="" class="col-5 text-left m-0 p-0">

                    <button type="button" id="AllDownloadButton" class="btn btn-secondary MobileButton"            
                    >All DL <i class="fas fa-download"></i>
                    </button> 

                </div>

                <div id="" class="col-2 text-center m-0 p-0">

                    <button type="button" id="InformationButton" class="" data-bs-toggle='modal' data-bs-target='#Information_Modal'>
                        <i class="fas fa-info"></i>
                    </button>

                </div>

                <div id="" class="col-5 text-right m-0 p-0">

                    <button type="button" id="SelectDownloadButton" class="btn btn-secondary MobileButton"
                    data-targetpath="{{$UploadFileInfo[0]["PublicPath"]}}"
                    data-filename="{{$UploadFileInfo[0]["FileName"]}}'"
                    >Select DL <i class="fas fa-download"></i>
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


    {{-- <div id="InformationButtonArea">

        <div id="up-area" style="text-align: center;">
            <i id="up" class="fas fa-arrow-up"></i>
        </div>

        <div id="center-area" style="text-align: center;">
            <i id="left" class="fas fa-arrow-left"></i>            
            <button type="button" id="InformationButton" class="" data-bs-toggle='modal' data-bs-target='#Information_Modal'>
                <i class="fas fa-info"></i>
            </button>
            <i id="right" class="fas fa-arrow-right"></i>
            
        </div>

        <div id="down-area" style="text-align: center;">
            <i id="down" class="fas fa-arrow-down"></i>
        </div>     
    </div> --}}


    {{-- インフォメーションモーダル --}}
    <div class="modal fade" id="Information_Modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="Create_Modal_Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="Create_Modal_Label"><span id="Create_Modal_Title"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">  
                    iPhoneをご利用の方                    
                    .....

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
   


    var _isMoving = false; //移動中かどうかのフラグ true:移動中 false:停止中
    var _clickX,  _clickY; //クリックされた位置
    var _position;         //クリックされた時の要素の位置

    //mousedownイベント
    $("#InformationButtonArea").on("mousedown", function(e) {
      if (_isMoving) return; //移動中の場合は処理しない

      _isMoving = true; //移動中にする

      //クリックされた座標を保持します
      _clickX = e.screenX;
      _clickY = e.screenY;

      //クリックされた時の要素の座標を保持します
      _position = $("#InformationButtonArea").position();
    });

    //mousemoveイベント
    $("#Main").on("mousemove", function(e) {
      if (_isMoving == false) return; //移動中でない場合は処理しない

      //クリックされた時の要素の座標に、移動量を加算したものを、座標として設定します
      $("#InformationButtonArea").css("left", (_position.left + e.screenX - _clickX) + "px");
      $("#InformationButtonArea").css("top" , (_position.top  + e.screenY - _clickY) + "px");
    });

    //mouseupイベント
    $("#InformationButtonArea").on("mouseup", function(e) {
      if (_isMoving == false) return; //移動中でない場合は処理しない

      _isMoving = false; //停止中にする
    });



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

