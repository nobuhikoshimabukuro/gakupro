@extends('headquarters.common.layouts_app')

@section('pagehead')
@section('title', 'スタッフマスタ')  
@endsection
@section('content')

<div class="mt-3 text-center container">
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row">
        <div class="col-4 text-left">
            <h4 class="MasterTitle">
                スタッフマスタ
            </h4>
        </div>

        <div class="col-4">         
        </div>

        <div class="col-4 NewAddition-Button">
            <a href="" class="btn btn--red btn--radius btn--cubic" 
            data-bs-toggle='modal' data-bs-target='#Save_Modal'            
            data-processflg='0'
            ><i class='fas fa-plus-circle'></i>　新規追加</a>               
        </div>

    </div>


        <table id='' class='DataInfoTable'>
            
            <tr>
                <th>スタッフID</th>
                <th>氏名</th>                
                <th>TEL</th>                
                <th>権限</th>
                <th>件数【<span id='TotalNumber'>{{$staff_list->count()}}</span>件】</th>

                @if($operator_authority > 1)
                    <th>ログイン情報</th>
                @endif
            </tr>

            @foreach ($staff_list as $item)
            <tr>
                <td>{{$item->staff_id}}</td>
                <td>{{$item->staff_name}}</td>                
                <td>{{$item->tel}}</td>
                <td>{{$item->authority_name}}</td>
               
                <td>
                    <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#Save_Modal'
                        data-staffid='{{$item->staff_id}}'
                        data-staffname='{{$item->staff_name}}'
                        data-staffnameyomi='{{$item->staff_name_yomi}}'
                        data-nickname='{{$item->nickname}}'
                        data-gender='{{$item->gender}}'
                        data-tel='{{$item->tel}}'
                        data-authority='{{$item->authority}}'                        
                        data-processflg='1'> 
                        <i class='far fa-edit'></i>
                    </button>

                    <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#Dlete_Modal'
                        data-staffid='{{$item->staff_id}}'
                        data-staffname='{{$item->staff_name}}'
                        data-staffnameyomi='{{$item->staff_name_yomi}}'
                        data-nickname='{{$item->nickname}}'
                        data-gender='{{$item->gender}}'
                        data-tel='{{$item->tel}}'
                        data-authority='{{$item->authority}}'  
                        data-deleteflg=@if($item->deleted_at) 0 @else 1 @endif>
                                    
                        @if($item->deleted_at)
                            <i class='far fa-thumbs-down'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-up'></i>
                        @else
                            <i class='far fa-thumbs-up'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-down'></i>
                        @endif
                    </button>             

                </td>

                @if($operator_authority > 1)
                    <td>
                        <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#LoginInfo_Modal'
                            data-passwordid='{{$item->password_id}}'
                            data-staffid='{{$item->staff_id}}'
                            data-loginid='{{$item->login_id}}'
                            data-password='{{$item->password}}'
                            > 
                            <i class="fas fa-info"></i>
                        </button>
                    </td>
                @endif

            </tr>

            @endforeach
        </table>




        {{-- 登録/更新用モーダル --}}
        <div class="modal fade" id="Save_Modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="Save_Modal_Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="Save_Modal_Label"><span id="Save_Modal_Title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg m-2">
                        
                    </div>
                    
                    <form id="SaveForm" method="post" action="{{ route('master.staff.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                                                        
                            <input type="hidden" name="staff_id" id="staff_id" value="">                            
                                                        
                           
                            <div class="form-group row">


                                <label for="staff_name" class="col-md-6 col-form-label OriginalLabel">氏名</label>
                                <input type="text" name="staff_name" id="staff_name" value="" class="form-control col-md-3">
    
                                <label for="staff_name_yomi" class="col-md-6 col-form-label OriginalLabel">シメイ</label>
                                <input type="text" name="staff_name_yomi" id="staff_name_yomi" value="" class="form-control col-md-3">
    
                                <label for="nickname" class="col-md-6 col-form-label OriginalLabel">ニックネーム</label>
                                <input type="text" name="nickname" id="nickname" value="" class="form-control col-md-3">
    
                                <label for="gender" class="col-md-6 col-form-label OriginalLabel">性別</label>                               
                                <select id='gender' name='gender' class='form-control input-sm'>									
										@foreach($gender_list as $item)
										<option value="{{$item->gender_cd}}">
                                            {{$item->gender_name}}
                                        </option>
										@endforeach
                                </select>

                                <label for="tel" class="col-md-6 col-form-label OriginalLabel">TEL</label>
                                <input type="tel" name="tel" id="tel" value="" class="form-control col-md-3">

                                <label for="mailaddress" class="col-md-6 col-form-label OriginalLabel">メールアドレス</label>
                                <input type="text" name="mailaddress" id="mailaddress" value="" class="form-control col-md-3">

                                <label for="authority" class="col-md-6 col-form-label OriginalLabel">権限</label>                               
                                <select id='authority' name='authority' class='form-control input-sm'>									
										@foreach($authority_list as $item)
										<option value="{{$item->authority_cd}}">
                                            {{$item->authority_name}}
                                        </option>
										@endforeach
                                </select>
                              </div>                                                 
                            
                        </div>

                        <div class="modal-footer">               
                            <button type="submit" id='SaveButton' class="btn btn-primary"><span id='Save_Modal_Button_Display'></span></button>       
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        {{-- 削除用モーダル --}}
        <div class="modal fade" id="Dlete_Modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="Dlete_Modal_Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="Dlete_Modal_Label">操作確認</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    
                    <form id="Deleteform" method="post" action="{{ route('master.staff.delete_or_restore') }}">       
                        @csrf
                        <div class="modal-body">

                            <input type="hidden" id="delete_staff_id" name="delete_staff_id" value="">                            
                            <input type="hidden" id="delete_staff_name" name="delete_staff_name" value="">
            

                            <table class="dlete_modal_table">
                                
                                <tr>
                                    <td class="dlete_modal_table-column">スタッフID：</td> 
                                    <td class="dlete_modal_table-value"><span id="Display_Maincategory_Name"></span></td>                                                                       
                                </tr>

                                <tr>
                                    <td class="dlete_modal_table-column">スタッフ名：</td> 
                                    <td class="dlete_modal_table-value"><span id="Display_staff_Name"></span></td>                                                                       
                                </tr>

                            </table>                            

                        </div>

                        <div class="modal-footer">         
                            
                            <div class="row">

                                <div class="col-12 tect-right"> 
                                    <button type="submit" id='Dlete_Modal_RunButton' class="btn btn-primary"><span class="Dlete_Modal_Wording"></span></button>       
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>      
                                </div>
                                                        
                            </div>          
                            
                        </div>
                    </form>

                </div>
            </div>
        </div>


        {{-- パスワード変更モーダル --}}
        <div class="modal fade" id="LoginInfo_Modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="LoginInfo_Modal_Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="LoginInfo_Modal_Label"><span id="LoginInfo_Modal_Title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg m-2">
                        
                    </div>
                    
                    <form id="LoginInfoForm" method="post" action="{{ route('master.staff.login_info_update') }}">                    
                        @csrf
                        <div class="modal-body">  
                                                        
                            <input type="hidden" name="logininfo_staff_id" id="logininfo_staff_id" value="">
                            <input type="hidden" name="logininfo_password_id" id="logininfo_password_id" value="">
                            
                            <div class="form-group row">
    
                                <label for="login_id" class="col-md-6 col-form-label OriginalLabel">ログインID</label>
                                <input type="text" name="login_id" id="login_id" value="" class="form-control col-md-3">
    
                                <label for="password" class="col-md-6 col-form-label OriginalLabel">パスワード</label>
                                <input type="text" name="password" id="password" value="" class="form-control col-md-3">
                            </div>                                                 
                            
                        </div>

                        <div class="modal-footer">               
                            <button type="submit" id='LoginInfoChangeButton' class="btn btn-primary">ログイン情報変更</button>       
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


      

    </div>
