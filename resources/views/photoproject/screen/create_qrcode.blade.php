@extends('headquarters.common.layouts_app')

@section('pagehead')
@section('title', 'QRコード管理画面')  
@endsection
@section('content')


<style>

    body{
        overflow-y: scroll;
    }

    #Main button{        
        padding: 2px;
        margin: 1vh;
    }

    .SelectArea{       
       padding: 3px;
    }

    .Select{       
       background-color: rgb(189, 204, 247);       
    }

    .QRCode_Image{       
       width: 100%;
    }

    
    .CodeArea{
        font-size: 20px;
        font-weight: 600;
    }

    #OperationArea{
        padding: 0;
        margin: 10px 0 10px 0;
    }
     
    #DataInfoTable{
        width: 100%;
    }

</style>


@include('photoproject.common.processing_display')


<div id='Main' class="mt-3 text-center container InoperableClass">

    
    <div class="row m-0 p-0">

        <div class="ajax-msg1 m-2">      
                     
        </div>
        
        @php
            
            $CreatedFLG = false;
            if(count($photoget_t_info) > 0){
                $CreatedFLG = true;            
            }     

        @endphp 

        <form action="{{ route('photoproject.create_qrcode') }}" method="get" enctype="multipart/form-data" class="m-0 p-0">     

            <div id="OperationArea" class="row m-0 p-0">            
                    
                <div class="col-9 m-0 p-0" align="left">

                    <label for="Date" class="">開催日</label>
                    <input type="date" id="Date" name="Date"  value="{{$Date}}">                        
                    <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i>検索</button>             

                </div>

                <div class="col-3 m-0 p-0" align="right">              
                    <button type="button" id="" class="btn btn-secondary DisplaySwitching" data-bs-toggle='modal' data-bs-target='#Create_Modal'>
                        <i class="fas fa-folder-plus"></i>作成
                    </button>

                </div>
            </div>
        
        </form>


   



        @if($CreatedFLG)

            <div id=""class="row m-0 p-0">  

                
                <div class="col-12 p-0" align="right">
                    <button type="button" id="" class="DisplayChangeButton btn btn-secondary" data-mode="1"><i class="fas fa-qrcode"></i> Qr表示</button>  
                    <button type="button" id="" class="DisplayChangeButton btn btn-secondary d-none" data-mode="2"><i class="fas fa-database"></i> データ表示</button>            
                </div>
                
                <div id="ImageDisplayArea"class="row p-0 m-0 d-none">
                    
                    <div class="col-4 p-0" align="left">                    
                        <button type="button" id="DisplaySwitchingButton" class="btn btn-secondary DisplaySwitching" data-mode="1"><span id='ChangeButtonInfo2'>Qr表示</span></button>                    
                    </div>

                    <div class="col-8 p-0" align="right">
                        <button type="button" id="SelectDownloadButton" class="btn btn-secondary d-none">選択DL <i class="fas fa-download"></i></button>
                        <button type="button" id="AllDownloadButton" class="btn btn-secondary">一括DL <i class="fas fa-download"></i></button> 
                        {{-- <button type="button" id="AllSelectButton" class="btn btn-secondary" data-mode="1"><span id='ChangeButtonInfo1'>全選択</span></button> --}}
                        
                    </div>

                    @foreach ($photoget_t_info as $Index =>  $info)
                        
                        <div class="col-6 col-md-4 col-xl-3 p-0" style="margin-top: 10px;">

                            <div id="SelectArea{{$Index}}" class="SelectArea"
                            data-download_path="{{$info->QrTicketSaved_Path}}"  
                            data-ticket_name="{{$info->name2}}"  >            

                                <div class="row">
                                    <div class="CodeArea">{{$info->code}}</div>
                                </div>
                            
                                <button type="button" id="QrTicketButton{{$Index}}" data-target="{{$Index}}" class="SelectButton QrTicketButton">
                                    <img src="{{$info->QrTicketSaved_Path}}" class="QRCode_Image" alt="">
                                </button>

                                <button type="button" id="QrCodeButton{{$Index}}" data-target="{{$Index}}" class="SelectButton QrCodeButton d-none" style="margin-bottom: 15px;">
                                    <img src="{{$info->QrCodeSaved_Path}}" class="QRCode_Image" alt="">
                                </button>

                            </div>     
                            
                        </div>

                    @endforeach

                    
                </div> 

                
                <div id="DataDisplayArea" class="DataInfoTable-Wrap m-0 p-0">

                    {{-- <table id='DataInfoTable' class='DataInfoTable'> --}}
                        <table id='' class='DataInfoTable m-0 p-0'>
                        
                        <tr>
                            <th>ID</th>
                            <th>日付</th>            
                            <th>コード</th>
                            <th>パスワード</th>
                            <th>UP or DL</th>
                            <th>パスワード入力必要</th>
                            
                            {{-- <th>QrCode名</th>
                            <th>チケット名</th>                     --}}
                        </tr>
            
                        @foreach ($photoget_t_info as $Index =>  $info)

                            @php
                                $Upload_Url = $info->url . "&upload_flg=1";
                                $Download_Url = $info->url;
                            @endphp
                            <tr>
                                <td>{{$info->id}}</td>
                                <td>{{$info->display_date}}</td>
                                <td>{{$info->code}}</td>
                                <td>{{$info->password}}</td>                        
                                <td>

                                    <button type='button' class="btn btn-secondary CopyButton" 
                                    data-uploadurl="{{$Upload_Url}}" 
                                    data-downloadurl="{{$Download_Url}}">Url Copy</button>
                                    
                                    <button type='button' onclick="window.open('{{$Upload_Url}}')"><i class="fas fa-upload"></i></button>
                                    <button type='button' onclick="window.open('{{$Download_Url}}')"><i class="fas fa-download"></i></i></button>
                                    
                                </td>
                                <td>
                                    @if($info->with_password_flg == 1)
                                        必要
                                    @else
                                        不要
                                    @endif                                    
                                    <button type='button' class="btn btn-secondary with_password_flg_ChangeButton"
                                        data-id="{{$info->id}}"
                                        data-passwordflg="{{$info->with_password_flg}}"
                                    >変更</button>
                                </td>
                               
                            </tr>    
                        @endforeach

                    </table>

                </div>   

                
            </div>   
            

        @endif

      
    </div>
