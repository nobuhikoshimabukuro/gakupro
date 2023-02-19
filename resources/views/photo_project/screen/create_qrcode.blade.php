@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'QRコード管理画面')  
@endsection
@section('content')


<style>

    body{
        overflow-y: scroll;
    }

    #main button{        
        padding: 2px;
        margin: 1vh;
    }

    .select_area{       
       padding: 3px;
    }

    .select{       
       background-color: rgb(189, 204, 247);       
    }

    .qr_code_image{       
       width: 100%;
    }

    
    .code_area{
        font-size: 20px;
        font-weight: 600;
    }

    #operation_area{
        padding: 0;
        margin: 10px 0 10px 0;
    }
     
    #data_info_table{
        width: 100%;
    }

</style>


@include('photo_project.common.processing_display')


<div id='main' class="mt-3 text-center container inoperable">

    
    <div class="row m-0 p-0">

        <div class="ajax-msg1 m-2">      
                     
        </div>
        
        @php
            
            $CreatedFLG = false;
            if(count($photoget_t_info) > 0){
                $CreatedFLG = true;            
            }     

        @endphp 

        <form action="{{ route('photo_project.create_qrcode') }}" method="get" enctype="multipart/form-data" class="m-0 p-0">     

            <div id="operation_area" class="row m-0 p-0">            
                    
                <div class="col-9 m-0 p-0" align="left">

                    <label for="date" class="">開催日</label>
                    <input type="date" id="date" name="date"  value="{{$date}}">                        
                    <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i>検索</button>             

                </div>

                <div class="col-3 m-0 p-0" align="right">  
                    
                    @if($CreatedFLG)
                        {{-- <button type="button" id="" class="original_button close_modal_button">
                            <a href="{{$qr_ticket_full_path}}" target="_blank" rel="noopener noreferrer">チケット</a>
                        </button> --}}

                        <a href="{{$qr_ticket_full_path}}" target="_blank" rel="noopener noreferrer">チケット</a>
                    @endif

                    <button type="button" id="" class="btn btn-secondary display_switching" data-bs-toggle='modal' data-bs-target='#create_modal'>
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
                
                <div id="image_display_area"class="row p-0 m-0 d-none">
                    
                    <div class="col-4 p-0" align="left">                    
                        <button type="button" id="display_switching_button" class="btn btn-secondary display_switching" data-mode="1"><span id='ChangeButtonInfo2'>Qr表示</span></button>                    
                    </div>

                    <div class="col-8 p-0" align="right">
                        <button type="button" id="selectDownloadButton" class="btn btn-secondary d-none">選択DL <i class="fas fa-download"></i></button>
                        <button type="button" id="AllDownloadButton" class="btn btn-secondary">一括DL <i class="fas fa-download"></i></button> 
                        {{-- <button type="button" id="AllselectButton" class="btn btn-secondary" data-mode="1"><span id='ChangeButtonInfo1'>全選択</span></button> --}}
                        
                    </div>

                    @foreach ($photoget_t_info as $Index =>  $info)
                        
                        <div class="col-6 col-md-4 col-xl-3 p-0" style="margin-top: 10px;">

                            <div id="select_area{{$Index}}" class="select_area"
                            {{-- data-download_path="{{$info->QrTicketSaved_Path}}"   --}}
                            data-ticket_name="{{$info->name2}}"  >            

                                <div class="row">
                                    <div class="code_area">{{$info->code}}</div>
                                </div>
                            
                                {{-- <button type="button" id="QrTicketButton{{$Index}}" data-target="{{$Index}}" class="selectButton QrTicketButton">
                                    <img src="{{$info->QrTicketSaved_Path}}" class="qr_code_image" alt="">
                                </button> --}}

                                <button type="button" id="QrCodeButton{{$Index}}" data-target="{{$Index}}" class="selectButton QrCodeButton d-none" style="margin-bottom: 15px;">
                                    <img src="{{$info->QrCodeSaved_Path}}" class="qr_code_image" alt="">
                                </button>

                            </div>     
                            
                        </div>

                    @endforeach

                    
                </div> 

                
                <div id="data_display_area" class="table_wrap m-0 p-0">

                    {{-- <table id='data_info_table' class='data_info_table'> --}}
                        <table id='' class='data_info_table m-0 p-0'>
                        
                        <tr>
                            <th>ID</th>
                            <th>日付</th>            
                            <th>コード</th>
                            <th>パスワード</th>
                            <th>UP or DL</th>                            
                            <th>パスワード入力切替</th>
                            
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
                                <td>
                                    {{$info->code}}
                                    <button type="button" id="" class="btn btn-secondary display_switching" data-bs-toggle='modal' data-bs-target='#qr_display_modal'>
                                        表示
                                    </button>
                                </td>
                                <td>{{$info->display_password}}</td>                        
                                <td>

                                    <button type='button' class="btn btn-secondary copy_button" 
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
                                    <button type='button' class="btn btn-secondary with_password_flg_change_button"
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
<div class="modal fade" id="create_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="create_modal_Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="create_modal_Label"><span id="create_modal_Title"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="ajax-msg2 m-2">                    
            </div>
            
                <div class="modal-body">  

                    <div class="form-group row">

                        <div class="col-4" align="right">
                            <label for="Modal_date" class="col-md-6 col-form-label original-label">開催日</label>
                        </div>
                        <div class="col-8" align="left">
                            <label><span id="Modal_Display_date"></span></label>
                            <input type="hidden" name="Modal_date" id="Modal_date" value="" class="form-control">
                        </div>

                    </div>                     
                
                    <div class="form-group row">
                    
                        <div class="col-4" align="right">

                            @if($CreatedFLG)                            
                                <label for="count" class="col-md-6 col-form-label original-label">追加数</label>
                            @else                            
                                <label for="count" class="col-md-6 col-form-label original-label">作成数</label>
                            @endif                                
                        </div>
                        <div class="col-8" align="left">
                            <input type="tel" name="count" id="count" value="" class="form-control text-end">
                        </div>
                    </div>    
                    
                    <div class="form-group row">                    
                        <div class="col-4" align="right">
                            <label for="WithPasswordFlg" class="col-md-6 col-form-label original-label">パス有</label>
                        </div>
                        <div class="col-8" align="left">                            
                            <input type="checkbox" id="WithPasswordFlg" value="1" name="WithPasswordFlg" checked>
                        </div>
                    </div>    
                    
                    @if(env('APP_DEBUG'))
                        <div class="form-group row">

                            <div class="col-4" align="right">                                
                                <label for="count" class="col-md-6 col-form-label original-label">ローカルIP</label>                                                            
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
                <button type="button" id="" class="original_button close_modal_button" data-bs-dismiss="modal">閉じる</button>
            </div>
            

        </div>
    </div>