</div>
@endsection

@section('pagejs')
<script src="{{ asset('js/common.js') }}"></script>
<script type="text/javascript">

$(function(){

    //登録、更新用モーダル表示時
    $('#Save_Modal').on('show.bs.modal', function(e) {

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        $('#staff_id').val('');        
        $('#staff_name').val('');
        $('#staff_name_yomi').val('');
        $('#nickname').val('');
        $('#gender').val('');
        $('#tel').val('');
        $('#mailaddress').val('');
        $('#authority').val(''); 

        // イベント発生元
        let evCon = $(e.relatedTarget);

        var staff_id = evCon.data('staffid');
        var staff_name = evCon.data('staffname');
        var staff_name_yomi = evCon.data('staffnameyomi');
        var gender = evCon.data('gender');
        var nickname = evCon.data('nickname');
        var tel = evCon.data('tel');
        var mailaddress = evCon.data('mailaddress');
        var authority = evCon.data('authority');


        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');
        if(processflg == '0'){
            $('#Save_Modal_Title').html('登録処理');         
            $('#staff_id').val(0);            
            $('#Save_Modal_Button_Display').html('登録');
        }else{
            $('#Save_Modal_Title').html('更新処理');   
            $('#staff_id').val(staff_id);            
            $('#Save_Modal_Button_Display').html('更新');
        }
             
        $('#staff_id').val(staff_id);
        $('#staff_name').val(staff_name);
        $('#staff_name_yomi').val(staff_name_yomi);
        $('#nickname').val(nickname);
        $('#gender').val(gender);
        $('#tel').val(tel);
        $('#mailaddress').val(mailaddress);
        $('#authority').val(authority);                
    });


    //削除モーダル表示時
    $('#Dlete_Modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var staff_id = evCon.data('staffid');
        var maincategory_name = evCon.data('maincategoryname');    
        var staff_name = evCon.data('staffname');    
        var deleteflg = evCon.data('deleteflg');

        if (deleteflg == 0) {
            var wording = "利用可能にする";            
            $('#Dlete_Modal_RunButton').css({'background-color':'blue','border-color':'blue'});

        } else {
            var wording = "利用不可にする";                 
            $('#Dlete_Modal_RunButton').css({'background-color':'red','border-color':'red'});            
        }
    
        $('#Display_Maincategory_CD').html(maincategory_cd);    
        $('#Display_Maincategory_Name').html(maincategory_name);    
        $('#Display_staff_Name').html(staff_name);   
        $('.Dlete_Modal_Wording').html(wording);


        $('#delete_staff_id').val(staff_id);
        $('#delete_maincategory_name').val(maincategory_name);  
        $('#delete_staff_name').val(staff_name);  

    });



    //ログイン情報変更モーダル表示時
    $('#LoginInfo_Modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);
        
        var password_id = evCon.data('passwordid');
        var staff_id = evCon.data('staffid');
        var login_id = evCon.data('loginid');    
        var password = evCon.data('password');

        $('#logininfo_password_id').val(password_id);
        $('#logininfo_staff_id').val(staff_id);
        $('#login_id').val(login_id);  
        $('#password').val(password);  

    });




    // 「保存」ボタンがクリックされたら
    $('#SaveButton').click(function () {
     
        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $(this).prop("disabled", true);

        setTimeout(function () {
            $('#SaveButton').prop("disabled", false);
        }, 3000);

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        let f = $('#SaveForm');

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';

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

                    location.reload();

                }else{

                    var ErrorMessage = ResultArray["Message"];

                    //{{-- アラートメッセージ表示 --}}
                    var errorsHtml = '';
                    errorsHtml = '<div class="alert alert-danger text-left">';
                    errorsHtml += '<li class="text-left">' + ErrorMessage + '</li>';
                    errorsHtml += '</div>';

                        //{{-- アラート --}}
                    $('.ajax-msg').html(errorsHtml);
                    //{{-- 画面上部へ --}}
                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");
                    //{{-- ボタン有効 --}}
                    $('#SaveButton').prop("disabled", false);
                    //{{-- マウスカーソルを通常に --}}                    
                    document.body.style.cursor = 'auto';

                }

            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
                //{{-- アラートメッセージ表示 --}}
                let errorsHtml = '<div class="alert alert-danger text-left">';

                if (data.status == '422') {
                    //{{-- vlidationエラー --}}
                    $.each(data.responseJSON.errors, function (key, value) {
                        //{{-- responsからerrorsを取得しメッセージと赤枠を設定 --}}
                        errorsHtml += '<li  class="text-left">' + value[0] + '</li>';
                    
                        $("[name='" + key + "']").addClass('is-invalid');
                        
                        $("[name='" + key + "']").next('.invalid-feedback').text(value);
                    });

                } else {

                    //{{-- その他のエラー --}}
                    errorsHtml += '<li class="text-left">登録処理エラー</li>';

                }

                errorsHtml += '</div>';
                
                //{{-- アラート --}}
                $('.ajax-msg').html(errorsHtml);
                //{{-- 画面上部へ --}}
                $("html,body").animate({
                    scrollTop: 0
                }, "300");
                //{{-- ボタン有効 --}}
                $('#SaveButton').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';

            });

    });

});

</script>
@endsection

