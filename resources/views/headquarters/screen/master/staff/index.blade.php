@extends('headquarters.common.layouts_beforelogin')

@section('pagehead')
@section('title', 'スタッフマスタ')  
@endsection
@section('content')

<div id="Main" class="mt-3 text-center container">
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row">
        <div class="col-6 text-start">
            <h4 class="MasterTitle">
                スタッフマスタ
            </h4>
        </div>

        

        <div class="col-6 NewAddition-Button">
            <a href="" class="btn btn--red btn--radius btn--cubic" 
            data-bs-toggle='modal' data-bs-target='#save_modal'            
            data-processflg='0'
            ><i class='fas fa-plus-circle'></i><span class="NewAddition-ButtonName"></span></a>
        </div>

    </div>

    <div class="m-0 text-start">
        {{-- ページャー --}}                
        @if(count($staff_list) > 0)                                
          <div class="m-0">{{ $staff_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="DataDisplayArea" class="Table-Wrap m-0">
        <table id='' class='DataInfoTable'>
            
            <tr>
                <th>スタッフID</th>
                <th>氏名</th>                
                <th>TEL</th>                
                <th>権限</th>
               

                @if($operator_authority > 1)
                    <th>件数【<span id='TotalCount'>{{count($staff_list)}}</span>件】</th>
                    <th>ログイン情報</th>
                @endif
            </tr>

            @foreach ($staff_list as $item)
            <tr>
                <td>{{$item->staff_id}}</td>
                <td>{{$item->staff_name}}</td>                
                <td>{{$item->tel}}</td>
                <td>{{$item->authority_name}}</td>
               

                @if($operator_authority > 1)

                    <td>
                        <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#save_modal'
                            data-staffid='{{$item->staff_id}}'
                            data-staffname='{{$item->staff_name}}'
                            data-staffnameyomi='{{$item->staff_name_yomi}}'
                            data-nickname='{{$item->nick_name}}'
                            data-gender='{{$item->gender}}'
                            data-tel='{{$item->tel}}'
                            data-authority='{{$item->authority}}'                        
                            data-processflg='1'> 
                            <i class='far fa-edit'></i>
                        </button>

                        <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#dlete_modal'
                            data-staffid='{{$item->staff_id}}'
                            data-staffname='{{$item->staff_name}}'
                            data-staffnameyomi='{{$item->staff_name_yomi}}'
                            data-nickname='{{$item->nick_name}}'
                            data-gender='{{$item->gender}}'
                            data-tel='{{$item->tel}}'
                            data-authority='{{$item->authority}}'  
                            data-deleteflg=@if($item->deleted_at) 1 @else 0 @endif>
                                        
                            @if($item->deleted_at)
                                <i class='far fa-thumbs-down'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-up'></i>
                            @else
                                <i class='far fa-thumbs-up'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-down'></i>
                            @endif
                        </button>             

                    </td>

                
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
    </div>



        {{-- 登録/更新用モーダル --}}
        <div class="modal fade" id="save_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="save_modal_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="save_modal_label"><span id="save_modal_title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg m-2">
                        
                    </div>
                    
                    <form id="SaveForm" method="post" action="{{ route('master.staff.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                                                        
                            <input type="hidden" name="staff_id" id="staff_id" value="">                            
                                                        
                           
                            <div class="form-group row">


                                <label for="staff_name" class="col-md-6 col-form-label original-label">氏名</label>
                                <input type="text" name="staff_name" id="staff_name" value="" class="form-control col-md-3">
    
                                <label for="staff_name_yomi" class="col-md-6 col-form-label original-label">シメイ</label>
                                <input type="text" name="staff_name_yomi" id="staff_name_yomi" value="" class="form-control col-md-3">
    
                                <label for="nick_name" class="col-md-6 col-form-label original-label">ニックネーム</label>
                                <input type="text" name="nick_name" id="nick_name" value="" class="form-control col-md-3">
    
                                <label for="gender" class="col-md-6 col-form-label original-label">性別</label>                               
                                <select id='gender' name='gender' class='form-control input-sm'>									
										@foreach($gender_list as $item)
										<option value="{{$item->gender_cd}}">
                                            {{$item->gender_name}}
                                        </option>
										@endforeach
                                </select>

                                <label for="tel" class="col-md-6 col-form-label original-label">TEL</label>
                                <input type="tel" name="tel" id="tel" value="" class="form-control col-md-3">

                                <label for="mailaddress" class="col-md-6 col-form-label original-label">メールアドレス</label>
                                <input type="text" name="mailaddress" id="mailaddress" value="" class="form-control col-md-3">

                                <label for="authority" class="col-md-6 col-form-label original-label">権限</label>                               
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
                            <button type="submit" id='SaveButton' class="btn btn-primary"><span id='save_modal_button_display'></span></button>       
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        {{-- 削除用モーダル --}}
        <div class="modal fade" id="dlete_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="dlete_modal_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="dlete_modal_label">操作確認</h5>
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
                                    <td class="dlete_modal_table-value"><span id="display_staff_id"></span></td>                                                                       
                                </tr>

                                <tr>
                                    <td class="dlete_modal_table-column">スタッフ名：</td> 
                                    <td class="dlete_modal_table-value"><span id="display_staff_name"></span></td>                                                                       
                                </tr>

                            </table>                            

                        </div>

                        <div class="modal-footer">         
                            
                            <div class="row">

                                <div class="col-12 tect-right"> 
                                    <button type="submit" id='dlete_modal_runbutton' class="btn btn-primary"><span class="dlete_modal_wording"></span></button>       
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
    
                                <label for="login_id" class="col-md-6 col-form-label original-label">ログインID</label>
                                <input type="text" name="login_id" id="login_id" value="" class="form-control col-md-3">
    
                                <label for="password" class="col-md-6 col-form-label original-label">パスワード</label>
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

<script type="text/javascript">

$(function(){

    //登録、更新用モーダル表示時
    $('#save_modal').on('show.bs.modal', function(e) {

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        $('#staff_id').val('');        
        $('#staff_name').val('');
        $('#staff_name_yomi').val('');
        $('#nick_name').val('');
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
        var nick_name = evCon.data('nickname');
        var tel = evCon.data('tel');
        var mailaddress = evCon.data('mailaddress');
        var authority = evCon.data('authority');


        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');
        if(processflg == '0'){
            $('#save_modal_title').html('登録処理');         
            $('#staff_id').val(0);            
            $('#save_modal_button_display').html('登録');
        }else{
            $('#save_modal_title').html('更新処理');   
            $('#staff_id').val(staff_id);            
            $('#save_modal_button_display').html('更新');
        }
             
        $('#staff_id').val(staff_id);
        $('#staff_name').val(staff_name);
        $('#staff_name_yomi').val(staff_name_yomi);
        $('#nick_name').val(nick_name);
        $('#gender').val(gender);
        $('#tel').val(tel);
        $('#mailaddress').val(mailaddress);
        $('#authority').val(authority);                
    });


    //削除モーダル表示時
    $('#dlete_modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var staff_id = evCon.data('staffid');        
        var staff_name = evCon.data('staffname');    
        var delete_flg = evCon.data('deleteflg');

        $('#dlete_modal_runbutton').removeClass('delete_button');
        $('#dlete_modal_runbutton').removeClass('restore_button');        

        if (delete_flg == 0) {            
            var wording = "利用不可にする";                 
            $('#dlete_modal_runbutton').addClass('delete_button');  

        } else {
            
            var wording = "利用可能にする";
            $('#dlete_modal_runbutton').addClass('restore_button');  
        }
    
        
         
        $('#display_staff_id').html(staff_id);   
        $('#display_staff_name').html(staff_name);   
        $('.dlete_modal_wording').html(wording);


        $('#delete_staff_id').val(staff_id);        
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
                    errorsHtml = '<div class="alert alert-danger text-start">';
                    errorsHtml += '<li class="text-start">' + ErrorMessage + '</li>';
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
                let errorsHtml = '<div class="alert alert-danger text-start">';

                if (data.status == '422') {
                    //{{-- vlidationエラー --}}
                    $.each(data.responseJSON.errors, function (key, value) {
                        //{{-- responsからerrorsを取得しメッセージと赤枠を設定 --}}
                        errorsHtml += '<li  class="text-start">' + value[0] + '</li>';
                    
                        $("[name='" + key + "']").addClass('is-invalid');
                        
                        $("[name='" + key + "']").next('.invalid-feedback').text(value);
                    });

                } else {

                    //{{-- その他のエラー --}}
                    errorsHtml += '<li class="text-start">登録処理エラー</li>';

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