</div>







{{-- 作成用モーダル --}}
<div class="modal fade" id="Create_Modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="Create_Modal_Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="Create_Modal_Label"><span id="Create_Modal_Title"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="ajax-msg2 m-2">                    
            </div>
            
                <div class="modal-body">  

                    <div class="form-group row">

                        <div class="col-4" align="right">
                            <label for="Modal_Date" class="col-md-6 col-form-label OriginalLabel">開催日</label>
                        </div>
                        <div class="col-8" align="left">
                            <label><span id="Modal_Display_Date"></span></label>
                            <input type="hidden" name="Modal_Date" id="Modal_Date" value="" class="form-control">
                        </div>

                    </div>                     
                
                    <div class="form-group row">
                    
                        <div class="col-4" align="right">

                            @if($CreatedFLG)                            
                                <label for="Count" class="col-md-6 col-form-label OriginalLabel">追加数</label>
                            @else                            
                                <label for="Count" class="col-md-6 col-form-label OriginalLabel">作成数</label>
                            @endif                                
                        </div>
                        <div class="col-8" align="left">
                            <input type="tel" name="Count" id="Count" value="" class="form-control text-right">
                        </div>
                    </div>    
                    
                    <div class="form-group row">                    
                        <div class="col-4" align="right">
                            <label for="WithPasswordFlg" class="col-md-6 col-form-label OriginalLabel">パス有</label>
                        </div>
                        <div class="col-8" align="left">                            
                            <input type="checkbox" id="WithPasswordFlg" value="1" name="WithPasswordFlg" checked>
                        </div>
                    </div>    
                    
                    @if(env('APP_DEBUG'))
                        <div class="form-group row">

                            <div class="col-4" align="right">                                
                                <label for="Count" class="col-md-6 col-form-label OriginalLabel">ローカルIP</label>                                                            
                            </div>
                            <div class="col-8" align="left">
                                <input type="text" name="IpAddress" id="IpAddress" value="" class="form-control">
                            </div>
                        </div>                 
                    @else
                        <input type="hidden" id="IpAddress" name="IpAddress" value="">
                    @endif              

                </div>

            <div class="modal-footer">               
                <button type="button" id="CreateButton" class="btn btn-secondary">作成</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
            </div>
            

        </div>
    </div>
