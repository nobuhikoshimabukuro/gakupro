@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', '学校マスタ')  
@endsection
@section('content')

<div id="Main" class="mt-3 text-center container">
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row">
        <div class="col-6 text-start">
            <h4 class="MasterTitle">
                学校マスタ
            </h4>
        </div>
        

        <div class="col-6 NewAddition-Button">
            <a href="" class="btn btn--red btn--radius btn--cubic" 
            data-bs-toggle='modal' data-bs-target='#save_modal'            
            data-processflg='0'
            ><i class='fas fa-plus-circle'></i><span class="NewAddition-ButtonName"></span></a>  
        </div>

    </div>

    <form id="SearchForm" class="row" action="" method="get">

        <div class="col-12">
    
            <div id="SearchFormArea" class="Table-Wrap m-0 p-0">
                <table id='' class='SearchInfoTable'>
                    <tr>                
                        <th>学校区分選択</th>
                        <th>学校名</th>                    
                        <th>
                            <a id="" class="original-btn ClearButton">クリア</a>  
                        </th>                    
                    </tr>

                    <tr>              
                        <td>
                            <select id='' name='search_school_division' class='form-control input-sm'>
                                <option value=''>未選択</option>
                                    @foreach($school_division_list as $item)
                                    <option value="{{$item->school_division_cd}}"@if($SearchElementArray['search_school_division'] == $item->school_division_cd) selected @endif>
                                        {{$item->school_division_name}}
                                    </option>
                                    @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" id="" name="search_school_name" value="{{$SearchElementArray['search_school_name']}}" class="form-control">
                        </td>                
                        
                        <td>                         
                            <button type="submit" id="" class="original-btn SearchButton" onclick="return SearchFormCheck();">検索 <i class="fas fa-search"></i></button>                                                                                              
                        </td>
                    </tr>

                </table>
            </div>
        
        </div>
             
    </form>

    <div class="m-0 text-start">
        {{-- ページャー --}}                
        @if(count($school_m_list) > 0)                                
          <div class="m-0">{{ $school_m_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="DataDisplayArea" class="Table-Wrap m-0">

        <table id='' class='DataInfoTable'>
            
            <tr>
                <th>学校CD</th>
                <th>区分</th>
                <th>学校名</th>
                <th>TEL</th>
                <th>HP</th>
                <th>専攻総数</th>
                <th>備考</th>
                <th>件数【<span id='TotalCount'>{{count($school_m_list)}}</span>件】</th>
            </tr>

            @foreach ($school_m_list as $item)
            <tr>
                <td>{{$item->school_cd}}</td>
                <td>{{$item->school_division_name}}</td>
                <td class="text-start">{{$item->school_name}}</td>                   
                <td class="text-start">{{$item->tel}}</td>
                <td class="text-start">
                    <a href="{{$item->hp_url}}" target="_blank" rel="noopener noreferrer">{{$item->hp_url}}</a>
                </td>
                <td>
                    <button class='btn btn-warning' type='button' onclick= "location.href='{{ route('master.majorsubject' ,['search_school_cd' => $item->school_cd]) }}'">専攻情報確認【{{$item->majorsubject_count}}】</button>
                </td>          
                
                @php
                    // 表示する最大文字数
                    $LimitStr = 4;
                    $ButtonName = "";

                    // ボタン表示フラグ
                    $DisplayBtnFLG = true;

                    if(!is_null($item->remarks)){

                        // 申込情報備考文字数取得
                        $StrCount = mb_strlen($item->remarks);

                        if($StrCount > $LimitStr){
                            // 最大文字数に達している場合、"$申込情報備考（指定した文字数）..."と表示
                            $ButtonName =  mb_substr($item->remarks, 0 , $LimitStr);
                            $ButtonName =  $ButtonName . "...";


                        }else if($StrCount <= $LimitStr){
                            
                            $ButtonName = $item->remarks;
                        }

                    }else{

                        // 申込情報備考が登録されていない場合
                        $DisplayBtnFLG = false;

                    }

                @endphp
                <td>
                    @if($DisplayBtnFLG)  
                        
                        <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#remarks_modal'
                        data-schoolcd="{{$item->school_cd}}"
                        data-schoolname='{{$item->school_name}}'
                        data-remarks="{{$item->remarks}}"											
                        >{{$ButtonName}}                  
                   
                    @endif                  
                
                </td>
                <td>
                    <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#save_modal'
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
                        data-processflg='1'> 
                        <i class='far fa-edit'></i>
                    </button>

                    <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#dlete_modal'
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
                    
                    <form id="Saveform" method="post" action="{{ route('master.school.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                                                        
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

                                <label for="hp_url" class="col-md-6 col-form-label original-label">住所2</label>
                                <input type="text" name="hp_url" id="hp_url" value="" class="form-control col-md-3">

                                <label for="mailaddress" class="col-md-6 col-form-label original-label">メールアドレス</label>
                                <input type="text" name="mailaddress" id="mailaddress" value="" class="form-control col-md-3">

                                <label for="remarks" class="col-md-6 col-form-label original-label">備考</label>                                
                                <textarea name="remarks" id="remarks" class="form-control col-md-3" rows="4"></textarea>

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

                <form id="Deleteform" method="post" action="{{ route('master.school.delete_or_restore') }}">                           
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
  

       

        {{-- 備考確認用モーダル --}}
        <div class="modal fade" id="remarks_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="remarks_modal_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

	                  <div class="modal-header">
                        <h5 class="modal-title" id=""><span id="remarks_modal_title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                   
                    <div class="modal-body">                                                          
                        <textarea id="remarks_modal_Remarks" class="form-control" rows="4" cols="40" readonly></textarea>
                    </div>

                    <div class="modal-footer">               
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
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

    //備考モーダル
    $('#remarks_modal').on('show.bs.modal',function(e){
        // イベント発生元
        let evCon = $(e.relatedTarget);

        let school_name = evCon.data('schoolname');
        let remarks = evCon.data('remarks');

        var Title = school_name + "の備考"
        $('#remarks_modal_title').html(Title);
        $('#remarks_modal_Remarks').val(remarks);
        
    });


    //登録、更新用モーダル表示時
    $('#save_modal').on('show.bs.modal', function(e) {

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        var FormData = $("#Saveform").serializeArray();        

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
            $('#save_modal_title').html('登録処理');         
            school_cd = 0;
            $('#save_modal_button_display').html('登録');
        }else{
            $('#save_modal_title').html('更新処理');                           
            $('#save_modal_button_display').html('更新');
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
   $('#dlete_modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var school_cd = evCon.data('schoolcd');
        var school_name = evCon.data('schoolname');    
        var deleteflg = evCon.data('deleteflg');
    
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

       
    
        $('#display_school_cd').html(school_cd);    
        $('#display_school_name').html(school_name);    
        $('.dlete_modal_wording').html(wording);


        $('#delete_flg').val(delete_flg);
        $('#delete_school_cd').val(school_cd);
        $('#delete_school_name').val(school_name);  

    });


    // 「クリア」ボタンがクリックされたら
    $('.ClearButton').click(function () {

        var FormData = $("#SearchForm").serializeArray();        

        $.each(FormData, function(i, element) {		
            $("[name='"+ element.name +"']").val("");          
        });
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

        let f = $('#Saveform');

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
                $('#SaveButton').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';

            });

    });

});

</script>
@endsection

