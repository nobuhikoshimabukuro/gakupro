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
                <h4 class="master-title">
                    スタッフマスタ
                </h4>
            </div>    

            <div class="col-6 text-end">

                <button type="button" class='original-button'>
                    <a href="{{ route('master.index') }}">マスタ一覧へ</a>
                </button>
                
            </div>

            <div class="col-6 text-start">
                <button type="button" class='btn btn-success search-modal-button' data-bs-toggle='modal' data-bs-target='#search-modal'></button>
            </div>

            <div class="col-6 text-end">
                <button type="button" id="" class="btn btn-primary add-data-button"
                    data-bs-toggle='modal' data-bs-target='#save-modal'            
                    data-processflg='0'>
                </button>
            </div>      

    </div>


    <div class="m-0 text-start">
        {{-- ページャー --}}                
        @if(count($staff_list) > 0)                                
          <div class="m-0">{{ $staff_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="data-display-area" class="scroll-wrap-x m-0">
        <table id='' class='data-info-table'>
            
            <tr>
                <th>スタッフID</th>
                <th>氏名</th>                
                <th>TEL</th>                
                <th>権限</th>
                <th>備考</th>
               

                @if(session()->get('authority') > 1)
                    <th>件数【<span id='data-total-count'>{{count($staff_list)}}</span>件】</th>
                    <th>ログイン情報</th>                    
                    <th>プロジェクト情報</th>  
                @endif

                
                
            </tr>

            @foreach ($staff_list as $item)
            <tr>
                <td>{{$item->staff_id}}</td>
           
                <td>
                    <ruby>{{$item->staff_last_name . "　" . $item->staff_first_name}}
                        <rt>
                            {{$item->staff_last_name_yomi . "　".$item->staff_first_name_yomi}}
                        </rt>
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
                            
                            <button class='modal-button' data-bs-toggle='modal' data-bs-target='#remarks_modal'
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
                        <button class='modal-button' data-bs-toggle='modal' data-bs-target='#save-modal'
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
                                                   
                            data-processflg='1'> 
                            <i class='far fa-edit'></i>
                        </button>

                        <button class='modal-button' data-bs-toggle='modal' data-bs-target='#delete-modal'
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
                        <button class='modal-button' data-bs-toggle='modal' data-bs-target='#login_info_modal'
                            data-passwordid='{{$item->password_id}}'
                            data-staffid='{{$item->staff_id}}'
                            data-loginid='{{$item->login_id}}'
                            data-password='{{$item->password}}'
                            > 
                            <i class="fas fa-info"></i>
                        </button>
                    </td>


                    <td>
                        <button class='modal-button' data-bs-toggle='modal' data-bs-target='#project_info_modal'                            
                            data-staffid='{{$item->staff_id}}'                            
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
        <div class="modal fade" id="search-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="search-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="search-modal-label">検索</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    
                    <form id="search-form" class="" action="" method="get">
                        <div class="modal-body">                     
            
                            <div class="form-group row">

                                <label for="search_authority_cd" class="col-12 col-form-label original-label">権限選択</label>                                
                                <select id='search_authority_cd' name='search_authority_cd' class='form-control input-sm'>
                                    <option value=''>未選択</option>
                                        @foreach($authority_list as $item)
                                        <option value="{{$item->authority_cd}}"@if($search_element_array['search_authority_cd'] == $item->authority_cd) selected @endif>
                                            {{$item->authority_name}}
                                        </option>
                                        @endforeach
                                </select>


                                
                                
                                <label for="search_staff_name" class="col-12 col-form-label original-label">氏名（あいまい）</label>
                                <input type="text" id="search_staff_name" name="search_staff_name" value="{{$search_element_array['search_staff_name']}}" class="form-control">
                            
                                                                                            
                            
                            </div>     
                                                

                        </div>

                        <div class="modal-footer">         

                            <div class="col-6 m-0 p-0 text-start">
                                
                                <button type="button" id="" class="btn btn-dark clear-button"></button>
                                <button type="submit" id="" class="btn btn-success search-button"  onclick="return search_form_check();"><i class="fas fa-search"></i></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>
                            </div>                            
                        </div>
                    </form>

                </div>
            </div>
        </div>


        {{-- 登録/更新用モーダル --}}
        <div class="modal fade" id="save-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="save-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="save-modal-label"><span id="save-modal-title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg m-2">
                        
                    </div>
                    
                    
                    <form id="save-form" method="post" action="{{ route('master.staff.save') }}">                           
                        @csrf
                        <div class="modal-body">  
                                                        
                            <input type="hidden" name="staff_id" id="staff_id" value="">
                            <input type="hidden" name="processflg" id="processflg" value="">
                                                        
                           
                            <div class="form-group row">


                                <label for="staff_last_name" class="col-12 col-form-label original-label">氏名</label>
                                
                                <div class="col-5 p-0 last-name-class">
                                    <input type="text" name="staff_last_name" id="staff_last_name" value="" class="form-control col-md-3">
                                </div>
                              
                                <div class="col-5 m-0 p-0">
                                    <input type="text" name="staff_first_name" id="staff_first_name" value="" class="form-control col-md-3">
                                </div>


                                <label for="staff_last_name_yomi" class="col-12 col-form-label original-label">シメイ</label>
                                
                                <div class="col-5 p-0 last-name-class">
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

                        <div class="modal-footer">                            
                            <div class="col-6 m-0 p-0 text-start">
                                <button type="button" id='save-button' class="btn btn-primary save-button"></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>
                            </div>                            
                        </div> 

                    </form>

                </div>
            </div>
        </div>


        {{-- 削除用モーダル --}}
        <div class="modal fade" id="delete-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="delete-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="delete-modal-label">操作確認</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    
                    <form id="delete-form" method="post" action="{{ route('master.staff.delete_or_restore') }}">       
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

                        <div class="modal-footer">                                                                                      
                            <div class="col-6 m-0 p-0 text-start">
                                <button type="submit" id='delete-modal-execution-button' class="original-button delete-modal-execution-button"><span class="delete-modal_wording"></span></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>      
                            </div>                            
                        </div>    
                    </form>

                </div>
            </div>
        </div>

        {{-- 備考確認用モーダル --}}
        <div class="modal fade" id="remarks_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="remarks_modal-label" aria-hidden="true">
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
                        <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>
                    </div>
                </div>
            </div>
        </div>


        {{-- パスワード変更モーダル --}}
        <div class="modal fade" id="login_info_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="login_info_modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="login_info_modal-label">ログイン情報変更</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg login-info-msg m-2">
                        
                    </div>
                    
                    <form id="login_info_form" method="post" action="{{ route('master.staff.login_info_update') }}">                    
                        @csrf
                        <div class="modal-body">  
                                                       
                            
                            <input type="hidden" name="login_info_staff_id" id="login_info_staff_id" value="">
                            <input type="hidden" name="login_info_password_id" id="login_info_password_id" value="">
                            
                            <div class="form-group row">
    
                                <label for="login_id" class="col-md-6 col-form-label original-label">ログインID</label>
                                <input type="text" name="login_id" id="login_id" value="" class="form-control col-md-3">
    
                                <label for="password" class="col-md-6 col-form-label original-label">パスワード</label>
                                <input type="text" name="password" id="password" value="" class="form-control col-md-3">
                            </div>                                                 
                            
                        </div>

                        <div class="modal-footer">                            
                            <div class="col-8 m-0 p-0 text-start">                                
                                <button type="button" id="login_info_change_button" class="original-button login_info_change_button">ログイン情報変更</button>
                            </div>

                            <div class="col-4 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>
                            </div>                            
                        </div> 

                    </form>

                </div>
            </div>
        </div>


        {{-- プロジェクト変更モーダル --}}
        <div class="modal fade" id="project_info_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="project_info_modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="project_info_modal-label">プロジェクト変更</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg project_info_msg m-2">
                        
                    </div>
                    
                    <form id="project_info_form" method="post" action="{{ route('master.staff.project_info_update') }}">                    
                        @csrf
                        <div class="modal-body">  
                                                       
                            
                            <input type="hidden" name="project_info_staff_id" id="project_info_staff_id" value="">                            
                            
                            <div class="form-group row">
    
                                <table>
                                    @foreach($project_list as $item)
                                
                                    <tr>
                                        <td class="text-start">
                                            <label for="project_id_{{$item->project_id}}">{{$item->project_name}}</label>
                                        </td>

                                        <td>
                                            <input type="checkbox" id='project_id_{{$item->project_id}}' class="project_info_check_box" name="project_id_{{$item->project_id}}" value='1'>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>                               

                            </div>                                                 
                            
                        </div>

                        <div class="modal-footer">                            
                            <div class="col-8 m-0 p-0 text-start">                                
                                <button type="button" id="project_info_change_button" class="original-button login_info_change_button">プロジェクト情報変更</button>
                            </div>

                            <div class="col-4 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>
                            </div>                            
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
    $('.clear-button').click(function () {

        var FormData = $("#search-form").serializeArray();        

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
    $('#save-modal').on('show.bs.modal', function(e) {

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        var FormData = $("#save-form").serializeArray();        

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
        var processflg = evCon.data('processflg');
        if(processflg == '0'){
            $('#save-modal-title').html('登録処理');                          
            
            staff_id = 0;
        }else{
            $('#save-modal-title').html('更新処理');
            
        }
        
        $('#processflg').val(processflg);    
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
    $('#delete-modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var staff_id = evCon.data('staffid');        
        var staff_name = evCon.data('stafflastname') + "　" + evCon.data('stafffirstname');
        var delete_flg = evCon.data('deleteflg');

        $('#delete-modal-execution-button').removeClass('delete-button');
        $('#delete-modal-execution-button').removeClass('restore-button');        

        if (delete_flg == 0) {            
            var wording = "利用不可にする";                 
            $('#delete-modal-execution-button').addClass('delete-button');  

        } else {
            
            var wording = "利用可能にする";
            $('#delete-modal-execution-button').addClass('restore-button');  
        }
    
        
         
        $('#display_staff_id').html(staff_id);   
        $('#display_staff_name').html(staff_name);   
        $('.delete-modal_wording').html(wording);

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

        $('#login_info_password_id').val(password_id);
        $('#login_info_staff_id').val(staff_id);
        $('#login_id').val(login_id);  
        $('#password').val(password);  

    });


    //プロジェクトモーダル
    $('#project_info_modal').on('show.bs.modal',function(e){
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var staff_id = evCon.data('staffid');

        $('#project_info_staff_id').val(staff_id);

        project_info_get();

    });


    function project_info_get(){
       
        var staff_id = $('#project_info_staff_id').val();
       
        $(".project_info_check_box").removeAttr("checked").prop("checked", false).change();

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';       

        var Url = "{{ route('master.staff.project_info_get')}}"

        $.ajax({
            url: Url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {staff_id : staff_id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}

        })
            .done(function (data, textStatus, jqXHR) {
                // テーブルに通信できた場合
                var result_array = data.result_array;

                var status = result_array["status"];

                //テーブルに通信時、データを検索できたか判定
                if (status == 'success') {             


                var staff_with_project_list = result_array["staff_with_project_list"];

                $.each(staff_with_project_list, function(index, info) {

                    var project_id = info["project_id"];

                    var element_id = "#project_id_" + project_id;

                    $(element_id).attr("checked", true).prop("checked", true).change();

                })           


                }else{                            


                }

                //マウスカーソルを通常に
                document.body.style.cursor = 'auto';


            })
                .fail(function (data, textStatus, errorThrown) {

                    //マウスカーソルを通常に
                    document.body.style.cursor = 'auto';


                });


    } 


    // 「ログイン情報変更」ボタンがクリックされたら
    $('#login_info_change_button').click(function () {
     
        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.login-info-msg').html('');
        
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        var staff_id = $("#login_info_staff_id").val();
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
                
                var result_array = data.result_array;

                var Result = result_array["Result"];

                if(Result=='success'){

                    // ログイン情報変更処理開始
                    $('#login_info_form').submit();

                }else if(Result=='duplication_error'){

                    var login_id_duplication = result_array["login_id_duplication"];
                    var password_duplication = result_array["password_duplication"];

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


    // 「プロジェクト情報変更」ボタンがクリックされたら
    $('#project_info_change_button').click(function () {
     
        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $(this).prop("disabled", true);

        setTimeout(function () {
            $('#project_info_change_button').prop("disabled", false);
        }, 3000);

        //{{-- メッセージクリア --}}
        $('.project_info_msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        let f = $('#project_info_form');

        var Url = "{{ route('master.staff.project_info_update')}}"

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';

        $.ajax({
            url:Url, // 送信先
            type: f.prop('method'),
            dataType: 'json',
            data: f.serialize(),
        })
         // 送信成功
         .done(function (data, textStatus, jqXHR) {
             
             var result_array = data.result_array;

             var Result = result_array["Result"];

             if(Result=='success'){

                 location.reload();

             }else{

                var ErrorMessage = result_array["Message"];

                //{{-- アラートメッセージ表示 --}}
                var errorsHtml = '';
                errorsHtml = '<div class="alert alert-danger text-start">';
                errorsHtml += '<li class="text-start">' + ErrorMessage + '</li>';
                errorsHtml += '</div>';

                //{{-- アラート --}}
                $('.project_info_msg').html(errorsHtml);
                //{{-- 画面上部へ --}}
                $("html,body").animate({
                    scrollTop: 0
                }, "300");
                //{{-- ボタン有効 --}}
                $('#project_info_change_button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';

             }

         
         })

         // 送信失敗
         .fail(function (data, textStatus, errorThrown) {
             
            //{{-- アラートメッセージ表示 --}}
            var errorsHtml = '';
            errorsHtml = '<div class="alert alert-danger text-start">';
            errorsHtml += '<li class="text-start">更新失敗</li>';
            errorsHtml += '</div>';

            //{{-- アラート --}}
            $('.project_info_msg').html(errorsHtml);
            //{{-- 画面上部へ --}}
            $("html,body").animate({
                scrollTop: 0
            }, "300");
            //{{-- ボタン有効 --}}
            $('#project_info_change_button').prop("disabled", false);
            //{{-- マウスカーソルを通常に --}}                    
            document.body.style.cursor = 'auto';

         });

    });


    

    // 「保存」ボタンがクリックされたら
    $('#save-button').click(function () {
     
        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $(this).prop("disabled", true);

        setTimeout(function () {
            $('#save-button').prop("disabled", false);
        }, 3000);

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        let f = $('#save-form');

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
                
                var result_array = data.result_array;

                var Result = result_array["Result"];

                if(Result=='success'){

                    location.reload();

                }else{

                    var ErrorMessage = result_array["Message"];

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
                    $('#save-button').prop("disabled", false);
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
                $('#save-button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';

            });

        });

    });

</script>
@endsection

