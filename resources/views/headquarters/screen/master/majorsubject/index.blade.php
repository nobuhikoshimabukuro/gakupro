@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', '専攻マスタ')  
@endsection
@section('content')

<style>

    </style>
<div id="main" class="mt-3 text-center container">
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row">        

        <div class="col-6 text-start">
            <h4 class="master_title">
                専攻マスタ
            </h4>
        </div>    

        <div class="col-6 text-end">

            <button type="button" class='original_button'>
                <a href="{{ route('master.index') }}">マスタ一覧へ</a>
            </button>
            
        </div>

        <div class="col-6 text-start">
            <button type="button" class='original_button search_modal_button' data-bs-toggle='modal' data-bs-target='#search_modal'>検索する</button>
        </div>

        <div class="col-6 text-end">
            <button type="button" id="" class="original_button add_data_button"
                data-bs-toggle='modal' data-bs-target='#save_modal'            
                data-process_flg='0'><span class="add_data_button_name"></span>
            </button>
        </div>      

    </div>  
      
    
    <div class="m-0 text-start">
        {{-- ページャー --}}                
        @if(count($majorsubject_m_list) > 0)                                
          <div class="m-0">{{ $majorsubject_m_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="data_display_area" class="table_wrap m-0">
        <table id='' class='data_info_table'>
            
            <tr>
                <th>区分</th>                
                <th>学校名</th>                
                <th>専攻名</th>
                <th>期間[ヶ月]</th>
                <th>備考</th>
                <th>件数【<span id='total_count'>{{count($majorsubject_m_list)}}</span>件】</th>
            </tr>

            @foreach ($majorsubject_m_list as $item)
            <tr>
                <td class="text-start">{{$item->school_division_name}}</td>
                <td class="text-start">
                    <button class='modal_button' data-bs-toggle='modal' data-bs-target='#school_info_modal'                        
                        data-schoolcd='{{$item->school_cd}}'                        
                    >{{$item->school_name}}
                    </button>
                </td>         
                <td class="text-start">{{$item->majorsubject_name}}</td>                
                <td class="text-center">{{$item->studyperiod}}</td>
                
                
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
                        data-majorsubjectname="{{$item->majorsubject_name}}"
                        data-remarks="{{$item->remarks}}"											
                        >{{$remarks_button_name}}                  
                   
                    @endif                  
                
                </td>

                <td>
                    <button class='modal_button' data-bs-toggle='modal' data-bs-target='#save_modal'
                        data-schoolcd='{{$item->school_cd}}'
                        data-majorsubjectcd='{{$item->majorsubject_cd}}'
                        data-majorsubject_name='{{$item->majorsubject_name}}'
                        data-studyperiod='{{$item->studyperiod}}'
                        data-remarks='{{$item->remarks}}'
                        data-process_flg='1'> 
                        <i class='far fa-edit'></i>
                    </button>

                    <button class='modal_button' data-bs-toggle='modal' data-bs-target='#dlete_modal'
                        data-schoolcd='{{$item->school_cd}}'
                        data-majorsubjectcd='{{$item->majorsubject_cd}}'
                        data-schoolname='{{$item->school_name}}'
                        data-majorsubject_name='{{$item->majorsubject_name}}'                        
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
                            @if(is_null($search_element_array['search_school_division']))                             
                                <select id='search_school_cd' name='search_school_cd' class='form-control input-sm impossible'>
                                <option value=''>学校区分を選択してください。</option>
                            @else
                                <select id='search_school_cd' name='search_school_cd' class='form-control input-sm'>
                                <option value=''>-----</option>

                                @foreach($school_list as $item)
                                    @if($search_element_array['search_school_division'] == $item->school_division)
                                        <option value="{{$item->school_cd}}"  class=""
                                            @if($search_element_array['search_school_cd'] == $item->school_cd) selected @endif                                    
                                            >{{$item->school_name}}
                                        </option>
                                    @endif
                                @endforeach
                            @endif            
                                </select>      
                                          
                            <label for="search_school_name" class="col-12 col-form-label original-label">学校名（あいまい）</label>
                            <input type="text" id="search_school_name" name="search_school_name" value="{{$search_element_array['search_school_name']}}" class="form-control">
                            
                            <label for="search_majorsubject_name" class="col-12 col-form-label original-label">専攻名（あいまい）</label>
                            <input type="text" id="search_majorsubject_name" name="search_majorsubject_name" value="{{$search_element_array['search_majorsubject_name']}}" class="form-control">
                        
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
                    
                    <form id="save_form" method="post" action="{{ route('master.majorsubject.save') }}">                    
                        @csrf
                        <div class="modal-body">                                                         
                                                        
                            <div class="form-group row">
                                
                                <input type="hidden" name="process_flg" id="process_flg" value="">               

                                <label for="school_division" class="col-md-6 col-form-label original-label">区分</label>
                                <select id='school_division' name='school_division' class='form-control input-sm'>
                                    <option value=''>未選択</option>
                                        @foreach($school_division_list as $item)
                                        <option value="{{$item->school_division_cd}}">
                                            {{$item->school_division_name}}
                                        </option>
                                        @endforeach
                                </select>

                                <label for="school_cd" class="col-md-6 col-form-label original-label">学校名</label>
                                <select id='school_cd' name='school_cd' class='form-control input-sm impossible'>
                                    <option value=''>学校区分を選択してください。</option>
                                    @foreach($school_list as $item)
                                        <option value="{{$item->school_cd}}" >
                                            {{$item->school_name}}                                            
                                        </option>
                                    @endforeach
                                </select>
                            
                                <input type="hidden" name="majorsubject_cd" id="majorsubject_cd" value=""> 

                                <label for="majorsubject_name" class="col-md-6 col-form-label original-label">専攻名</label>
                                <input type="text" name="majorsubject_name" id="majorsubject_name" value="" class="form-control col-md-3">

                                <label for="studyperiod" class="col-md-6 col-form-label original-label">学習期間【ヶ月】</label>
                                <input type="text" name="studyperiod" id="studyperiod" value="" class="form-control col-md-3">

                                <label for="remarks" class="col-md-6 col-form-label original-label">備考</label>                                
                                <textarea name="remarks" id="remarks" class="form-control col-md-3" rows="4"></textarea>
                                
                                

                              </div>                                                 
                            
                        </div>

                        <div class="modal-footer row">                            
                            <div class="col-6 m-0 p-0 text-start">
                                <button type="button" id='save_button' class="original_button save_button"><span id='save_modal_button_display'></span></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
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

                    <form id="delete_form" method="post" action="{{ route('master.majorsubject.delete_or_restore') }}">                           
                        @csrf
                        <div class="modal-body">  
                        <input type="hidden" id="delete_flg" name="delete_flg" value="">
                        <input type="hidden" id="delete_school_cd" name="delete_school_cd" value="">
                        <input type="hidden" id="delete_majorsubject_cd" name="delete_majorsubject_cd" value="">
                        <input type="hidden" id="delete_school_name" name="delete_school_name" value="">                        
                        <input type="hidden" id="delete_majorsubject_name" name="delete_majorsubject_name" value="">
                        


                        <table class="w-100">

                            <tr>
                                <td class="text-start">学校名</td>                                
                            </tr>

                            <tr>                                
                                <td class="text-start"><span id="display_school_name"></span></td>
                            </tr>
                         
                            <tr>
                                <td class="text-start">専攻名</td>                                
                            </tr>

                            <tr>                                
                                <td class="text-start"><span id="display_majorsubject_name"></span></td>
                            </tr>

                        </table>                            

                        </div>


                        <div class="modal-footer row">                                                                                      
                            <div class="col-6 m-0 p-0 text-start">
                                <button type="submit" id='dlete_modal_runbutton' class="original_button dlete_modal_runbutton"><span class="dlete_modal_wording"></span></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
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


        {{-- 学校情報モーダル --}}
        <div class="modal fade" id="school_info_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="school_info_modal_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="school_info_modal_label">学校情報</h5>
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


                        <div class="modal-footer row">                            
                            <div id="school_info_modal_screen_move" class="col-8 m-0 p-0 text-start">
                                
                            </div>

                            <div class="col-4 m-0 p-0 text-end">
                                <button type="button" id="" class="original_button close_modal_button" data-bs-dismiss="modal">閉じる</button>
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
function search_formCheck() {

	 $(".is-invalid").removeClass('is-invalid');

	var FormData = $("#search_form").serializeArray();
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


    $('#search_school_division').change(function() {
        school_search(1);
    });

    $('#school_division').change(function() {
        school_search(2);
    });
    
    function school_search(branch){
       
        var target_form_id = "";
        var search_school_division = "";       
        var target_element_id = "";
       
        if(branch == 1){

            target_form_id = "#search_form";
            search_school_division = $('#search_school_division').val();
            target_element_id = "#search_school_cd";
        }else if(branch == 2){

            target_form_id = "#save_form";
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

       var Url = "{{ route('get_data.school_list_get')}}"

       $(target_form_id).addClass("impossible");

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

    //備考モーダル
    $('#remarks_modal').on('show.bs.modal',function(e){
        // イベント発生元
        let evCon = $(e.relatedTarget);

        let majorsubject_name = evCon.data('majorsubjectname');
        let remarks = evCon.data('remarks');

        var title = majorsubject_name + "の備考"
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
        var school_cd = evCon.data('schoolcd');
        var school_name = evCon.data('schoolname');
        var majorsubject_cd = evCon.data('majorsubjectcd');
        var majorsubject_name = evCon.data('majorsubject_name');
        var studyperiod = evCon.data('studyperiod');
        var remarks = evCon.data('remarks');
        


        //登録処理か更新処理か判断
        var process_flg = evCon.data('process_flg');
        if(process_flg == '0'){
            $('#save_modal_title').html('登録処理');         
            majorsubject_cd = 0;            
            $('#save_modal_button_display').html('登録');
            $("select[name='school_cd']").removeAttr("disabled");
        }else{
            $('#save_modal_title').html('更新処理');               
            $('#save_modal_button_display').html('更新');
            $("select[name='school_cd']").attr("disabled", true);
        }
        
     
        $('#process_flg').val(process_flg);  
        $('#school_cd').val(school_cd);
        $('#majorsubject_cd').val(majorsubject_cd);                            
        $('#majorsubject_name').val(majorsubject_name); 
        $('#studyperiod').val(studyperiod); 
        $('#remarks').val(remarks);       
    });


    //削除モーダル表示時
   $('#dlete_modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var school_cd = evCon.data('schoolcd');
        var majorsubject_cd = evCon.data('majorsubjectcd');
        var school_name = evCon.data('schoolname');
        var majorsubject_name = evCon.data('majorsubject_name');
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

            
        $('#display_school_name').html(school_name);
        $('#display_majorsubject_name').html(majorsubject_name);
        $('.dlete_modal_wording').html(wording);


        $('#delete_flg').val(delete_flg);
        $('#delete_school_cd').val(school_cd);
        $('#delete_majorsubject_cd').val(majorsubject_cd);
        $('#delete_school_name').val(school_name);
        $('#delete_majorsubject_name').val(majorsubject_name);

    });

    // 「クリア」ボタンがクリックされたら
    $('.clear_button').click(function () {

        var FormData = $("#search_form").serializeArray();        

        $.each(FormData, function(i, element) {		
            $("[name='"+ element.name +"']").val("");          
        });
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
                    $('#school_info_modal_hp_url').html(""); 
                }                
                
                $('#school_info_modal_mailaddress').html(school_info["mailaddress"]);
                $('#school_info_modal_remarks').val(school_info["remarks"]);
               
                var screen_move_url =  "{{ route('master.school')}}" + "?search_school_cd=" + school_info["school_cd"];

                var a_tag = "<a href='" + screen_move_url +"' target='_blank' rel='noopener noreferrer'>学校マスタへ</a>";

                append_text = "<button class='original_button modal_screen_move_button'>" + a_tag + "</button>";

                
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
                $('#save_button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';

            });

    });

});

</script>
@endsection

