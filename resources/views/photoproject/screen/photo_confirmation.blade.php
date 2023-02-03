@extends('photoproject.common.layouts_customer')

@section('pagehead')
@section('title', '写真取得画面')  
@endsection
@section('content')

<style>

html,body{
  /* overflow: hidden */
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

#languageSelectArea{
    margin-bottom: 4px;
}

.languageSelectButton , .terminalSelectButton{
    color: rgb(37, 29, 29);
    font-weight: 600;
}

.languageSelectd , .terminalSelectd{
    background: -moz-linear-gradient(top, #c48123, rgb(160, 189, 30));
    background: -webkit-linear-gradient(top, #c4bcb2, rgb(243, 186, 186));
    background: linear-gradient(to bottom, #e9b46f, rgb(186, 218, 219));
    color: rgb(244, 248, 234);
    font-weight: 750;
}



</style>

@include('photoproject.common.processing_display')

<div id="Main" class="InoperableClass">
    
    <div id="MainPhotoArea">

        <img id='MainPhoto'src='{{$UploadFileInfo[0]["PublicPath"]}}' alt=''>           

    </div>

    <div id="PhotoSelectArea" class="row">


        <div id="DownloadButtonArea" class="row m-0 p-0">

            <input type="hidden" id="pc_flg" value="{{$termina_info['pc_flg']}}">
            <input type="hidden" id="terminal" value="{{$termina_info['terminal']}}">
                        
            @if($termina_info['pc_flg'] == 1)
                
                

                <div id="" class="col-3 p-0">
                </div>


                <div id="" class="col-2 text-left p-0">                

                    <button type="button" id="AllDownloadButton" class="btn btn-secondary"            
                    ><span id='AllDownloadButton-Text'>全てDL </span><i class="fas fa-download"></i>
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
                    ><span id='SelectDownloadButton-Text'>選択DL </span><i class="fas fa-download"></i>
                    </button> 

                </div>

                <div id="" class="col-3 p-0">
                </div>

            @else

                <input type="hidden" id="PC_FLG" value="0">

                <div id="" class="col-5 text-left m-0 p-0">

                    <button type="button" id="AllDownloadButton" class="btn btn-secondary MobileButton"            
                    ><span id='AllDownloadButton-Text'>全てDL </span><i class="fas fa-download"></i>
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
                    ><span id='SelectDownloadButton-Text'>選択DL </span><i class="fas fa-download"></i>
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



    {{-- インフォメーションモーダル --}}
    <div class="modal fade" id="Information_Modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="Create_Modal_Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="Create_Modal_Label"><span id="Create_Modal_Title"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                                
             
                <div class="modal-body">  
                    
                    <div id="languageSelectArea" class="row">
                        <div id="" class="col-5 text-right m-0 p-0">
                            <button type="button" id="JapaneseSelect" 
                            class="btn languageSelectButton"
                            data-target="1">Japanese</button> 
                        </div>    
                        
                        <div id="" class="col-2 text-right m-0 p-0">
                        </div>

                        <div id="" class="col-5 text-left m-0 p-0">
                            <button type="button" id="EnglishSelect" 
                            class="btn languageSelectButton"
                            data-target="2">English</button>                             
                        </div>
                    </div>


                    @if($termina_info['pc_flg'] == 1)

                        
                        <div id="terminalSelectArea" class="row">

                            <div id="" class="col-5 text-right m-0 p-0">
                                <button type="button" id="macOSSelect" 
                                class="btn terminalSelectButton"
                                data-target="1">macOS</button>                             
                            </div>
                            
                            
                            <div id="" class="col-2 text-right m-0 p-0">
                            </div>

                            

                            <div id="" class="col-5 text-left m-0 p-0">
                                <button type="button" id="windowsSelect" 
                                class="btn terminalSelectButton"
                                data-target="2">windows</button> 
                            </div>  

                        </div>

                    @else

                        <div id="terminalSelectArea" class="row">

                            <div id="" class="col-5 text-right m-0 p-0">
                                <button type="button" id="iOSSelect" 
                                class="btn terminalSelectButton"
                                data-target="1">iOS</button>                             
                            </div>
                            
                            <div id="" class="col-2 text-right m-0 p-0">
                            </div>

                            <div id="" class="col-5 text-left m-0 p-0">
                                <button type="button" id="AndroidSelect" 
                                class="btn terminalSelectButton"
                                data-target="2">Android</button> 
                            </div>    
                            
                           

                        </div>

                    @endif
                   

                    <div id="ExplanationArea" class="row">

                        <span id="Explanation-Text">

                        </span>
                     

                    </div>

                    <div id="" class="row">

                        <h4>共有用URL  <button type='button' class="btn btn-secondary CopyButton"                 
                            data-downloadurl="{{$photoget_t_info->url}}">Url Copy</button></h4>
                        {{$photoget_t_info->url}}

                        @if($photoget_t_info->with_password_flg == 1)
                        <br>パスワードも送ってね
                        @endif

                        

                    </div>


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
    <input type="hidden" name="cipher" id="" value="{{$cipher}}">    
</form>


@endsection

@section('pagejs')
<script type="text/javascript">

  
$(function(){   

    var language = '1';
    var pc_flg = $('#pc_flg').val();    
    var terminal = $('#terminal').val();;


    $(document).ready(function(){
        PhotoSwitching();
        LoaderEnd();

        languageChange();
        terminalSelect();
        ExplanationChange();
    });

    // 画面幅が変更されたときに実行させたい処理内容
    $(window).resize(function(){ 

        LoaderEnd();
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
   
  

    $(".languageSelectButton").on('click',function(e){
           
        language = $(this).data('target');
        languageChange();        
        ExplanationChange();

    });

    function languageChange(){

        //選択中のクラスを解除
        $('.languageSelectd').removeClass('languageSelectd');

        // target = 1(日本語)
        // target = 2(英語)

        if(language == 1){

            $('#JapaneseSelect').addClass('languageSelectd');

            $('#AllDownloadButton-Text').html("全てDL ");
            $('#SelectDownloadButton-Text').html("選択DL ");


        }else if(language == 2){

            $('#EnglishSelect').addClass('languageSelectd');

            $('#AllDownloadButton-Text').html("All DL ");
            $('#SelectDownloadButton-Text').html("Select DL ");



        }
       
    }

    $(".terminalSelectButton").on('click',function(e){

        terminal = $(this).data('target');
        
        terminalSelect();
        ExplanationChange();

    });

    function terminalSelect(){
      
        $('.terminalSelectd').removeClass('terminalSelectd');
        
        if(pc_flg == 1){

            if(terminal == 1){
                
                $('#macOSSelect').addClass('terminalSelectd');

            }else if(terminal == 2){

                $('#windowsSelect').addClass('terminalSelectd');                

            }

        }else{

            if(terminal == 1){

                $('#iOSSelect').addClass('terminalSelectd');                

            }else if(terminal == 2){

                $('#AndroidSelect').addClass('terminalSelectd');               

            }
        }       

    }

    function ExplanationChange(){

        var Selectlanguage = "";

        var Selectterminal = "";
        if(language == 1){
        
            Selectlanguage = "日本語"

            if(pc_flg == 1){

                if(terminal == 1){

                    Selectterminal = "macOS";
                    

                }else if(terminal == 2){

                    Selectterminal = "windows";
                }

            }else{

                if(terminal == 1){

                    Selectterminal = "iOS";
                    
                }else if(terminal == 2){

                    Selectterminal = "Android";
                }
            }               
       

        }else if(language == 2){

            Selectlanguage = "English"
       

            if(pc_flg == 1){

                if(terminal == 1){

                    Selectterminal = "macOS";                    

                }else if(terminal == 2){

                    Selectterminal = "windows";
                }

                }else{

                if(terminal == 1){

                    Selectterminal = "iOS";
                    
                }else if(terminal == 2){

                    Selectterminal = "Android";
                }
            }               
        }

        $('#Explanation-Text').html(Selectlanguage + ' ' + Selectterminal);
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
        var cipher = $("#cipher").val();

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



    $(".CopyButton").on('click',function(e){
        
        
        var download_url = $(this).data('downloadurl');
       
        // テキストエリアのテキストを取得（コピーさせるテキスト）        
        var text = "ダウンロードページ" + "\n" + download_url;
        // コピーする媒体となるテキストエリアを生成
        var clipboard = $('<textarea></textarea>');
        clipboard.text(text);
        // Information_Modal直下に一時的に挿入        
        $('#Information_Modal').append(clipboard);        
        // 選択状態にする
        clipboard.select();
        // WebExtension APIのブラウザ拡張の仕組みを呼び出しクリップボードにコピー
        document.execCommand('copy');
        // 不要なテキストエリアを削除
        clipboard.remove();
        // 通知
        alert('クリップボードにコピーしました');
       

    });


 
});

</script>
@endsection

