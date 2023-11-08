@extends('photo_project.common.layouts_customer')

@section('pagehead')
@section('title', '写真取得画面')  
@endsection
@section('content')

<style>

html,body{
  /* overflow: hidden */
}


#main{
    width: 100%;
    /*jQueryで高さ取得
    height:100vh;  
    */
    background-color: rgb(248, 248, 247);

    position: relative;
    
}


#main_photo_area{     
    top: 0;
    left: 0;
    width: 100%;

    /*jQueryで高さ取得
    height:60vh;  
    */      
}


#main_photo{       
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

#photo_select_area{        
      
    object-fit: contain;
    
    margin-left:5vw;
    width: 90vw;  
    /*jQueryで高さ取得
    height: 20vh;
    */
    position: relative;
    bottom: 0; /*下に固定*/
}

#photo_select_area table {
   
    display: block;
    overflow-x: scroll;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
       
}


#photo_select_area td {  
  max-width:15vh; 
  max-height:15vh;
  min-width:15vh; 
  min-height:15vh;
  padding: 1px;     
}


#photo_select_area .SubPhoto{ 
    
    width: 80%;    
    object-fit: contain;
}

table {
    border-collapse: separate; /* 枠線(ボーダー)を離して表示 */    
}

#photo_select_area .photo_non_select {
    border: 1px rgb(98, 136, 238) dashed;    
}

#photo_select_area .photo_select {
    border: 1px rgb(216, 186, 18) solid;
    
}



#download_button_area {
    
    margin-bottom: 1vh;    

}

.mobile_button{
    padding: 2px;
}

#language_aelect_area{
    margin-bottom: 4px;
}

.language_select_button , .terminal_select_button{
    color: rgb(37, 29, 29);
    font-weight: 600;
}

