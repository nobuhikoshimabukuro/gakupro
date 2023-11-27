@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'メンバーマスタ')  
@endsection
@section('content')

<div id="main" class="mt-3 text-center container">
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row m-0 p-0">

        <div class="col-6 text-start">
            <h4 class="master-title">
                メンバーマスタ
            </h4>
        </div>    

        <div class="col-6 text-end">

            <button type="button" class='btn btn-link'>
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
        @if(count($member_list) > 0)                                
          <div class="m-0">{{ $member_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="data-display-area" class="scroll-wrap-x m-0">
        <table id='' class='data-info-table'>
            
            <tr>
                <th>メンバーID</th>
                <th>氏名</th>
                <th>学校区分</th>
                <th>学校名</th>
                <th>専攻名</th>                
                <th>入学年月</th>
                <th>卒業予定年月</th>                
                <th>件数【<span id='data-total-count'>{{count($member_list)}}</span>件】</th>
                <th>ログイン情報</th>
                
            </tr>

            @foreach ($member_list as $item)
            <tr>
                <td>{{$item->member_id}}</td>
                <td>
                    <ruby>{{$item->member_last_name . "　" . $item->member_first_name}}
                        <rt>
                            {{$item->member_last_name_yomi . "　".$item->member_first_name_yomi}}
                        </rt>
                      </ruby>
                    
                </td>
                
                <td>{{$item->school_division_name}}</td>

                <td class="text-start">
                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#school_info_modal'                        
                        data-schoolcd='{{$item->school_cd}}'                        
                    >{{$item->school_name}}
                    </button>
                </td>

                <td>                    
                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#majorsubject_info_modal'                        
                        data-schoolcd='{{$item->school_cd}}'                        
                        data-majorsubjectcd='{{$item->majorsubject_cd}}'
                    >{{$item->majorsubject_name}}
                    </button>
                </td> 
               

                <td>{{$item->admission_yearmonth}}</td>
                <td>{{$item->graduation_yearmonth}}</td>

                <td>
                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#save-modal'
                        data-memberid='{{$item->member_id}}'                        
                        data-memberlastname='{{$item->member_last_name}}'
                        data-memberfirstname='{{$item->member_first_name}}'
                        data-memberlastnameyomi='{{$item->member_last_name_yomi}}'
                        data-memberfirstnameyomi='{{$item->member_first_name_yomi}}'
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

                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#delete-modal'
                        data-memberid='{{$item->member_id}}'                        
                        data-memberlastname='{{$item->member_last_name}}'
                        data-memberfirstname='{{$item->member_first_name}}'
                        data-memberlastnameyomi='{{$item->member_last_name_yomi}}'
                        data-memberfirstnameyomi='{{$item->member_first_name_yomi}}'
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
                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#login-info-modal'                        
                        data-memberid='{{$item->member_id}}'
                        data-mailaddress='{{$item->mailaddress}}'
                        data-password='{{$item->password}}'
                        > 
                        <i class="fas fa-info"></i>
                    </button>
                </td>
                

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

                                <label for="search_school_division" class="col-12 col-form-label original-label">学校区分選択</label>                                
                                <select id='search_school_division' name='search_school_division' class='form-control input-sm'>
                                    <option value=''>未選択</option>
                                        @foreach($school_division_list as $item)
                                        <option value="{{$item->school_division_cd}}"@if($search_element_array['search_school_division'] == $item->school_division_cd) selected @endif>
                                            {{$item->school_division_name}}
                                        </option>
                                        @endforeach
                                </select>


                                <label for="search_school_cd" class="col-12 col-form-label original-label">学校選択</label>
                                @if(is_null($search_element_array['search_school_division']) || $search_element_array['search_school_division'] == "")
                                    <select id='search_school_cd' name='search_school_cd' class='form-control input-sm impossible'>
                                    <option value=''>学校区分を選択してください。</option>
                                @else

                                    <select id='search_school_cd' name='search_school_cd' class='form-control input-sm'>
                                    <option value=''>-----</option>
                                    @foreach($school_list as $item)
                                        
                                        @if($item->school_division == $search_element_array['search_school_division'])
                                            <option value="{{$item->school_cd}}"                                         
                                                @if($search_element_array['search_school_cd'] == $item->school_cd) selected @endif                                    
                                            >{{$item->school_name}}</option>

                                        @endif
                                        
                                    @endforeach

                                @endif
                                </select>
                                
                                <label for="search_majorsubject_cd" class="col-12 col-form-label original-label">専攻選択</label>
                                @if(is_null($search_element_array['search_school_cd']) || $search_element_array['search_school_cd'] == "")
                                    <select id='search_majorsubject_cd' name='search_majorsubject_cd' class='form-control input-sm impossible'>
                                    <option value=''>学校を選択してください。</option>
                                @else

                                    <select id='search_majorsubject_cd' name='search_majorsubject_cd' class='form-control input-sm'>
                                    <option value=''>-----</option>

                                        @foreach($majorsubject_list as $item)
                                            @if($item->school_cd == $search_element_array['search_school_cd'])
                                                <option value="{{$item->majorsubject_cd}}"
                                                    @if($search_element_array['search_majorsubject_cd'] == $item->majorsubject_cd) selected @endif                                    
                                                    >{{$item->majorsubject_name}}
                                                </option>
                                            @endif
                                        @endforeach


                                @endif                                                            
                                    
                                   
                                </select>
                                
                                <label for="member_last_name_yomi" class="col-12 col-form-label original-label">氏名（あいまい）</label>
                                <input type="text" id="" name="search_member_name" value="{{$search_element_array['search_member_name']}}" class="form-control">
                            
                                                                                            
                            
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
                    
                    <form id="save-form" method="post" action="{{ route('master.member.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                                                        
                            <input type="hidden" name="member_id" id="member_id" value="">
                            <input type="hidden" name="processflg" id="processflg" value="">
                                                        
                           
                            <div class="form-group row">

                                <label for="member_last_name" class="col-12 col-form-label original-label">氏名</label>                                
                                <div class="col-5 p-0 last-name-class">
                                    <input type="text" name="member_last_name" id="member_last_name" value="" class="form-control col-md-3">
                                </div>
                              
                                <div class="col-5 m-0 p-0">
                                    <input type="text" name="member_first_name" id="member_first_name" value="" class="form-control col-md-3">
                                </div>


                                <label for="member_last_name_yomi" class="col-12 col-form-label original-label">シメイ</label>
                                
                                <div class="col-5 p-0 last-name-class">
                                    <input type="text" name="member_last_name_yomi" id="member_last_name_yomi" value="" class="form-control col-md-3 last_name">
                                </div>
                                <div class="col-5 m-0 p-0">
                                    <input type="text" name="member_first_name_yomi" id="member_first_name_yomi" value="" class="form-control col-md-3 first_name">
                                </div>      
                                        
                                <label for="gender" class="col-md-6 col-form-label original-label">性別</label>                               
                                <select id='gender' name='gender' class='form-control input-sm'>		
                                        <option value="">---</option>							
										@foreach($gender_list as $item)
                                            <option value="{{$item->gender_cd}}">
                                                {{$item->gender_name}}
                                            </option>
										@endforeach
                                </select>

                                <label for="birthday" class="col-md-6 col-form-label original-label">生年月日<span id="display_age"></span></label>                                
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
                                    <option value="">学校を選択してください。</option>
                                    @foreach($majorsubject_list as $item)
                                    <option value="{{$item->majorsubject_cd}}" data-memberid='{{$item->member_id}}'>
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

                    
                    <form id="delete-form" method="post" action="{{ route('master.member.delete_or_restore') }}">       
                        @csrf
                        <div class="modal-body">

                            <input type="hidden" id="delete_flg" name="delete_flg" value="">
                            <input type="hidden" id="delete_member_id" name="delete_member_id" value="">                            
                            <input type="hidden" id="delete_member_name" name="delete_member_name" value="">
            
                            <table class="w-100">
                                
                                <tr>
                                    <td class="text-start">メンバーID</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_member_id"></span></td>
                                </tr>
                             
                                <tr>
                                    <td class="text-start">氏名</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_member_name"></span></td>
                                </tr>

                            </table>                            

                        </div>

                        <div class="modal-footer">                                                                                      
                            <div class="col-6 m-0 p-0 text-start">
                                <button type="submit" id='delete-modal-execution-button' class="btn"></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>      
                            </div>                            
                        </div>                                   
                    </form>

                </div>
            </div>
        </div>


        {{-- パスワード変更モーダル --}}
        <div class="modal fade" id="login-info-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="login-info-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="login-info-modal-label"><span id="login-info-modal_title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg login-info-msg m-2">
                        
                    </div>
                    
                    <form id="login_info_form" method="post" action="{{ route('master.member.login_info_update') }}">                    
                        @csrf
                        <div class="modal-body">  
                                                       
                            
                            <input type="hidden" name="logininfo_member_id" id="logininfo_member_id" value="">
                            <input type="hidden" name="login_info_password_id" id="login_info_password_id" value="">
                            <input type="hidden" name="logininfo_mailaddress" id="logininfo_mailaddress" value="">
                            
                            <div class="form-group row">
                                   
    
                                <label for="password" class="col-md-6 col-form-label original-label">パスワード</label>
                                <input type="text" name="password" id="password" value="" class="form-control col-md-3">
                            </div>                                                 
                            
                        </div>

                        <div class="modal-footer">                            
                            <div class="col-8 m-0 p-0 text-start">
                                <button type="button" id="login_info_change_button" class="btn btn-outline-primary">ログイン情報変更</button>
                            </div>

                            <div class="col-4 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>
                            </div>                            
                        </div> 

                    </form>

                </div>
            </div>
        </div>


        {{-- 学校情報モーダル --}}
        <div class="modal fade" id="school_info_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="school_info_modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="school_info_modal-label">学校情報</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                   
                        <div class="modal-body">                     
            
                            <table class="w-100">
                                
                                <tr>
                                    <th class="text-start">学校区分</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　<span id="school_info_modal_school_division_name"></span></td>
                                </tr>

                                <tr>
                                    <th class="text-start">学校名</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　<span id="school_info_modal_school_name"></span></td>
                                </tr>
                             
                                <tr>
                                    <th class="text-start">郵便番号</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　<span id="school_info_modal_post_code"></span></td>
                                </tr>

                                <tr>
                                    <th class="text-start">住所1</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　<span id="school_info_modal_address1"></span></td>
                                </tr>

                                <tr>
                                    <th class="text-start">住所2</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　<span id="school_info_modal_address2"></span></td>
                                </tr>

                                <tr>
                                    <th class="text-start">TEL</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　<span id="school_info_modal_tel"></span></td>
                                </tr>

                                <tr>
                                    <th class="text-start">FAX</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　<span id="school_info_modal_fax"></span></td>
                                </tr>

                                <tr>
                                    <th class="text-start">HP_URL</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　<span id="school_info_modal_hp_url"></span></td>
                                </tr>

                                <tr>
                                    <th class="text-start">メールアドレス</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　<span id="school_info_modal_mailaddress"></span></td>
                                </tr>
                                
                                <tr>
                                    <th class="text-start">備考</th>                                
                                </tr>
    
                                <tr>          
                                    <td>
                                        <textarea id="school_info_modal_remarks" class="form-control" rows="4" cols="40" readonly></textarea>
                                    </td>
                                    
                                </tr>

                            </table>                            

                        </div>


                        <div class="modal-footer">                            
                            <div id="school_info_modal_screen_move" class="col-8 m-0 p-0 text-start">
                                
                            </div>

                            <div class="col-4 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>
                            </div>                            
                        </div> 


                </div>
            </div>
        </div>





        {{-- 専攻情報モーダル --}}
        <div class="modal fade" id="majorsubject_info_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="majorsubject_info_modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="majorsubject_info_modal-label">専攻情報</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    
                   
                        <div class="modal-body">                     
            
                            <table class="w-100">
                                
                                <tr>
                                    <th class="text-start">学校名</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　<span id="majorsubject_info_modal_school_name"></span></td>
                                </tr>

                                <tr>
                                    <th class="text-start">専攻名</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　<span id="majorsubject_info_modal_majorsubject_name"></span></td>
                                </tr>
                             
                                <tr>
                                    <th class="text-start">学習期間</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　<span id="majorsubject_info_modal_studyperiod"></span></td>
                                </tr>

                                <tr>
                                    <th class="text-start">備考</th>                                
                                </tr>
    
                                <tr>          
                                    <td>
                                        <textarea id="majorsubject_info_modal_remarks" class="form-control" rows="4" cols="40" readonly></textarea>
                                    </td>
                                    
                                </tr>

                            </table>                            

                        </div>

                        <div class="modal-footer">            

                            <div id="majorsubject_info_modal_screen_move" class="col-8 m-0 p-0 text-start">
                                
                            </div>

                            <div class="col-4 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>      
                            </div>                            
                        </div> 

                </div>
            </div>
        </div>

      

    </div>
</div>
@endsection

@section('pagejs')

<script type="text/javascript">


//一覧表示画面の検索ボタンクリック時の処理
//検索項目に値に、入力または選択があるかチェックする
function search_form_check() {

    $(".is-invalid").removeClass('is-invalid');

    var FormData = $("#search-form").serializeArray();
    var NoInputCheck = false;

    $.each(FormData, function(i, element) {		

    var TargetValue = $("[name='"+ element.name +"']").val();
    
    if(TargetValue != ''){
        NoInputCheck = true;			
    }

    });

    if(NoInputCheck == false){

    $.each(FormData, function(i, element) {

        $("[name='"+ element.name +"']").addClass('is-invalid');

    });

    alert('検索項目を1つ以上設定してください。');	
    return false;

    }
}



$(function(){

    $(document).on("blur", "#admission_yearmonth", function (e) {
        graduation_yearmonth_get();
    });

    $(document).on("blur", "#birthday", function (e) {
        age_measurement();
    });

    function age_measurement(){

        var display_age = "";

        var input_birthday = new Date($('#birthday').val());

        if(input_birthday == "" ){
            return false;
        }
      
        //今日
        var today = new Date();
 
        //今年の誕生日
        var thisYearsBirthday = new Date(today.getFullYear(), input_birthday.getMonth(), input_birthday.getDate());

        //年齢
        var age = today.getFullYear() - input_birthday.getFullYear();

        if(today < thisYearsBirthday){
            //今年まだ誕生日が来ていない
            age--;
        }

        if($.isNumeric(age)){

            if(age < 0){
                age = 0;
            }
            display_age = "【" + age + "歳】"
        }

        $('#display_age').html(display_age);
    }


    $('#search_school_division').change(function() {
        school_list_get(1);
    });

    $('#search_school_cd').change(function() {
        majorsubject_list_get(1);
    });

    $('#school_cd').change(function() {
        majorsubject_list_get(2);
    });


    function graduation_yearmonth_get(){
    
        var school_cd = $('#school_cd').val();
        var majorsubject_cd = $('#majorsubject_cd').val();
        var admission_yearmonth = $('#admission_yearmonth').val();

        var graduation_yearmonth = $('#graduation_yearmonth').val();

        var get_graduation_yearmonth = "";

        if(school_cd != "" && majorsubject_cd != "" && admission_yearmonth != "" && graduation_yearmonth == ""){

            var check_date = new Date((admission_yearmonth + "-01").replace("-", "/"));
                        
            var studyperiod = $('[name=majorsubject_cd] option:selected').data('studyperiod');

            check_date.setMonth(check_date.getMonth() + studyperiod);

            get_graduation_yearmonth = check_date.getFullYear() + "-" + check_date.getMonth().toString().padStart(2, "0");
        }

        if(get_graduation_yearmonth != ""){
            $('#graduation_yearmonth').val(get_graduation_yearmonth);
        }


    }

    function school_list_get(branch){
       
        var target_form_id = "";
        var search_school_division = "";
        var target_element_id = "";
       
        if(branch == 1){

            target_form_id = "#search-form";
            search_school_division = $('#search_school_division').val();
            target_element_id = "#search_school_cd";
        }else if(branch == 2){

            target_form_id = "#save-form";
            search_school_division = $('#school_division').val();
            target_element_id = "#school_cd";
        }

       $("select" + target_element_id + " option").remove();

       $(target_element_id).removeClass("impossible");
       
       if(search_school_division == ""){
           $(target_element_id).addClass("impossible");
           $(target_element_id).append($("<option>").val("").text("学校区分を選択してください。"));
           return false;
       }

       //マウスカーソルを砂時計に
       document.body.style.cursor = 'wait';
       $(target_form_id).addClass("impossible");
       
       var Url = "{{ route('get_data.school_list_get')}}"

       $.ajax({
           url: Url, // 送信先
           type: 'get',
           dataType: 'json',
           data: {search_school_division : search_school_division},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}

       })
       .done(function (data, textStatus, jqXHR) {
           // テーブルに通信できた場合
           var result_array = data.result_array;

           var status = result_array["status"];

           //テーブルに通信時、データを検索できたか判定
           if (status == 'success') {

                var school_list = result_array["school_list"];

                $(target_element_id).append($("<option>").val("").text("------"));
                $.each(school_list, function(index, info) {

                    var school_cd = info["school_cd"];
                    var school_name = info["school_name"];

                    $(target_element_id).append($("<option>").val(school_cd).text(school_name));

                })

               $(target_element_id).removeClass("impossible");
               
           }else if(status == 'nodata'){
                       
               $(target_element_id).append($("<option>").val('').text('学校情報なし'));

           }else{
        
               $(target_element_id).append($("<option>").val('').text('学校情報取得エラー'));

           }

           //マウスカーソルを通常に
           document.body.style.cursor = 'auto';
           $(target_form_id).removeClass("impossible");

       })
           .fail(function (data, textStatus, errorThrown) {
           
                 //マウスカーソルを通常に
               document.body.style.cursor = 'auto';
               $(target_form_id).removeClass("impossible");
               $(target_element_id).append($("<option>").val('').text('学校情報取得エラー'));

           });


   }


    function majorsubject_list_get(branch){
       
        var target_form_id = "";
        var search_school_cd = "";
        var target_element_id = "";
        
        if(branch == 1){

            target_form_id = "#search-form";
            search_school_cd = $('#search_school_cd').val();
            target_element_id = "#search_majorsubject_cd";
        }else if(branch == 2){

            target_form_id = "#save-form";
            search_school_cd = $('#school_cd').val();
            target_element_id = "#majorsubject_cd";
        }

        $("select" + target_element_id + " option").remove();

        $(target_element_id).removeClass("impossible");
        
        if(search_school_cd == ""){
            $(target_element_id).addClass("impossible");
            $(target_element_id).append($("<option>").val("").text("学校を選択してください。"));
            return false;
        }

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';
        $(target_form_id).addClass("impossible");

        var Url = "{{ route('get_data.majorsubject_list_get')}}"

        $.ajax({
            url: Url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {search_school_cd : search_school_cd},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}

        })
        .done(function (data, textStatus, jqXHR) {
            // テーブルに通信できた場合
            var result_array = data.result_array;

            var status = result_array["status"];

            //テーブルに通信時、データを検索できたか判定
            if (status == 'success') {

                var majorsubject_list = result_array["majorsubject_list"];

                $(target_element_id).append($("<option>").val("").text("------"));
                $.each(majorsubject_list, function(index, info) {

                    var majorsubject_cd = info["majorsubject_cd"];
                    var majorsubject_name = info["majorsubject_name"];
                    var studyperiod = info["studyperiod"];

                    var append_text = "<option value='" + majorsubject_cd + "' data-studyperiod='" + studyperiod + "'>" + majorsubject_name + "</option>";
                                    
                
                    $(target_element_id).append(append_text);
                    // $(target_element_id).append($("<option>").val(majorsubject_cd).text(majorsubject_name));

                })

                $(target_element_id).removeClass("impossible");
                
            }else if(status == 'nodata'){
                        
                $(target_element_id).append($("<option>").val('').text('専攻情報なし'));

            }else{
         
                $(target_element_id).append($("<option>").val('').text('専攻情報取得エラー'));

            }

            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';
            $(target_form_id).removeClass("impossible");

        })
            .fail(function (data, textStatus, errorThrown) {
            
                  //マウスカーソルを通常に
                document.body.style.cursor = 'auto';
                $(target_form_id).removeClass("impossible");
                $(target_element_id).append($("<option>").val('').text('専攻情報取得エラー'));

            });


    }

    // 「クリア」ボタンがクリックされたら
    $('.clear-button').click(function () {

        var target_element_id = ""
        var FormData = $("#search-form").serializeArray();        

        target_element_id = "#search_school_cd"
        $("select" + target_element_id + " option").remove();
        $(target_element_id).addClass("impossible");
        $(target_element_id).append($("<option>").val("").text("学校区分を選択してください。"));

        target_element_id = "#search_majorsubject_cd"
        $("select" + target_element_id + " option").remove();
        $(target_element_id).addClass("impossible");
        $(target_element_id).append($("<option>").val("").text("学校を選択してください。"));

        $.each(FormData, function(i, element) {		
            $("[name='"+ element.name +"']").val("");          
        });

    });

    //登録、更新用モーダル表示時
    $('#save-modal').on('show.bs.modal', function(e) {

        var button_id = "#save-button";

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

        var member_id = evCon.data('memberid');
        var member_last_name = evCon.data('memberlastname');
        var member_first_name = evCon.data('memberfirstname');
        var member_last_name_yomi = evCon.data('memberlastnameyomi');
        var member_first_name_yomi = evCon.data('memberfirstnameyomi');
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

        var title ="";        

        $(button_id).removeClass('insert-button');
        $(button_id).removeClass('update-button');        

        if(processflg == '0'){
            title = "新規登録処理";
            $(button_id).addClass('insert-button');
        }else{
            title = '更新処理（学校CD：' + school_cd+'）';
            $(button_id).addClass('update-button');                              
        }

        $('#save-modal-title').html(title);    
             
        $('#processflg').val(processflg);    
        $('#member_id').val(member_id);           
        $('#member_last_name').val(member_last_name);
        $('#member_first_name').val(member_first_name);
        $('#member_last_name_yomi').val(member_last_name_yomi);
        $('#member_first_name_yomi').val(member_first_name_yomi);
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
        
        age_measurement();
    });


    //削除モーダル表示時
    $('#delete-modal').on('show.bs.modal', function(e) {

        var button_id = "#delete-modal-execution-button";

        // イベント発生元
        let evCon = $(e.relatedTarget);

        var member_id = evCon.data('memberid');        
        let member_name = evCon.data('memberlastname') + '　' + evCon.data('memberfirstname');
        var delete_flg = evCon.data('deleteflg');

        var delete_flg = evCon.data('deleteflg');

        $(button_id).removeClass('delete-button');
        $(button_id).removeClass('restore-button');
        $(button_id).removeClass('btn-outline-primary');
        $(button_id).removeClass('btn-outline-danger');

        if (delete_flg == 0) {                               
            $(button_id).addClass('btn-outline-danger');
            $(button_id).addClass('delete-button');
            
        } else {                        
            $(button_id).addClass('btn-outline-primary');
            $(button_id).addClass('restore-button');
        }
     
        $('#display_member_id').html(member_id);   
        $('#display_member_name').html(member_name);   
        

        $('#delete_flg').val(delete_flg);
        $('#delete_member_id').val(member_id);        
        $('#delete_member_name').val(member_name);  

    });



    //ログイン情報変更モーダル表示時
    $('#login-info-modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);
        
        var password_id = evCon.data('passwordid');
        var member_id = evCon.data('memberid');
        var mailaddress = evCon.data('mailaddress');    
        var password = evCon.data('password');

        $('#login_info_password_id').val(password_id);
        $('#logininfo_member_id').val(member_id);
        $('#logininfo_mailaddress').val(mailaddress);  
        $('#password').val(password);  

    });



   


    //学校情報確認モーダル表示時
    $('#school_info_modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);
                         
        school_info_get(evCon.data('schoolcd'));
       
      
    });

    function school_info_get(search_school_cd){
            
        $('#school_info_modal_school_division_name').html('');
        $('#school_info_modal_school_name').html('');
        $('#school_info_modal_post_code').html('');
        $('#school_info_modal_address1').html('');
        $('#school_info_modal_address2').html('');
        $('#school_info_modal_tel').html('');
        $('#school_info_modal_fax').html('');
        $('#school_info_modal_mailaddress').html('');
        $('#school_info_modal_hp_url').html('');
        $('#school_info_modal_remarks').val("");     

        if(search_school_cd == ""){
            return false;
        }

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';      

        var Url = "{{ route('get_data.school_info_get')}}"

        $.ajax({
            url: Url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {search_school_cd : search_school_cd},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}

        })
        .done(function (data, textStatus, jqXHR) {
            // テーブルに通信できた場合
            var result_array = data.result_array;

            var status = result_array["status"];

            //テーブルに通信時、データを検索できたか判定
            if (status == 'success') {

                var append_text = "";
                var school_info = result_array["school_info"];

                $('#school_info_modal_school_division_name').html(school_info["school_division_name"]);
                $('#school_info_modal_school_name').html(school_info["school_name"]);
                $('#school_info_modal_post_code').html(school_info["post_code"]);
                $('#school_info_modal_address1').html(school_info["address1"]);
                $('#school_info_modal_address2').html(school_info["address2"]);
                $('#school_info_modal_tel').html(school_info["tel"]);
                $('#school_info_modal_fax').html(school_info["fax"]);

                var hp_url = school_info["hp_url"];
                if(hp_url != ""){
                    append_text = "<a href='" + hp_url +"' target='_blank' rel='noopener noreferrer'>" + hp_url + "</a>";                
                    $("#school_info_modal_hp_url").append(append_text);
                }else{
                    $('#school_info_modal_hp_url').html("　"); 
                }                
                
                $('#school_info_modal_mailaddress').html(school_info["mailaddress"]);
                $('#school_info_modal_remarks').val(school_info["remarks"]);
               
                var screen_move_url =  "{{ route('master.school')}}" + "?search_school_cd=" + school_info["school_cd"];

                var a_tag = "<a href='" + screen_move_url +"' target='_blank' rel='noopener noreferrer'>学校マスタへ</a>";

                append_text = "<button class='original-button modal_screen_move_button'>" + a_tag + "</button>";
                
                $("#school_info_modal_screen_move").html("");
                $("#school_info_modal_screen_move").append(append_text);
                                
            }else if(status == 'nodata'){
                        
                

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



   //専攻情報確認モーダル表示時
   $('#majorsubject_info_modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);
                         
        majorsubject_info_get(evCon.data('schoolcd') , evCon.data('majorsubjectcd'));
       
      
    });

    function majorsubject_info_get(search_school_cd,search_majorsubject_cd){
            
        $('#majorsubject_info_modal_school_name').html('');
        $('#majorsubject_info_modal_majorsubject_name').html('');
        $('#majorsubject_info_modal_studyperiod').html('');        
        $('#majorsubject_info_modal_remarks').val("");     

        if(search_school_cd == "" || search_majorsubject_cd == ""){
            return false;
        }

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';      

        var Url = "{{ route('get_data.majorsubject_info_get')}}"

        $.ajax({
            url: Url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {search_school_cd : search_school_cd , search_majorsubject_cd : search_majorsubject_cd},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}

        })
        .done(function (data, textStatus, jqXHR) {
            // テーブルに通信できた場合
            var result_array = data.result_array;

            var status = result_array["status"];

            //テーブルに通信時、データを検索できたか判定
            if (status == 'success') {

                var majorsubject_info = result_array["majorsubject_info"];       

                $('#majorsubject_info_modal_school_name').html(majorsubject_info["school_name"]);
                $('#majorsubject_info_modal_majorsubject_name').html(majorsubject_info["majorsubject_name"]);
                $('#majorsubject_info_modal_studyperiod').html(majorsubject_info["studyperiod"] + "ヶ月");                
                $('#majorsubject_info_modal_remarks').val(majorsubject_info["remarks"]);

                var screen_move_url =  "{{ route('master.majorsubject')}}" + "?search_school_cd=" + majorsubject_info["school_cd"];

                var a_tag = "<a href='" + screen_move_url +"' target='_blank' rel='noopener noreferrer'>専攻マスタへ</a>";

                append_text = "<button class='original-button modal_screen_move_button'>" + a_tag + "</button>";
                
                $("#majorsubject_info_modal_screen_move").html("");
                $("#majorsubject_info_modal_screen_move").append(append_text);

                                
            }else if(status == 'nodata'){
                        
                

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

     var member_id = $("#logininfo_member_id").val();
     var logininfo_mailaddress = $("#logininfo_mailaddress").val();
     var password = $("#password").val();
     var Judge = true;

     if(password == ""){
         $('#password').focus();
         Judge = false;
         $("#password").addClass("is-invalid");            
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
         data: {member_id : member_id , logininfo_mailaddress : logininfo_mailaddress , password : password},
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

                 
                 var password_duplication = result_array["password_duplication"];

                 //{{-- アラートメッセージ表示 --}}
                 var errorsHtml = '';
                 errorsHtml = '<div class="alert alert-danger text-start">';
                 

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