</div>






@endsection

@section('pagejs')

<script type="text/javascript">

    window.addEventListener('load', function(){
        LoaderEnd();
    });

$(function(){

    //作成用モーダル表示時
    $('#Create_Modal').on('show.bs.modal', function(e) {

        var SelectDate = $('#Date').val();

        $('#Modal_Date').val(SelectDate);

        $('#Modal_Display_Date').html(SelectDate);
       

    });


    $('.DisplayChangeButton').click(function () {

        var mode = $(this).data('mode');

        $("#DataDisplayArea").removeClass('d-none');
        $("#ImageDisplayArea").removeClass('d-none');

        $(".DisplayChangeButton").removeClass('d-none');
        
        if(mode == 1){
            $("#DataDisplayArea").addClass('d-none');           
        }else{
            $("#ImageDisplayArea").addClass('d-none');           
        }

        $(this).addClass('d-none');
     
    });

    $('#AllSelectButton').click(function () {

        var mode = $(this).data('mode');

        $(".SelectArea").removeClass('Select');

        if(mode == 1){
            $('#ChangeButtonInfo1').html('選択解除');            
            $(".SelectArea").addClass('Select');                
            $(this).data('mode', '2');
        }else{            
            $('#ChangeButtonInfo1').html('全選択');            
            $(".SelectArea").removeClass('Select');
            $(this).data('mode', '1');
        }
        
        SelectDownloadButtonDisplayJudge();

    });

    $('.SelectButton').click(function () {

        var target = $(this).data('target');
        var TargetID = "#SelectArea" + target;

        if($(TargetID).hasClass('Select')){

            $(TargetID).removeClass('Select');

        }else{

            $(TargetID).addClass('Select');

        }

        SelectDownloadButtonDisplayJudge();

    });
        
    function SelectDownloadButtonDisplayJudge(){

        var TargetElementID = "#SelectDownloadButton";

        $(TargetElementID).removeClass('d-none');

        var TargetList = [];
        var i = 0;
        while(true){

            var TargetID = "#SelectArea" + i;

            //存在しない場合は処理抜け
            if(!($(TargetID).length)){				
                break;							
            }

            if($(TargetID).hasClass('Select')){

                var Download_Path = $(TargetID).data('download_path'); 
                var Ticket_Name = $(TargetID).data('ticket_name');                 
                                                
                var Info = {
                    Download_Path:Download_Path
                    ,Ticket_Name:Ticket_Name                  
                };

                TargetList.push(Info);

            }		

            i++;
        }   

        if (TargetList.length > 0){

            $(TargetElementID).removeClass('d-none');
            
        }else{

            $(TargetElementID).addClass('d-none');

        }

    }


    $('#DisplaySwitchingButton').click(function () {       

        var mode = $(this).data('mode');

        $(".QrTicketButton").removeClass('d-none');
        $(".QrCodeButton").removeClass('d-none');
            

        if(mode == 1){
            $('#ChangeButtonInfo2').html('チケット表示');            
            $(".QrTicketButton").addClass('d-none');                     
            $(this).data('mode', '2');
        }else{            
            $('#ChangeButtonInfo2').html('Qr表示');            
            $(".QrCodeButton").addClass('d-none');   
            $(this).data('mode', '1');            
        }

    });



    





    $('#SelectDownloadButton').click(function () {

        var TargetList = [];
        var i = 0;

        while(true){

            var TargetID = "#SelectArea" + i;

            //存在しない場合は処理抜け
            if(!($(TargetID).length)){				
                break;							
            }

            if($(TargetID).hasClass('Select')){

                var Download_Path = $(TargetID).data('download_path'); 
                var Ticket_Name = $(TargetID).data('ticket_name');                 
                                                
                var Info = {
                    Download_Path:Download_Path
                    ,Ticket_Name:Ticket_Name                  
                };

                TargetList.push(Info);               

            }		

            i++;
        }   

        var SelectCount = TargetList.length;

        if (SelectCount == 0){
            alert('データが選択されていません。');
            return false;
        }

        var Message = "選択数：" + SelectCount + "\nダウンロードしますか?";
        

        if(!confirm(Message)){
			return false;
		}

        phpProcessingStart();


        $.each(TargetList, function (key, Info) {

            var Download_Path = Info["Download_Path"];
            var Ticket_Name = Info["Ticket_Name"];

            var a = document.createElement('a');
            a.download = Ticket_Name;
            a.href = Download_Path;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        });       

        phpProcessingEnd();

    });



    $(".CopyButton").on('click',function(e){
        
        var upload_url = $(this).data('uploadurl');
        var download_url = $(this).data('downloadurl');
       
        // テキストエリアのテキストを取得（コピーさせるテキスト）
       

        var text = "アップロードページ" + "\n" + upload_url + "\n";
        text += "ダウンロードページ" + "\n" + download_url;
        // コピーする媒体となるテキストエリアを生成
        var clipboard = $('<textarea></textarea>');
        clipboard.text(text);
        // body直下に一時的に挿入
        $('body').append(clipboard);
        // 選択状態にする
        clipboard.select();
        // WebExtension APIのブラウザ拡張の仕組みを呼び出しクリップボードにコピー
        document.execCommand('copy');
        // 不要なテキストエリアを削除
        clipboard.remove();
        // 通知
        alert('クリップボードにコピーしました');
       

    });


    $('#AllDownloadButton').click(function () {


        $('.ajax-msg1').html('');
        $('.ajax-msg2').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        var Date = $('#Date').val();
        var Url = "{{ route('photoproject.qrcode_download') }}";

        var Message = "日付：" + Date + "\n一括ダウンロードしますか?";


        if(!confirm(Message)){
            return false;
        }

            
        phpProcessingStart();

        $.ajax({
            url: Url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {Date : Date},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}

        })
            // 送信成功
            .done(function (data, textStatus, jqXHR) {
                
                phpProcessingEnd();

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

                    var errorsHtml = '<div class="alert alert-danger text-left">';
                    var massage1 = "Qrコード一括ダウンロード処理でエラーが発生しました。";
                    var massage2 = "管理に報告をお願い致します。";

                    errorsHtml += '<li>' + massage1 + '</li>';                    
                    errorsHtml += '<li>' + massage2 + '</li>';
                    errorsHtml += '</div>';

                    //{{-- アラート --}}    
                    $('.ajax-msg1').html(errorsHtml);

                

                }

            
            })

                // 送信失敗
                .fail(function (data, textStatus, errorThrown) {
                    
                    phpProcessingEnd();

                    var errorsHtml = '<div class="alert alert-danger text-left">';
                    var massage1 = "Qrコード一括ダウンロード処理でエラーが発生しました。";
                    var massage2 = "管理に報告をお願い致します。";

                    errorsHtml += '<li>' + massage1 + '</li>';                    
                    errorsHtml += '<li>' + massage2 + '</li>';
                    errorsHtml += '</div>';

                    //{{-- アラート --}}    
                    $('.ajax-msg1').html(errorsHtml);

                });




    });




    $('#CreateButton').click(function () {

        //{{-- メッセージクリア --}}
        $('.ajax-msg1').html('');
        $('.ajax-msg2').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');


        var Date = $("#Date").val();
        var Count = $("#Count").val();
        var IpAddress = $("#IpAddress").val();
        var WithPasswordFlg = 0;

        if ($("#WithPasswordFlg").prop("checked")) {
            WithPasswordFlg = 1;
        } 


        if(Date == "" || Date == null){

            
            var errorsHtml = '<div class="alert alert-danger text-left">';

            var massage1 = "モーダルを閉じ、開催日を設定してください";
            errorsHtml += '<li>' + massage1 + '</li>';
            var massage2 = "開催日設定後検索してください。";
            errorsHtml += '<li>' + massage2 + '</li>';
            errorsHtml += '</div>';

            //{{-- アラート --}}    
            $('.ajax-msg2').html(errorsHtml);
            return false;
        }



        phpProcessingStart();


   


        let f = $('#ApproveForm');  

        var Url = "{{ route('photoproject.create_qrcode_execution') }}";

        $.ajax({
            url: Url, // 送信先
            type: 'post',
            dataType: 'json',
            data: {Date : Date , Count : Count , IpAddress : IpAddress, WithPasswordFlg : WithPasswordFlg},   
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}         
        })
            // 送信成功
            .done(function (data, textStatus, jqXHR) {

               

                var ResultArray = data.ResultArray;

                var Result = ResultArray["Result"];


                if(Result == 'success'){

                    location.reload();
                                    

                }else{

        
                    var errorsHtml = '<div class="alert alert-danger text-left">';
                    var massage1 = "Qrチケット作成処理でエラーが発生しました。";
                    var massage2 = "管理に報告をお願い致します。";

                    errorsHtml += '<li>' + massage1 + '</li>';                    
                    errorsHtml += '<li>' + massage2 + '</li>';
                    errorsHtml += '</div>';

                    //{{-- アラート --}}    
                    $('.ajax-msg2').html(errorsHtml);
            

                }

                phpProcessingEnd();
                

            })
                // 送信失敗
                .fail(function (data, textStatus, errorThrown) {

                   var errorsHtml = '<div class="alert alert-danger text-left">';
                    var massage1 = "Qrチケット作成処理でエラーが発生しました。";
                    var massage2 = "管理に報告をお願い致します。";

                    errorsHtml += '<li>' + massage1 + '</li>';                    
                    errorsHtml += '<li>' + massage2 + '</li>';
                    errorsHtml += '</div>';

                    //{{-- アラート --}}    
                    $('.ajax-msg2').html(errorsHtml);

                    phpProcessingEnd();
                   

                });

    });




    $('.with_password_flg_ChangeButton').click(function () {

        //{{-- メッセージクリア --}}
        $('.ajax-msg1').html('');
        $('.ajax-msg2').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');


     

        var id = $(this).data('id'); 
        var with_password_flg = $(this).data('passwordflg'); 
       
        var message = "";
        
        if(with_password_flg == 0){
            message = "パスワード入力必要状態に変更しますか?";
        }else{
            message = "パスワード入力不要状態に変更しますか?";
        }

        if(!confirm(message)){          
            return false;        
        }

        var Url = "{{ route('photoproject.with_password_flg_change') }}";

        phpProcessingStart();

        $.ajax({
            url: Url, // 送信先
            type: 'post',
            dataType: 'json',
            data: {id : id , with_password_flg : with_password_flg},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}         
        })
            // 送信成功
            .done(function (data, textStatus, jqXHR) {

            

                var ResultArray = data.ResultArray;

                var Result = ResultArray["Result"];


                if(Result == 'success'){

                    location.reload();
                                    

                    
                }else{


                    var errorsHtml = '<div class="alert alert-danger text-left">';
                    var massage1 = "パスワード必要フラグの変更時にエラーが発生しました。";
                    var massage2 = "管理に報告をお願い致します。";

                    errorsHtml += '<li>' + massage1 + '</li>';                    
                    errorsHtml += '<li>' + massage2 + '</li>';
                    errorsHtml += '</div>';

                    //{{-- アラート --}}    
                    $('.ajax-msg2').html(errorsHtml);
            

                }

                
                phpProcessingEnd();

            })
                // 送信失敗
                .fail(function (data, textStatus, errorThrown) {

                    phpProcessingEnd();

                    var errorsHtml = '<div class="alert alert-danger text-left">';
                    var massage1 = "パスワード必要フラグの変更時にエラーが発生しました。";
                    var massage2 = "管理に報告をお願い致します。";

                    errorsHtml += '<li>' + massage1 + '</li>';                    
                    errorsHtml += '<li>' + massage2 + '</li>';
                    errorsHtml += '</div>';

                    //{{-- アラート --}}    
                    $('.ajax-msg2').html(errorsHtml);

                });

        });














});

</script>
@endsection

