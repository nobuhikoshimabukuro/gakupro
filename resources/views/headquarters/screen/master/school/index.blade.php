@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', '学校マスタ')  
@endsection
@section('content')

<div id="main" class="mt-3 text-center container">
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row">        

        <div class="col-6 text-start">
            <h4 class="master-title">
                学校マスタ
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
        @if(count($school_list) > 0)                                
          <div class="m-0">{{ $school_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="data-display-area" class="scroll-wrap-x m-0">

        <table id='' class='data-info-table'>
            
            <tr>
                <th>学校CD</th>
                <th>区分</th>
                <th>学校名</th>
                <th>TEL</th>
                <th>HP</th>
                <th>専攻総数</th>
                <th>備考</th>
                <th>件数【<span id='data-total-count'>{{count($school_list)}}</span>件】</th>
            </tr>

            @foreach ($school_list as $item)
            <tr>
                <td>{{$item->school_cd}}</td>
                <td>{{$item->school_division_name}}</td>
                <td class="text-start">{{$item->school_name}}</td>                   
                <td class="text-start">{{$item->tel}}</td>
                <td class="text-start">
                    <a href="{{$item->hp_url}}" target="_blank" rel="noopener noreferrer">{{$item->hp_url}}</a>
                </td>
                <td>
                    
                    <button type="button" class='btn btn-success search-modal-button' 
                    data-schoolcd="{{$item->school_cd}}"
                    data-bs-toggle='modal' data-bs-target='#majorsubject_list_modal'>専攻情報</button>                    
                </td>          
                
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
                        data-schoolcd="{{$item->school_cd}}"
                        data-schoolname='{{$item->school_name}}'
                        data-remarks="{{$item->remarks}}"											
                        >{{$remarks_button_name}}                  
                   
                    @endif                  
                
                </td>
                <td>
                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#save-modal'
                        data-schoolcd='{{$item->school_cd}}'
                        data-schooldivision='{{$item->school_division}}'
                        data-schoolname='{{$item->school_name}}'
                        data-postcode='{{$item->post_code}}'
                        data-address1='{{$item->address1}}'
                        data-address2='{{$item->address2}}'
                        data-tel='{{$item->tel}}'
                        data-fax='{{$item->fax}}'
                        data-hpurl='{{$item->hp_url}}'
                        data-mailaddress='{{$item->mailaddress}}'
                        data-remarks='{{$item->remarks}}'
                        data-processflg='1'> 
                        <i class='far fa-edit'></i>
                    </button>

                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#delete-modal'
                        data-schoolcd='{{$item->school_cd}}'
                        data-schooldivision='{{$item->school_division}}'
                        data-schoolname='{{$item->school_name}}'
                        data-post_code='{{$item->post_code}}'
                        data-address1='{{$item->address1}}'
                        data-address2='{{$item->address2}}'
                        data-tel='{{$item->tel}}'
                        data-fax='{{$item->fax}}'
                        data-hpurl='{{$item->hp_url}}'
                        data-mailaddress='{{$item->mailaddress}}'
                        data-remarks='{{$item->remarks}}'
                        data-deleteflg=@if($item->deleted_at) 1 @else 0 @endif>
                                    
                        @if($item->deleted_at)
                            <i class='far fa-thumbs-down'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-up'></i>
                        @else
                            <i class='far fa-thumbs-up'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-down'></i>
                        @endif
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
                            
                                <label for="search_school_name" class="col-12 col-form-label original-label">学校名（あいまい）</label>
                                <input type="text" id="search_school_name" name="search_school_name" value="{{$search_element_array['search_school_name']}}" class="form-control">
                            
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
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="save-modal-label"><span id="save-modal-title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg m-2">
                        
                    </div>
                    
                    <form id="save-form" method="post" action="{{ route('master.school.save') }}">                    
                        @csrf
                        <div class="modal-body" >  
                                                        
                            <input type="hidden" name="processflg" id="processflg" value="">                  
                                                        
                            <div class="form-group row">
                                <label for="school_division" class="col-md-6 col-form-label original-label">学校区分</label>                               
                                <select id='school_division' name='school_division' class='form-control input-sm'>
									<option value=''>
										@foreach($school_division_list as $item)
										<option value="{{$item->school_division_cd}}">
                                            {{$item->school_division_name}}
                                        </option>
										@endforeach
                                </select>
                            
                                <input type="hidden" name="school_cd" id="school_cd" value="">  

                                <label for="school_name" class="col-md-6 col-form-label original-label">学校名</label>
                                <input type="text" name="school_name" id="school_name" value="" class="form-control col-md-3">

                                <label for="post_code" class="col-md-6 col-form-label original-label">郵便番号</label>
                                <input type="tel" name="post_code" id="post_code" value="" class="form-control col-md-3">
                                
                                <label for="address1" class="col-md-6 col-form-label original-label">住所1</label>
                                <input type="text" name="address1" id="address1" value="" class="form-control col-md-3">

                                <label for="address2" class="col-md-6 col-form-label original-label">住所2</label>
                                <input type="text" name="address2" id="address2" value="" class="form-control col-md-3">

                                <label for="tel" class="col-md-6 col-form-label original-label">電話番号</label>
                                <input type="tel" name="tel" id="tel" value="" class="form-control col-md-3">

                                <label for="fax" class="col-md-6 col-form-label original-label">FAX</label>
                                <input type="tel" name="fax" id="fax" value="" class="form-control col-md-3">

                                <label for="hp_url" class="col-md-6 col-form-label original-label">HP URL</label>
                                <input type="text" name="hp_url" id="hp_url" value="" class="form-control col-md-3">

                                <label for="mailaddress" class="col-md-6 col-form-label original-label">メールアドレス</label>
                                <input type="text" name="mailaddress" id="mailaddress" value="" class="form-control col-md-3">

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

                <form id="delete-form" method="post" action="{{ route('master.school.delete_or_restore') }}">                           
                    @csrf
                    <div class="modal-body">  
                        <input type="hidden" id="delete_flg" name="delete_flg" value="">
                        <input type="hidden" id="delete_school_cd" name="delete_school_cd" value="">
                        <input type="hidden" id="delete_school_name" name="delete_school_name" value="">
        
                        <table class="w-100">

                            <tr>
                                <td class="text-start">学校CD</td>                                
                            </tr>

                            <tr>                                
                                <td class="text-start"><span id="display_school_cd"></span></td>
                            </tr>
                         
                            <tr>
                                <td class="text-start">学校名</td>                                
                            </tr>

                            <tr>                                
                                <td class="text-start"><span id="display_school_name"></span></td>
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


        {{-- 専攻情報リストモーダル --}}
        <div class="modal fade" id="majorsubject_list_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="majorsubject_list_modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="majorsubject_list_modal-label">専攻情報</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    
                   
                        <div class="modal-body">                     
            
                            <table id="majorsubject_list_modal_table" class="w-100">
                               

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

        let school_name = evCon.data('schoolname');
        let remarks = evCon.data('remarks');

        var title = school_name + "の備考"
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

        var school_cd = evCon.data('schoolcd');
        var school_division = evCon.data('schooldivision');
        var school_name = evCon.data('schoolname');
        var post_code = evCon.data('postcode');
        var address1 = evCon.data('address1');
        var address2 = evCon.data('address2');
        var tel = evCon.data('tel');
        var fax = evCon.data('fax');
        var hp_url = evCon.data('hpurl');
        var mailaddress = evCon.data('mailaddress');
        var remarks = evCon.data('remarks');
        
        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');
        if(processflg == '0'){
            $('#save-modal-title').html('登録処理');         
            school_cd = 0;
            
        }else{
            $('#save-modal-title').html('更新処理');                           
            
        }
        
     
        $('#processflg').val(processflg);
        $('#school_cd').val(school_cd);        
        $('#school_division').val(school_division);
        $('#school_name').val(school_name);
        $('#post_code').val(post_code);
        $('#address1').val(address1); 
        $('#address2').val(address2);        
        $('#tel').val(tel);
        $('#fax').val(fax);
        $('#hp_url').val(hp_url);
        $('#mailaddress').val(mailaddress); 
        $('#remarks').val(remarks); 
                
    });
   
   //削除モーダル表示時
   $('#delete-modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var school_cd = evCon.data('schoolcd');
        var school_name = evCon.data('schoolname');    
        var deleteflg = evCon.data('deleteflg');
    
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

       
    
        $('#display_school_cd').html(school_cd);    
        $('#display_school_name').html(school_name);    
        $('.delete-modal_wording').html(wording);


        $('#delete_flg').val(delete_flg);
        $('#delete_school_cd').val(school_cd);
        $('#delete_school_name').val(school_name);  

    });


    // 「クリア」ボタンがクリックされたら
    $('.clear-button').click(function () {

        var FormData = $("#search-form").serializeArray();        

        $.each(FormData, function(i, element) {		
            $("[name='"+ element.name +"']").val("");          
        });
    });


    //専攻情報確認モーダル表示時
   $('#majorsubject_list_modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);
                         
        majorsubject_list_get(evCon.data('schoolcd'));
       
      
    });

    function majorsubject_list_get(search_school_cd){
       
        $("#majorsubject_list_modal_table").html("");
        var append_text = "";

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';       

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
                
                append_text = "<tr><th class='text-start'>専攻一覧</th></tr>";
                $("#majorsubject_list_modal_table").append(append_text);

                var majorsubject_list = result_array["majorsubject_list"];
                
                $.each(majorsubject_list, function(index, info) {

                    var majorsubject_cd = info["majorsubject_cd"];
                    var majorsubject_name = info["majorsubject_name"];                   

                    append_text = "<tr><td class='text-start'>" + majorsubject_cd + ":" + majorsubject_name + "</td></tr>";

                    $("#majorsubject_list_modal_table").append(append_text);                
                })               


                    $("#majorsubject_info_modal_screen_move").html("");

                    var screen_move_url =  "{{ route('master.majorsubject')}}" + "?search_school_cd=" + search_school_cd;

                    var a_tag = "<a href='" + screen_move_url +"' target='_blank' rel='noopener noreferrer'>専攻マスタへ</a>";

                    append_text = "<button class='original-button modal_screen_move_button'>" + a_tag + "</button>";

                    $("#majorsubject_info_modal_screen_move").append(append_text);
               
           }else if(status == 'nodata'){
                       
                
                append_text = "<tr><th class='text-start'>専攻情報なし</th></tr>";
                $("#majorsubject_list_modal_table").append(append_text);
               

           }else{
        
                
                append_text = "<tr><th class='text-start'>専攻情報取得時エラー</th></tr>";
                $("#majorsubject_list_modal_table").append(append_text);
               

           }

           //マウスカーソルを通常に
           document.body.style.cursor = 'auto';
           

       })
           .fail(function (data, textStatus, errorThrown) {
           
                //マウスカーソルを通常に
                document.body.style.cursor = 'auto';
             
                
                var append_text = "<tr><th class='text-start'>専攻情報取得時エラー</th></tr>";
                $("#majorsubject_list_modal_table").append(append_text);

           });


   }



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
                    errorsHtml += '<li class="text-start">' + data.status + ':' + errorThrown + '</li>';

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