</div>



{{-- 作成用モーダル --}}
<div class="modal fade" id="qr_display_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="qr_display_modal_Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="qr_display_modal_Label">qr</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="ajax-msg2 m-2">                    
            </div>
            
                <div class="modal-body">  

                   

                </div>

            <div class="modal-footer">               
                
                <button type="button" id="" class="original_button close_modal_button" data-bs-dismiss="modal">閉じる</button>
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
    $('#create_modal').on('show.bs.modal', function(e) {

        var selectdate = $('#date').val();

        $('#Modal_date').val(selectdate);

        $('#Modal_Display_date').html(selectdate);
       

    });


    $('.DisplayChangeButton').click(function () {

        var mode = $(this).data('mode');

        $("#data_display_area").removeClass('d-none');
        $("#image_display_area").removeClass('d-none');

        $(".DisplayChangeButton").removeClass('d-none');
        
        if(mode == 1){
            $("#data_display_area").addClass('d-none');           
        }else{
            $("#image_display_area").addClass('d-none');           
        }

        $(this).addClass('d-none');
     
    });

    $('#AllselectButton').click(function () {

        var mode = $(this).data('mode');

        $(".select_area").removeClass('select');

        if(mode == 1){
            $('#ChangeButtonInfo1').html('選択解除');            
            $(".select_area").addClass('select');                
            $(this).data('mode', '2');
        }else{            
            $('#ChangeButtonInfo1').html('全選択');            
            $(".select_area").removeClass('select');
            $(this).data('mode', '1');
        }
        
        selectDownloadButtonDisplayJudge();

    });

    $('.selectButton').click(function () {

        var target = $(this).data('target');
        var TargetID = "#select_area" + target;

        if($(TargetID).hasClass('select')){

            $(TargetID).removeClass('select');

        }else{

            $(TargetID).addClass('select');

        }

        selectDownloadButtonDisplayJudge();

    });
        
    function selectDownloadButtonDisplayJudge(){

        var TargetElementID = "#selectDownloadButton";

        $(TargetElementID).removeClass('d-none');

        var TargetList = [];
        var i = 0;
        while(true){

            var TargetID = "#select_area" + i;

            //存在しない場合は処理抜け
            if(!($(TargetID).length)){				
                break;							
            }

            if($(TargetID).hasClass('select')){

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


    $('#display_switching_button').click(function () {       

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



    





    $('#selectDownloadButton').click(function () {

        var TargetList = [];
        var i = 0;

        while(true){

            var TargetID = "#select_area" + i;

            //存在しない場合は処理抜け
            if(!($(TargetID).length)){				
                break;							
            }

            if($(TargetID).hasClass('select')){

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

        var select_count = TargetList.length;

        if (select_count == 0){
            alert('データが選択されていません。');
            return false;
        }

        var Message = "選択数：" + select_count + "\nダウンロードしますか?";
        

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



    $(".copy_button").on('click',function(e){
        
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

        var date = $('#date').val();
        var Url = "{{ route('photo_project.qrcode_download') }}";

        var Message = "日付：" + date + "\n一括ダウンロードしますか?";


        if(!confirm(Message)){
            return false;
        }

            
        phpProcessingStart();

        $.ajax({
            url: Url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {date : date},
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

                    var errorsHtml = '<div class="alert alert-danger text-start">';
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

                    var errorsHtml = '<div class="alert alert-danger text-start">';
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


        var date = $("#date").val();
        var count = $("#count").val();
        var IpAddress = $("#IpAddress").val();
        var WithPasswordFlg = 0;

        if ($("#WithPasswordFlg").prop("checked")) {
            WithPasswordFlg = 1;
        } 


        if(date == "" || date == null){

            
            var errorsHtml = '<div class="alert alert-danger text-start">';

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


   


        let f = $('#approve_form');  

        var Url = "{{ route('photo_project.create_qrcode_execution') }}";

        $.ajax({
            url: Url, // 送信先
            type: 'post',
            dataType: 'json',
            data: {date : date , count : count , IpAddress : IpAddress, WithPasswordFlg : WithPasswordFlg},   
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}         
        })
            // 送信成功
            .done(function (data, textStatus, jqXHR) {

               

                var ResultArray = data.ResultArray;

                var Result = ResultArray["Result"];


                if(Result == 'success'){

                    location.reload();
                                    

                }else{

        
                    var errorsHtml = '<div class="alert alert-danger text-start">';
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

                   var errorsHtml = '<div class="alert alert-danger text-start">';
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




    $('.with_password_flg_change_button').click(function () {

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

        var Url = "{{ route('photo_project.with_password_flg_change') }}";

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


                    var errorsHtml = '<div class="alert alert-danger text-start">';
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

                    var errorsHtml = '<div class="alert alert-danger text-start">';
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

