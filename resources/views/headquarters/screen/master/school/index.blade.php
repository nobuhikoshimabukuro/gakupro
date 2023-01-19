@extends('headquarters.common.layouts_app')

@section('pagehead')
@section('title', '学校マスタ')  
@endsection
@section('content')

<div class="mt-3 text-center container">
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row">
        <div class="col-6 text-left">
            <h4 class="MasterTitle">
                学校マスタ
            </h4>
        </div>
        

        <div class="col-6 NewAddition-Button">
            <a href="" class="btn btn--red btn--radius btn--cubic" 
            data-bs-toggle='modal' data-bs-target='#Save_Modal'            
            data-processflg='0'
            ><i class='fas fa-plus-circle'></i>　新規追加</a>               
        </div>

    </div>

    <div id="DataDisplayArea" class="DataInfoTable-Wrap m-0 p-0">
        <table id='' class='DataInfoTable'>
            
            <tr>
                <th>学校CD</th>
                <th>学校名</th>
                <th>TEL</th>
                <th>HP</th>
                <th>件数【<span id='TotalNumber'>{{$school_m_list->count()}}</span>件】</th>
            </tr>

            @foreach ($school_m_list as $item)
            <tr>
                <td>{{$item->school_cd}}
                    <button id="majorsubject_open_button_{{$item->school_cd}}" class="majorsubject_open_button" data-schoolcd='{{$item->school_cd}}'>↓</button>
                    <button id="majorsubject_close_button_{{$item->school_cd}}" class="majorsubject_close_button d-none" data-schoolcd='{{$item->school_cd}}'>↑</button>
                </td>
                <td>{{$item->school_name}}</td>                   
                <td>{{$item->tel}}</td>
                <td><a href="{{$item->hp_url}}" target="_blank" rel="noopener noreferrer">{{$item->hp_url}}</a></td>
                <td>
                    <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#Save_Modal'
                        data-schoolcd='{{$item->school_cd}}'
                        data-schooldivision='{{$item->school_division}}'
                        data-schoolname='{{$item->school_name}}'
                        data-tel='{{$item->tel}}'
                        data-hpurl='{{$item->hp_url}}'
                        data-mailaddress='{{$item->mailaddress}}'
                        data-processflg='1'> 
                        <i class='far fa-edit'></i>
                    </button>

                    <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#Dlete_Modal'
                        data-schoolcd='{{$item->school_cd}}'
                        data-schooldivision='{{$item->school_division}}'
                        data-schoolname='{{$item->school_name}}'
                        data-tel='{{$item->tel}}'
                        data-hpurl='{{$item->hp_url}}'
                        data-mailaddress='{{$item->mailaddress}}'
                        data-deleteflg=@if($item->deleted_at) 0 @else 1 @endif>
                                    
                        @if($item->deleted_at)
                            <i class='far fa-thumbs-down'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-up'></i>
                        @else
                            <i class='far fa-thumbs-up'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-down'></i>
                        @endif
                    </button>             

                </td>
            </tr>

            
                
            @if(!is_null($majorsubject_m_list->where('school_cd', $item->school_cd)->first()))

            
                <tr class="majorsubject-tr school_cd_{{$item->school_cd}} d-none">
                    
                    <td>専攻CD</td>
                    <td>専攻名</td>
                    <td>期間(ヶ月)</td>
                    <td>備考</td>                    
                    <td></td>
                    
                </tr>
                @foreach ($majorsubject_m_list as $info)

                    @if($item->school_cd == $info->school_cd)
                        <tr class="majorsubject-tr school_cd_{{$item->school_cd}} d-none">
                            
                            <td>{{$info->majorsubject_cd}}</td>
                            <td>{{$info->majorsubject_name}}</td>                   
                            <td>{{$info->studyperiod}}</td>
                            <td>{{$info->remarks}}</td>                            
                            <td></td>
                        </tr>
                    @endif
            
                @endforeach

            </div>

            @endif

                
            

            @endforeach
        </table>
    </div>




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
                    
                    <form id="Saveform" method="post" action="{{ route('master.school.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                                                        
                            <input type="hidden" name="school_cd" id="school_cd" value="">                            
                                                        
                            <div class="form-group row">
                                <label for="school_division" class="col-md-6 col-form-label OriginalLabel">学校区分</label>                               
                                <select id='school_division' name='school_division' class='form-control input-sm'>
									<option value=''>
										@foreach($school_division_list as $item)
										<option value="{{$item->school_division_cd}}">
                                            {{$item->school_division_name}}
                                        </option>
										@endforeach
                                </select>
                               
                                <label for="school_name" class="col-md-6 col-form-label OriginalLabel">学校名</label>
                                <input type="text" name="school_name" id="school_name" value="" class="form-control col-md-3">

                                <label for="tel" class="col-md-6 col-form-label OriginalLabel">電話番号</label>
                                <input type="text" name="tel" id="tel" value="" class="form-control col-md-3">

                                <label for="hp_url" class="col-md-6 col-form-label OriginalLabel">HPのURL</label>
                                <input type="text" name="hp_url" id="hp_url" value="" class="form-control col-md-3">

                                <label for="mailaddress" class="col-md-6 col-form-label OriginalLabel">メールアドレス</label>
                                <input type="text" name="mailaddress" id="mailaddress" value="" class="form-control col-md-3">

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

                    <form id="Deleteform" method="post" action="">                    
                        @csrf
                        <div class="modal-body">  
                            <input type="hidden" id="delete_school_cd" name="delete_school_cd" value="">
                            <input type="hidden" id="delete_maincategory_name" name="delete_maincategory_name" value="">
                            <input type="hidden" id="delete_school_name" name="delete_school_name" value="">
            

                            <table class="Dlete_Modal_Table">
                                
                                <tr>
                                    <td class="Dlete_Modal_Table-Column">大分類名：</td> 
                                    <td class="Dlete_Modal_Table-Value"><span id="Display_Maincategory_Name"></span></td>                                                                       
                                </tr>

                                <tr>
                                    <td class="Dlete_Modal_Table-Column">中分類名：</td> 
                                    <td class="Dlete_Modal_Table-Value"><span id="Display_school_Name"></span></td>                                                                       
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

        $('#school_cd').val('');        
        $('#school_name').val('');
        $('#tel').val('');
        $('#hp_url').val('');
        $('#mailaddress').val(''); 

        // イベント発生元
        let evCon = $(e.relatedTarget);

        var school_cd = evCon.data('schoolcd');
        var school_division = evCon.data('schooldivision');
        var school_name = evCon.data('schoolname');
        var tel = evCon.data('tel');
        var hp_url = evCon.data('hpurl');
        var mailaddress = evCon.data('mailaddress');


        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');
        if(processflg == '0'){
            $('#Save_Modal_Title').html('登録処理');         
            $('#school_cd').val(0);            
            $('#Save_Modal_Button_Display').html('登録');
        }else{
            $('#Save_Modal_Title').html('更新処理（学校CD：' + school_cd + '）');   
            $('#school_cd').val(school_cd);            
            $('#Save_Modal_Button_Display').html('更新');
        }
        
     
        $('#school_division').val(school_division);
        $('#school_name').val(school_name); 
        $('#tel').val(tel);
        $('#hp_url').val(hp_url); 
        $('#mailaddress').val(mailaddress);
                
    });


    //削除モーダル表示時
    $('#Dlete_Modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var school_cd = evCon.data('schoolcd');
        var maincategory_name = evCon.data('maincategoryname');    
        var school_name = evCon.data('schoolname');    
        var deleteflg = evCon.data('deleteflg');

        if (deleteflg == 0) {
            var wording = "利用可能にする";
            $('#Deleteform').prop('action','{{ route('master.school.restore') }}')          
            $('#Dlete_Modal_RunButton').css({'background-color':'blue','border-color':'blue'});

        } else {
            var wording = "利用不可にする";     
            $('#Deleteform').prop('action','{{ route('master.school.delete') }}')
            $('#Dlete_Modal_RunButton').css({'background-color':'red','border-color':'red'});            
        }
    
        $('#Display_Maincategory_CD').html(maincategory_cd);    
        $('#Display_Maincategory_Name').html(maincategory_name);    
        $('#Display_school_Name').html(school_name);   
        $('.Dlete_Modal_Wording').html(wording);


        $('#delete_school_cd').val(school_cd);
        $('#delete_maincategory_name').val(maincategory_name);  
        $('#delete_school_name').val(school_name);  

    });


    
    $('.majorsubject_open_button').click(function () {

        
        var school_cd = $(this).data('schoolcd');

        $('.school_cd_' + school_cd).removeClass('d-none');		
        $('#majorsubject_open_button_' + school_cd).addClass('d-none');
        $('#majorsubject_close_button_' + school_cd).removeClass('d-none');

    });


    $('.majorsubject_close_button').click(function () {
        
        var school_cd = $(this).data('schoolcd');

        $('.school_cd_' + school_cd).addClass('d-none');
        $('#majorsubject_open_button_' + school_cd).removeClass('d-none');
        $('#majorsubject_close_button_' + school_cd).addClass('d-none');

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
                    errorsHtml += '<li class="text-left">' + data.status + ':' + errorThrown + '</li>';

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

