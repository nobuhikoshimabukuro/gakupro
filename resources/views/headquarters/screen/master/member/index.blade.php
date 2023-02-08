@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'メンバー')  
@endsection
@section('content')

<div id="main" class="mt-3 text-center container">
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row">
        <div class="col-6 text-start">
            <h4 class="MasterTitle">
                メンバー
            </h4>
        </div>

        

        <div class="col-6 new_addition_button">
            <a href="" class="btn btn--red btn--radius btn--cubic" 
            data-bs-toggle='modal' data-bs-target='#save_modal'            
            data-processflg='0'
            ><i class='fas fa-plus-circle'></i><span class="new_addition_button_name"></span></a>
        </div>

    </div>

    <div class="m-0 text-start">
        {{-- ページャー --}}                
        @if(count($member_list) > 0)                                
          <div class="m-0">{{ $member_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="DataDisplayArea" class="table_wrap m-0">
        <table id='' class='data_info_table'>
            
            <tr>
                <th>メンバーID</th>
                <th>学校区分</th>
                <th>学校名</th>
                <th>専攻名</th>
                <th>氏名</th>
                <th>入学年月</th>
                <th>卒業予定年月</th>                
                <th>件数【<span id='total_count'>{{count($member_list)}}</span>件】</th>
                <th>ログイン情報</th>
                
            </tr>

            @foreach ($member_list as $item)
            <tr>
                <td>{{$item->member_id}}</td>
                <td>{{$item->school_division_name}}</td>                
                <td>{{$item->school_name}}</td>
                <td>{{$item->majorsubject_name}}</td> 
                <td>{{$item->member_name}}</td> 

                <td>{{$item->admission_yearmonth}}</td>
                <td>{{$item->graduation_yearmonth}}</td>

                <td>
                    <button class='modal_button' data-bs-toggle='modal' data-bs-target='#save_modal'
                        data-memberid='{{$item->member_id}}'
                        data-membername='{{$item->member_name}}'
                        data-membernameyomi='{{$item->member_name_yomi}}'
                        data-gender='{{$item->gender}}'
                        data-birthday='{{$item->birthday}}'
                        data-tel='{{$item->tel}}'
                        data-mailaddress='{{$item->mailaddress}}'
                        data-schoolcd='{{$item->school_cd}}'
                        data-majorsubjectcd='{{$item->majorsubject_cd}}'
                        data-admissionyearmonth='{{$item->admission_yearmonth}}'
                        data-graduationyearmonth='{{$item->graduation_yearmonth}}'
                        data-emergencycontactrelations='{{$item->emergencycontact_relations}}'
                        data-emergencycontacttel='{{$item->emergencycontact_tel}}'
                        data-remarks='{{$item->remarks}}'
                        data-registrationstatus='{{$item->registration_status}}'
                        data-processflg='1'> 
                        <i class='far fa-edit'></i>
                    </button>

                    <button class='modal_button' data-bs-toggle='modal' data-bs-target='#dlete_modal'
                        data-memberid='{{$item->member_id}}'
                        data-membername='{{$item->member_name}}'
                        data-membernameyomi='{{$item->member_name_yomi}}'
                        data-gender='{{$item->gender}}'
                        data-birthday='{{$item->birthday}}'
                        data-tel='{{$item->tel}}'
                        data-mailaddress='{{$item->mailaddress}}'
                        data-schoolcd='{{$item->school_cd}}'
                        data-majorsubjectcd='{{$item->majorsubject_cd}}'
                        data-admissionyearmonth='{{$item->admission_yearmonth}}'
                        data-graduationyearmonth='{{$item->graduation_yearmonth}}'
                        data-emergencycontactrelations='{{$item->emergencycontact_relations}}'
                        data-emergencycontacttel='{{$item->emergencycontact_tel}}'
                        data-remarks='{{$item->remarks}}'
                        data-registrationstatus='{{$item->registration_status}}'
                        data-deleteflg=@if($item->deleted_at) 1 @else 0 @endif>
                                    
                        @if($item->deleted_at)
                            <i class='far fa-thumbs-down'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-up'></i>
                        @else
                            <i class='far fa-thumbs-up'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-down'></i>
                        @endif
                    </button>             

                </td>

            
                <td>
                    <button class='modal_button' data-bs-toggle='modal' data-bs-target='#login_info_modal'                        
                        data-memberid='{{$item->member_id}}'
                        data-loginid='{{$item->login_id}}'
                        data-password='{{$item->password}}'
                        > 
                        <i class="fas fa-info"></i>
                    </button>
                </td>
                

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
                    
                    <form id="save_form" method="post" action="{{ route('master.member.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                                                        
                            <input type="hidden" name="member_id" id="member_id" value="">
                            <input type="hidden" name="processflg" id="processflg" value="">
                                                        
                           
                            <div class="form-group row">


                                <label for="member_name" class="col-md-6 col-form-label original-label">氏名</label>
                                <input type="text" name="member_name" id="member_name" value="" class="form-control col-md-3">
    
                                <label for="member_name_yomi" class="col-md-6 col-form-label original-label">シメイ</label>
                                <input type="text" name="member_name_yomi" id="member_name_yomi" value="" class="form-control col-md-3">
                                        
                                <label for="gender" class="col-md-6 col-form-label original-label">性別</label>                               
                                <select id='gender' name='gender' class='form-control input-sm'>									
										@foreach($gender_list as $item)
                                            <option value="{{$item->gender_cd}}">
                                                {{$item->gender_name}}
                                            </option>
										@endforeach
                                </select>

                                <label for="birthday" class="col-md-6 col-form-label original-label">生年月日</label>
                                <input type="date" name="birthday" id="birthday" value="" class="form-control col-md-3">

                                <label for="tel" class="col-md-6 col-form-label original-label">TEL</label>
                                <input type="tel" name="tel" id="tel" value="" class="form-control col-md-3">

                                <label for="mailaddress" class="col-md-6 col-form-label original-label">メールアドレス</label>
                                <input type="text" name="mailaddress" id="mailaddress" value="" class="form-control col-md-3">

                                <label for="school_cd" class="col-md-6 col-form-label original-label">学校選択</label>
                                <select id='school_cd' name='school_cd' class='form-control input-sm'>									
                                    <option value="">---</option>
                                    @foreach($school_list as $item)
                                    <option value="{{$item->school_cd}}">
                                        {{$item->school_name}}
                                    </option>
                                    @endforeach
                                </select>

                                <label for="majorsubject_cd" class="col-md-6 col-form-label original-label">専攻選択</label>
                                <select id='majorsubject_cd' name='majorsubject_cd' class='form-control input-sm impossible'>
                                    <option value="">---</option>
                                    @foreach($majorsubject_list as $item)
                                    <option value="{{$item->majorsubject_cd}}">
                                        {{$item->majorsubject_name}}
                                    </option>
                                    @endforeach
                                </select>

                                <label for="admission_yearmonth" class="col-md-6 col-form-label original-label">入学年月</label>
                                <input type="month" name="admission_yearmonth" id="admission_yearmonth" value="" class="form-control col-md-3">

                                <label for="graduation_yearmonth" class="col-md-6 col-form-label original-label">卒業予定年月</label>
                                <input type="month" name="graduation_yearmonth" id="graduation_yearmonth" value="" class="form-control col-md-3">

                                <label for="emergencycontact_relations" class="col-md-6 col-form-label original-label">緊急時連絡先</label>
                                <input type="text" name="emergencycontact_relations" id="emergencycontact_relations" value="" placeholder="両親、兄弟など" class="form-control col-md-3">

                                <label for="emergencycontact_tel" class="col-md-6 col-form-label original-label">緊急時連絡先電話番号</label>
                                <input type="text" name="emergencycontact_tel" id="emergencycontact_tel" value="" class="form-control col-md-3">

                                <label for="remarks" class="col-md-6 col-form-label original-label">備考</label>                                
                                <textarea name="remarks" id="remarks" class="form-control col-md-3" rows="4"></textarea>

                                                             
                            
                              </div>                                                 
                            
                        </div>

                        <div class="modal-footer">               
                            <button type="submit" id='save_button' class="btn btn-primary"><span id='save_modal_button_display'></span></button>       
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

                    
                    <form id="delete_form" method="post" action="{{ route('master.member.delete_or_restore') }}">       
                        @csrf
                        <div class="modal-body">

                            <input type="hidden" id="delete_flg" name="delete_flg" value="">
                            <input type="hidden" id="delete_member_id" name="delete_member_id" value="">                            
                            <input type="hidden" id="delete_member_name" name="delete_member_name" value="">
            
                            <table class="w-100">
                                
                                <tr>
                                    <td class="text-start">スタッフIDs</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_member_id"></span></td>
                                </tr>
                             
                                <tr>
                                    <td class="text-start">スタッフ名</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_member_name"></span></td>
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
        <div class="modal fade" id="login_info_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="login_info_modal_Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="login_info_modal_Label"><span id="login_info_modal_Title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg login-info-msg m-2">
                        
                    </div>
                    
                    <form id="login_info_form" method="post" action="{{ route('master.member.login_info_update') }}">                    
                        @csrf
                        <div class="modal-body">  
                                                       
                            
                            <input type="hidden" name="logininfo_member_id" id="logininfo_member_id" value="">
                            <input type="hidden" name="logininfo_password_id" id="logininfo_password_id" value="">
                            
                            <div class="form-group row">
    
                                <label for="login_id" class="col-md-6 col-form-label original-label">ログインID</label>
                                <input type="text" name="login_id" id="login_id" value="" class="form-control col-md-3">
    
                                <label for="password" class="col-md-6 col-form-label original-label">パスワード</label>
                                <input type="text" name="password" id="password" value="" class="form-control col-md-3">
                            </div>                                                 
                            
                        </div>

                        <div class="modal-footer">               
                            <button type="button" id='login_info_change_button' class="btn btn-primary">ログイン情報変更</button>       
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


    

    $('#school_cd').change(function() {
        majorsubject_search();
    });

    function majorsubject_list_remove(){
        $("select#majorsubject_cd option").remove();
    }

    function majorsubject_search(){
       
        

       

        var Url = "{{ route('master.member.majorsubject_search')}}"

        majorsubject_list_remove();
        var school_cd = $('#school_cd').val();

        $('#majorsubject_cd').removeClass("impossible");
        if(school_cd == ""){
            $('#majorsubject_cd').addClass("impossible");
            $("#majorsubject_cd").append($("<option>").val("").text("学校を選択してください。"));
            return false;
        }

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';

        $.ajax({
            url: Url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {school_cd : school_cd},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}

        })
        .done(function (data, textStatus, jqXHR) {
            // テーブルに通信できた場合
            var ResultArray = data.ResultArray;

            var status = ResultArray["status"];

            //テーブルに通信時、データを検索できたか判定
            if (status == 'success') {

                var majorsubject_list = ResultArray["majorsubject_list"];

                $.each(majorsubject_list, function(index, info) {

                    var majorsubject_cd = info["majorsubject_cd"];
                    var majorsubject_name = info["majorsubject_name"];
                
                    $("#majorsubject_cd").append($("<option>").val(majorsubject_cd).text(majorsubject_name));

                })

                $('#majorsubject_cd').removeClass("impossible");
                $('#majorsubject_cd').focus();

            }else if(status == 'nodata'){
                        
                $("#majorsubject_cd").append($("<option>").val('').text('専攻情報なし'));

            }else{
         


            }

            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';

        })
            .fail(function (data, textStatus, errorThrown) {
            

            });


    }

    //登録、更新用モーダル表示時
    $('#save_modal').on('show.bs.modal', function(e) {

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');
        
        var FormData = $("#save_form").serializeArray();        

        $.each(FormData, function(i, element) {		
            $("[name='"+ element.name +"']").val("");          
        });
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var member_id = evCon.data('memberid');
        var member_name = evCon.data('membername');
        var member_name_yomi = evCon.data('membernameyomi');
        var gender = evCon.data('gender');
        var birthday = evCon.data('birthday');
        var tel = evCon.data('tel');
        var mailaddress = evCon.data('mailaddress');
        var school_cd = evCon.data('schoolcd');
        var majorsubject_cd = evCon.data('majorsubjectcd');
        var admission_yearmonth = evCon.data('admissionyearmonth');
        var graduation_yearmonth = evCon.data('graduationyearmonth');
        var emergencycontact_relations = evCon.data('emergencycontactrelations');
        var emergencycontact_tel = evCon.data('emergencycontacttel');
        var remarks = evCon.data('remarks');
        


        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');

        if(processflg == '0'){
            $('#save_modal_title').html('登録処理');                     
            $('#save_modal_button_display').html('登録');
            member_id = 0;        
        }else{            
            $('#save_modal_title').html('更新処理');                         
            $('#save_modal_button_display').html('更新');            
        }
             
        $('#processflg').val(processflg);    
        $('#member_id').val(member_id);
        $('#member_name').val(member_name);
        $('#member_name_yomi').val(member_name_yomi);
        $('#gender').val(gender);
        $('#birthday').val(birthday);
        $('#tel').val(tel);
        $('#mailaddress').val(mailaddress);
        $('#school_cd').val(school_cd);
        $('#majorsubject_cd').val(majorsubject_cd);
        $('#admission_yearmonth').val(admission_yearmonth);
        $('#graduation_yearmonth').val(graduation_yearmonth);
        $('#emergencycontact_relations').val(emergencycontact_relations);
        $('#emergencycontact_tel').val(emergencycontact_tel);
        $('#remarks').val(remarks);
               
      
        majorsubject_search();
      

    });


    //削除モーダル表示時
    $('#dlete_modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var member_id = evCon.data('memberid');        
        var member_name = evCon.data('membername');    
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
    
        
         
        $('#display_member_id').html(member_id);   
        $('#display_member_name').html(member_name);   
        $('.dlete_modal_wording').html(wording);

        $('#delete_flg').val(delete_flg);
        $('#delete_member_id').val(member_id);        
        $('#delete_member_name').val(member_name);  

    });



    //ログイン情報変更モーダル表示時
    $('#login_info_modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);
        
        var password_id = evCon.data('passwordid');
        var member_id = evCon.data('memberid');
        var login_id = evCon.data('loginid');    
        var password = evCon.data('password');

        $('#logininfo_password_id').val(password_id);
        $('#logininfo_member_id').val(member_id);
        $('#login_id').val(login_id);  
        $('#password').val(password);  

    });



    // 「ログイン情報変更」ボタンがクリックされたら
    $('#login_info_change_button').click(function () {
     
        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.login-info-msg').html('');
        
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        var member_id = $("#logininfo_member_id").val();
        var login_id = $("#login_id").val();
        var password = $("#password").val();
        var Judge = true;

        if(password == ""){
            $('#password').focus();
            Judge = false;
            $("#password").addClass("is-invalid");            
        }

        if(login_id == ""){
            $('#login_id').focus();
            Judge = false;
            $("#login_id").addClass("is-invalid");                              
        }

        if(!Judge){
            return false;
        }

        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $(this).prop("disabled", true);

        setTimeout(function () {
            $('#login_info_change_button').prop("disabled", false);
        }, 3000);

        var Url = "{{ route('master.member.login_info_check')}}"

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';

        $.ajax({
            url: Url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {member_id : member_id , login_id : login_id , password : password},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}

        })
            // 送信成功
            .done(function (data, textStatus, jqXHR) {
                
                var ResultArray = data.ResultArray;

                var Result = ResultArray["Result"];

                if(Result=='success'){

                    // ログイン情報変更処理開始
                    $('#login_info_form').submit();

                }else if(Result=='duplication_error'){

                    var login_id_duplication = ResultArray["login_id_duplication"];
                    var password_duplication = ResultArray["password_duplication"];

                    //{{-- アラートメッセージ表示 --}}
                    var errorsHtml = '';
                    errorsHtml = '<div class="alert alert-danger text-start">';

                    if(login_id_duplication != ""){                                                
                        $("#login_id").addClass("is-invalid");      
                        errorsHtml += '<li class="text-start">' + login_id_duplication + '</li>';
                    }

                    if(password_duplication != ""){
                        $("#password").addClass("is-invalid");      
                        errorsHtml += '<li class="text-start">' + password_duplication + '</li>';
                    }

                    
                    errorsHtml += '</div>';

                        //{{-- アラート --}}
                    $('.login-info-msg').html(errorsHtml);
                 
                    //{{-- ボタン有効 --}}
                    $('#login_info_change_button').prop("disabled", false);
                    //{{-- マウスカーソルを通常に --}}                    
                    document.body.style.cursor = 'auto';


                }else{

                    //{{-- アラートメッセージ表示 --}}
                    var errorsHtml = '';
                    errorsHtml = '<div class="alert alert-danger text-start">';
                    errorsHtml += '<li class="text-start">ログイン情報重複エラー</li>';
                    
                    errorsHtml += '</div>';

                        //{{-- アラート --}}
                    $('.login-info-msg').html(errorsHtml);
                 
                    //{{-- ボタン有効 --}}
                    $('#login_info_change_button').prop("disabled", false);
                    //{{-- マウスカーソルを通常に --}}                    
                    document.body.style.cursor = 'auto';

                    

                }

            
            })
            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
                //{{-- アラートメッセージ表示 --}}
                var errorsHtml = '';
                errorsHtml = '<div class="alert alert-danger text-start">';
                errorsHtml += '<li class="text-start">ログイン情報重複エラー</li>';
                
                errorsHtml += '</div>';

                    //{{-- アラート --}}
                $('.login-info-msg').html(errorsHtml);
                
                //{{-- ボタン有効 --}}
                $('#login_info_change_button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';                

            });

    });



    // 「保存」ボタンがクリックされたら
    $('#save_button').click(function () {
     
        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $(this).prop("disabled", true);

        setTimeout(function () {
            $('#save_button').prop("disabled", false);
        }, 3000);

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        let f = $('#save_form');

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
                    $('#save_button').prop("disabled", false);
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
                $('#save_button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';

            });

    });

});

</script>
@endsection

