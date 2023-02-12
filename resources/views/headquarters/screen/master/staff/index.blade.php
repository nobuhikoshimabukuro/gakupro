@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'スタッフマスタ')  
@endsection
@section('content')

<div id="main" class="mt-3 text-center container">
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row">

        <div class="col-6 text-start">
            <h4 class="master_title">
                スタッフマスタ
            </h4>
        </div>       
        
        <div class="col-6 text-end">

            <button type="button" class='original_button search_modal_button' data-bs-toggle='modal' data-bs-target='#search_modal'>検索する</button>

            <button type="button" id="" class="original_button add_data_button"
                data-bs-toggle='modal' data-bs-target='#save_modal'            
                data-process_flg='0'><span class="add_data_button_name"></span>
            </button>
        </div>

    </div>

    {{-- <form id="search_form" class="row" action="" method="get">

        <div class="col-12">
    
            <div id="search_form_area" class="table_wrap m-0 p-0">
                <table id='' class='search_info_table'>
                    <tr>                
                        <th>権限選択</th>
                        <th>氏名</th>                    
                        <th>
                            <a id="" class="original_button clear_button">クリア</a>  
                        </th>                    
                    </tr>

                    <tr>              
                        <td>
                            <select id='' name='search_authority_cd' class='form-control input-sm'>
                                <option value=''>未選択</option>
                                    @foreach($authority_list as $item)
                                    <option value="{{$item->authority_cd}}"@if($search_element_array['search_authority_cd'] == $item->authority_cd) selected @endif>
                                        {{$item->authority_name}}
                                    </option>
                                    @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" id="" name="search_staff_name" value="{{$search_element_array['search_staff_name']}}" class="form-control">
                        </td>                
                        
                        <td>                         
                            <button type="submit" id="" class="original_button search_button" onclick="return search_formCheck();">検索 <i class="fas fa-search"></i></button>                                                                                              
                        </td>
                    </tr>

                </table>
            </div>
        
        </div>
             
    </form> --}}

    <div class="m-0 text-start">
        {{-- ページャー --}}                
        @if(count($staff_list) > 0)                                
          <div class="m-0">{{ $staff_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="data_display_area" class="table_wrap m-0">
        <table id='' class='data_info_table'>
            
            <tr>
                <th>スタッフID</th>
                <th>氏名</th>                
                <th>TEL</th>                
                <th>権限</th>
                <th>備考</th>
               

                @if(session()->get('authority') > 1)
                    <th>件数【<span id='total_count'>{{count($staff_list)}}</span>件】</th>
                    <th>ログイン情報</th>
                @endif
            </tr>

            @foreach ($staff_list as $item)
            <tr>
                <td>{{$item->staff_id}}</td>
                <td>
                    <ruby>{{$item->staff_last_name}}　{{$item->staff_first_name}}
                        <rt>{{$item->staff_last_name_yomi}}　{{$item->staff_first_name_yomi}}</rt>
                      </ruby>
                    
                </td>
                <td>{{$item->tel}}</td>
                <td>{{$item->authority_name}}</td>

                @php
                    // 表示する最大文字数
                    $LimitStr = 4;
                    $remarks_button_name = "";

                    // ボタン表示フラグ
                    $remarks_button_flg = true;

                    if(!is_null($item->remarks)){

                        // 申込情報備考文字数取得
                        $string_count = mb_strlen($item->remarks);

                        if($string_count > $LimitStr){
                            // 最大文字数に達している場合、"$申込情報備考（指定した文字数）..."と表示
                            $remarks_button_name =  mb_substr($item->remarks, 0 , $LimitStr);
                            $remarks_button_name =  $remarks_button_name . "...";


                        }else if($string_count <= $LimitStr){
                            
                            $remarks_button_name = $item->remarks;
                        }

                    }else{

                        // 申込情報備考が登録されていない場合
                        $remarks_button_flg = false;

                    }

                @endphp

                    <td>
                        @if($remarks_button_flg)  
                            
                            <button class='modal_button' data-bs-toggle='modal' data-bs-target='#remarks_modal'
                            data-staffid="{{$item->staff_id}}"
                            data-stafflastname='{{$item->staff_last_name}}'
                            data-stafffirstname='{{$item->staff_first_name}}'
                            data-stafflastnameyomi='{{$item->staff_last_name_yomi}}'
                            data-stafffirstnameyomi='{{$item->staff_first_name_yomi}}'
                            data-remarks="{{$item->remarks}}"											
                            >{{$remarks_button_name}}                  
                    
                        @endif                  

                    </td>
                                

                @if(session()->get('authority') > 1)

                    <td>
                        <button class='modal_button' data-bs-toggle='modal' data-bs-target='#save_modal'
                            data-staffid='{{$item->staff_id}}'
                            data-stafflastname='{{$item->staff_last_name}}'
                            data-stafffirstname='{{$item->staff_first_name}}'
                            data-stafflastnameyomi='{{$item->staff_last_name_yomi}}'
                            data-stafffirstnameyomi='{{$item->staff_first_name_yomi}}'
                            data-nickname='{{$item->nick_name}}'
                            data-gender='{{$item->gender}}'
                            data-tel='{{$item->tel}}'
                            data-authority='{{$item->authority}}' 
                            data-remarks='{{$item->remarks}}' 
                                                   
                            data-process_flg='1'> 
                            <i class='far fa-edit'></i>
                        </button>

                        <button class='modal_button' data-bs-toggle='modal' data-bs-target='#dlete_modal'
                            data-staffid='{{$item->staff_id}}'
                            data-stafflastname='{{$item->staff_last_name}}'
                            data-stafffirstname='{{$item->staff_first_name}}'
                            data-stafflastnameyomi='{{$item->staff_last_name_yomi}}'
                            data-stafffirstnameyomi='{{$item->staff_first_name_yomi}}'
                            data-nickname='{{$item->nick_name}}'
                            data-gender='{{$item->gender}}'
                            data-tel='{{$item->tel}}'
                            data-authority='{{$item->authority}}'  
                            data-remarks='{{$item->remarks}}' 
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


    {{-- 検索モーダル --}}
    <div class="modal fade" id="search_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="search_modal_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="search_modal_label">検索</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                
                <form id="search_form" class="" action="" method="get">
                    <div class="modal-body">                     
        
                        <div class="form-group row">

                            <label for="search_authority_cd" class="col-12 col-form-label original-label">権限選択</label>                                
                           <select id='' name='search_authority_cd' class='form-control input-sm'>
                                <option value=''>未選択</option>
                                    @foreach($authority_list as $item)
                                    <option value="{{$item->authority_cd}}"@if($search_element_array['search_authority_cd'] == $item->authority_cd) selected @endif>
                                        {{$item->authority_name}}
                                    </option>
                                    @endforeach
                            </select>


                            
                            
                            <label for="member_last_name_yomi" class="col-12 col-form-label original-label">氏名（あいまい）</label>
                            <input type="text" id="" name="search_staff_name" value="{{$search_element_array['search_staff_name']}}" class="form-control">
                        
                                                                                        
                        
                        </div>     
                                             

                    </div>

                    <div class="modal-footer row">         

                        <div class="col-6 m-0 p-0 text-start">
                            
                            <button type="button" id="" class="original_button clear_button">クリア</button>
                            <button type="submit" id="" class="original_button search_button" onclick="return search_formCheck();">検索 <i class="fas fa-search"></i></button>
                        </div>

                        <div class="col-6 m-0 p-0 text-end">
                            <button type="button" id="" class="original_button close_modal_button" data-bs-dismiss="modal">閉じる</button>
                        </div>                            
                    </div>
                </form>

            </div>
        </div>
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
                    
                    
                    <form id="save_form" method="post" action="{{ route('master.staff.save') }}">                           
                        @csrf
                        <div class="modal-body">  
                                                        
                            <input type="hidden" name="staff_id" id="staff_id" value="">
                            <input type="hidden" name="process_flg" id="process_flg" value="">
                                                        
                           
                            <div class="form-group row">


                                <label for="staff_last_name" class="col-12 col-form-label original-label">氏名</label>
                                
                                <div class="col-5 p-0 last_name_class">
                                    <input type="text" name="staff_last_name" id="staff_last_name" value="" class="form-control col-md-3">
                                </div>
                              
                                <div class="col-5 m-0 p-0">
                                    <input type="text" name="staff_first_name" id="staff_first_name" value="" class="form-control col-md-3">
                                </div>


                                <label for="staff_last_name_yomi" class="col-12 col-form-label original-label">シメイ</label>
                                
                                <div class="col-5 p-0 last_name_class">
                                    <input type="text" name="staff_last_name_yomi" id="staff_last_name_yomi" value="" class="form-control col-md-3 last_name">
                                </div>
                                <div class="col-5 m-0 p-0">
                                    <input type="text" name="staff_first_name_yomi" id="staff_first_name_yomi" value="" class="form-control col-md-3 first_name">
                                </div>                                
                               
    
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

                                <label for="remarks" class="col-md-6 col-form-label original-label">備考</label>                                
                                <textarea name="remarks" id="remarks" class="form-control col-md-3" rows="4"></textarea>

                              </div>                                                 
                            
                        </div>

                        <div class="modal-footer row">
                            <div class="col-4 m-0 p-0 text-start">                                
                            </div>
                            <div class="col-4 m-0 p-0 text-center">
                                <button type="button" id='save_button' class="original_button save_button"><span id='save_modal_button_display'></span></button>
                            </div>

                            <div class="col-4 m-0 p-0 text-end">
                                <button type="button" id="" class="original_button close_modal_button" data-bs-dismiss="modal">閉じる</button>
                            </div>                            
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

                    
                    <form id="delete_form" method="post" action="{{ route('master.staff.delete_or_restore') }}">       
                        @csrf
                        <div class="modal-body">

                            <input type="hidden" id="delete_flg" name="delete_flg" value="">
                            <input type="hidden" id="delete_staff_id" name="delete_staff_id" value="">                            
                            <input type="hidden" id="delete_staff_name" name="delete_staff_name" value="">
            
                            <table class="w-100">
                                
                                <tr>
                                    <td class="text-start">スタッフID</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_staff_id"></span></td>
                                </tr>
                             
                                <tr>
                                    <td class="text-start">スタッフ名</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_staff_name"></span></td>
                                </tr>

                            </table>                            

                        </div>

                        <div class="modal-footer row">
                            <div class="col-4 m-0 p-0 text-start">                                
                            </div>
                            <div class="col-4 m-0 p-0 text-center">
                                <button type="submit" id='dlete_modal_runbutton' class="original_button dlete_modal_runbutton"><span class="dlete_modal_wording"></span></button>
                            </div>

                            <div class="col-4 m-0 p-0 text-end">
                                <button type="button" id="" class="original_button close_modal_button" data-bs-dismiss="modal">閉じる</button>      
                            </div>                            
                        </div>        
                    </form>

                </div>
            </div>
        </div>

        {{-- 備考確認用モーダル --}}
        <div class="modal fade" id="remarks_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="remarks_modal_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

	                  <div class="modal-header">
                        <h5 class="modal-title" id=""><span id="remarks_modal_title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                   
                    <div class="modal-body">                                                          
                        <textarea id="remarks_modal_remarks" class="form-control" rows="4" cols="40" readonly></textarea>
                    </div>

                    <div class="modal-footer">               
                        <button type="button" id="" class="original_button close_modal_button" data-bs-dismiss="modal">閉じる</button>
                    </div>
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
                    
                    <form id="login_info_form" method="post" action="{{ route('master.staff.login_info_update') }}">                    
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
                            <button type="button" id='login_info_change_button' class="btn btn-primary">ログイン情報変更</button>       
                            <button type="button" id="" class="original_button close_modal_button" data-bs-dismiss="modal">閉じる</button>
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
    
    // 「クリア」ボタンがクリックされたら
    $('.clear_button').click(function () {

        var FormData = $("#search_form").serializeArray();        

        $.each(FormData, function(i, element) {		
            $("[name='"+ element.name +"']").val("");          
        });

    });

     //備考モーダル
     $('#remarks_modal').on('show.bs.modal',function(e){
        // イベント発生元
        let evCon = $(e.relatedTarget);

        let staff_name = evCon.data('stafflastname') + "　" + evCon.data('stafffirstname');
        let remarks = evCon.data('remarks');

        var title = staff_name + "さんの備考"
        $('#remarks_modal_title').html(title);
        $('#remarks_modal_remarks').val(remarks);
        
    });


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

        var staff_id = evCon.data('staffid');
        var staff_last_name = evCon.data('stafflastname');
        var staff_first_name = evCon.data('stafffirstname');
        var staff_last_name_yomi = evCon.data('stafflastnameyomi');
        var staff_first_name_yomi = evCon.data('stafffirstnameyomi');
        var gender = evCon.data('gender');
        var nick_name = evCon.data('nickname');
        var tel = evCon.data('tel');
        var mailaddress = evCon.data('mailaddress');
        var authority = evCon.data('authority');
        var remarks = evCon.data('remarks');

        
        //登録処理か更新処理か判断
        var process_flg = evCon.data('process_flg');
        if(process_flg == '0'){
            $('#save_modal_title').html('登録処理');                          
            $('#save_modal_button_display').html('登録');
            staff_id = 0;
        }else{
            $('#save_modal_title').html('更新処理');
            $('#save_modal_button_display').html('更新');
        }
        
        $('#process_flg').val(process_flg);    
        $('#staff_id').val(staff_id);
        $('#staff_last_name').val(staff_last_name);
        $('#staff_first_name').val(staff_first_name);
        $('#staff_last_name_yomi').val(staff_last_name_yomi);
        $('#staff_first_name_yomi').val(staff_first_name_yomi);
        $('#nick_name').val(nick_name);
        $('#gender').val(gender);
        $('#tel').val(tel);
        $('#mailaddress').val(mailaddress);
        $('#authority').val(authority);                
        $('#remarks').val(remarks);                
        
    });


    //削除モーダル表示時
    $('#dlete_modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var staff_id = evCon.data('staffid');        
        var staff_name = evCon.data('stafflastname') + "　" + evCon.data('stafffirstname');
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

        $('#delete_flg').val(delete_flg);
        $('#delete_staff_id').val(staff_id);        
        $('#delete_staff_name').val(staff_name);  

    });



    //ログイン情報変更モーダル表示時
    $('#login_info_modal').on('show.bs.modal', function(e) {
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



    // 「ログイン情報変更」ボタンがクリックされたら
    $('#login_info_change_button').click(function () {
     
        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.login-info-msg').html('');
        
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        var staff_id = $("#logininfo_staff_id").val();
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

        var Url = "{{ route('master.staff.login_info_check')}}"

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';

        $.ajax({
            url: Url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {staff_id : staff_id , login_id : login_id , password : password},
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