.language_selectd , .terminal_selectd{
    background: -moz-linear-gradient(top, #c48123, rgb(160, 189, 30));
    background: -webkit-linear-gradient(top, #c4bcb2, rgb(243, 186, 186));
    background: linear-gradient(to bottom, #e9b46f, rgb(186, 218, 219));
    color: rgb(244, 248, 234);
    font-weight: 750;
}


.display_url{
    font-size: 5px;
}

</style>

@include('photo_project.common.processing_display')

<div id="main" class="inoperable">
    
    <div id="main_photo_area">

        <img id='main_photo'src='{{$UploadFileInfo[0]["PublicPath"]}}' alt=''>           

    </div>

    <div id="photo_select_area" class="row">


        <div id="download_button_area" class="row m-0 p-0">

            <input type="hidden" id="pc_flg" value="{{$termina_info['pc_flg']}}">
            <input type="hidden" id="terminal" value="{{$termina_info['terminal']}}">
                        
            @if($termina_info['pc_flg'] == 1)
                
                

                <div id="" class="col-3 p-0">
                </div>


                <div id="" class="col-2 text-start p-0">                

                    <button type="button" id="all_download_button" class="btn btn-secondary"            
                    ><span id='all_download_button-text'>全てDL </span><i class="fas fa-download"></i>
                    </button> 

                </div>
                <div id="" class="col-2 text-center m-0 p-0">

                    <button type="button" id="information_button" class="btn btn-secondary" data-bs-toggle='modal' data-bs-target='#information_modal'>
                        Info <i class="fas fa-info"></i>
                    </button>

                </div>


                <div id="" class="col-2 text-end p-0">

                    <button type="button" id="select_download_button" class="btn btn-secondary"
                    data-targetpath="{{$UploadFileInfo[0]["PublicPath"]}}"
                    data-filename="{{$UploadFileInfo[0]["FileName"]}}'"
                    ><span id='select_download_button-Text'>選択DL </span><i class="fas fa-download"></i>
                    </button> 

                </div>

                <div id="" class="col-3 p-0">
                </div>

            @else

                <input type="hidden" id="PC_FLG" value="0">

                <div id="" class="col-5 text-start m-0 p-0">

                    <button type="button" id="all_download_button" class="btn btn-secondary mobile_button"            
                    ><span id='all_download_button-text'>全てDL </span><i class="fas fa-download"></i>
                    </button> 

                </div>

                <div id="" class="col-2 text-center m-0 p-0">

                    <button type="button" id="information_button" class="" data-bs-toggle='modal' data-bs-target='#information_modal'>
                        <i class="fas fa-info"></i>
                    </button>

                </div>

                <div id="" class="col-5 text-end m-0 p-0">

                    <button type="button" id="select_download_button" class="btn btn-secondary mobile_button"
                    data-targetpath="{{$UploadFileInfo[0]["PublicPath"]}}"
                    data-filename="{{$UploadFileInfo[0]["FileName"]}}'"
                    ><span id='select_download_button-Text'>選択DL </span><i class="fas fa-download"></i>
                    </button> 

                </div>        
             

            @endif
          
        </div>

        <div id="" class="row m-0 p-0">

            <table>

                @foreach ($UploadFileInfo as $Index => $Info)

                    <td id='subPhoto_td{{$Index}}' class="subPhoto_td @if($Index == 0) photo_select @else Transparent photo_non_select @endif">                                                

                        <button type="button" id="photo_button{{$Index}}" class="photo_button" 
                        data-targetindex="{{$Index}}" 
                        data-targetpath="{{$Info["PublicPath"]}}" 
                        data-filename="{{$Info["FileName"]}}">
                            <div id="subphoto_inner_area{{$Index}}"class="subphoto_inner_area">
                                <img src="{{$Info["PublicPath"]}}" class="SubPhoto" alt="">
                            </div>
                        </button>

                    </td>

                @endforeach

            </table>
        </div>

    </div>



    {{-- インフォメーションモーダル --}}
    <div class="modal fade" id="information_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="Create_modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="Create_modal-label"><span id="Create_Modal_Title"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                                
             
                <div class="modal-body">  
                    
                    <div id="language_aelect_area" class="row">
                        <div id="" class="col-5 text-end m-0 p-0">
                            <button type="button" id="japanese_select" 
                            class="btn language_select_button"
                            data-target="1">Japanese</button> 
                        </div>    
                        
                        <div id="" class="col-2 text-end m-0 p-0">
                        </div>

                        <div id="" class="col-5 text-start m-0 p-0">
                            <button type="button" id="english_select" 
                            class="btn language_select_button"
                            data-target="2">English</button>                             
                        </div>
                    </div>


                    @if($termina_info['pc_flg'] == 1)

                        
                        <div id="terminal_select_area" class="row">

                            <div id="" class="col-5 text-end m-0 p-0">
                                <button type="button" id="macOSSelect" 
                                class="btn terminal_select_button"
                                data-target="1">macOS</button>                             
                            </div>
                            
                            
                            <div id="" class="col-2 text-end m-0 p-0">
                            </div>

                            

                            <div id="" class="col-5 text-start m-0 p-0">
                                <button type="button" id="windowsSelect" 
                                class="btn terminal_select_button"
                                data-target="2">windows</button> 
                            </div>  

                        </div>

                    @else

                        <div id="terminal_select_area" class="row">

                            <div id="" class="col-5 text-end m-0 p-0">
                                <button type="button" id="iOSSelect" 
                                class="btn terminal_select_button"
                                data-target="1">iOS</button>                             
                            </div>
                            
                            <div id="" class="col-2 text-end m-0 p-0">
                            </div>

                            <div id="" class="col-5 text-start m-0 p-0">
                                <button type="button" id="AndroidSelect" 
                                class="btn terminal_select_button"
                                data-target="2">Android</button> 
                            </div>    
                            
                           

                        </div>

                    @endif
                   

                    <div id="explanation_area" class="row">

                        <span id="explanation_text">

                        </span>
                     

                    </div>

                    <div id="" class="row">

                        <h4>共有用URL  <button type='button' class="btn btn-secondary copy_button"                 
                            data-downloadurl="{{$photoget_t_info->url}}">Url Copy</button></h4>
                        
                        <span class="display_url">{{$photoget_t_info->url}}</span>

                        @if($photoget_t_info->with_password_flg == 1)
                        <br>
                        パスワードも送ってね
                        @endif

                        

                    </div>


                </div>

              

                <div class="modal-footer">                                   
                    <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>
                </div>  
            </div>
        </div>
    </div>


    
</div>


<form id="batch_download_form" method="post" class="d-none" action="{{ route('photo_project.batch_download') }}">  
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

        var main_photo_area_vh = 0.77;
        var photo_select_area_vh = 0.21;

        var vh = $(window).height();

        $('#main').outerHeight(vh);
        $('#main_photo_area').outerHeight(vh * main_photo_area_vh);
        $('#photo_select_area').outerHeight(vh * photo_select_area_vh);
    }
   
  

    $(".language_select_button").on('click',function(e){
           
        language = $(this).data('target');
        languageChange();        
        ExplanationChange();

    });

    function languageChange(){

        //選択中のクラスを解除
        $('.language_selectd').removeClass('language_selectd');

        // target = 1(日本語)
        // target = 2(英語)

        if(language == 1){

            $('#japanese_select').addClass('language_selectd');

            $('#all_download_button-text').html("全てDL ");
            $('#select_download_button-Text').html("選択DL ");


        }else if(language == 2){

            $('#english_select').addClass('language_selectd');

            $('#all_download_button-text').html("All DL ");
            $('#select_download_button-Text').html("Select DL ");



        }
       
    }

    $(".terminal_select_button").on('click',function(e){

        terminal = $(this).data('target');
        
        terminalSelect();
        ExplanationChange();

    });

    function terminalSelect(){
      
        $('.terminal_selectd').removeClass('terminal_selectd');
        
        if(pc_flg == 1){

            if(terminal == 1){
                
                $('#macOSSelect').addClass('terminal_selectd');

            }else if(terminal == 2){

                $('#windowsSelect').addClass('terminal_selectd');                

            }

        }else{

            if(terminal == 1){

                $('#iOSSelect').addClass('terminal_selectd');                

            }else if(terminal == 2){

                $('#AndroidSelect').addClass('terminal_selectd');               

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

        $('#explanation_text').html(Selectlanguage + ' ' + Selectterminal);
    }


    $(".photo_button").on('click',function(e){
        
        var targetindex = $(this).data('targetindex');
        var targetpath = $(this).data('targetpath');
        var filename = $(this).data('filename');

        $('.photo_select').removeClass('photo_select');			
        $('.photo_non_select').removeClass('photo_non_select');		

        $('.subPhoto_td').addClass('photo_non_select');
        $('#subPhoto_td' + targetindex).removeClass('photo_non_select');
        $('#subPhoto_td' + targetindex).addClass('photo_select');	

		$('.subPhoto_td').addClass('Transparent');
        $('#subPhoto_td' + targetindex).removeClass('Transparent');
        

        $("#main_photo_area").empty();

        var Element = "";

        Element +="<img id='main_photo'src='" + targetpath + "' alt=''>";

        $('#main_photo_area').append(Element);


        $('#select_download_button').data('targetpath', targetpath);
        $('#select_download_button').data('filename', filename);
       

    });

    $("#select_download_button").on('click',function(e){    

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


    $('#all_download_button').click(function () {

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
                
                var result_array = data.result_array;

                var Result = result_array["Result"];

                if(Result=='success'){

                    var ZipName = result_array["ZipName"];
                    var ZipDownloadPath = result_array["ZipDownloadPath"];

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



    $(".copy_button").on('click',function(e){
        
        
        var download_url = $(this).data('downloadurl');
       
        // テキストエリアのテキストを取得（コピーさせるテキスト）        
        var text = "ダウンロードページ" + "\n" + download_url;
        // コピーする媒体となるテキストエリアを生成
        var clipboard = $('<textarea></textarea>');
        clipboard.text(text);
        // information_modal直下に一時的に挿入        
        $('#information_modal').append(clipboard);        
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

