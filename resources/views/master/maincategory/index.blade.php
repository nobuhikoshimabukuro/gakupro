@extends('common.layouts_app')

@section('pagehead')
@section('title', '大分類マスタ')  
@endsection
@section('content')

<div class="mt-3 text-center container">
   <div class="row">

    @include('common.alert')

    <div class="row">
        <div class="col-4 text-left">
            <h4 class="MasterTitle">
                大分類マスタ
            </h4>
        </div>

        <div class="col-4">         
        </div>

        <div algin='right' class="col-4 NewAddition-Button">
            <a href="" class="btn btn--red btn--radius btn--cubic" 
            data-bs-toggle='modal' data-bs-target='#Save_Modal'
            data-maincategorycd='新規登録時に自動採番'
            data-processflg='0'
            ><i class='fas fa-plus-circle'></i>　新規追加</a>               
        </div>

    </div>


        <table id='' class='DataInfoTable'>
            
            <tr>
                <th>大分類CD</th>
                <th>大分類名</th>            
                <th>件数【<span id='TotalNumber'>{{$maincategory_m_list->count()}}</span>件】</th>
            </tr>

            @foreach ($maincategory_m_list as $item)
            <tr>
                <td>{{$item->maincategory_cd}}</td>
                <td>{{$item->maincategory_name}}</td>   
                <td>
                    <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#Save_Modal'
                        data-maincategorycd='{{$item->maincategory_cd}}'
                        data-maincategoryname='{{$item->maincategory_name}}'
                        data-processflg='1'> 
                        <i class='far fa-edit'></i>
                    </button>

                    <button class='ModalButton' data-bs-toggle='modal' data-bs-target='#Dlete_Modal'
                        data-maincategorycd='{{$item->maincategory_cd}}'
                        data-maincategoryname='{{$item->maincategory_name}}'
                        data-deleteflg=@if($item->deleted_at) 0 @else 1 @endif>
                                    
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




        {{-- 登録/更新用モーダル --}}
        <div class="modal fade" id="Save_Modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="Save_Modal_Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="Save_Modal_Label"><span id="Save_Modal_Title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg m-2">
                        @include('common.alert')
                    </div>
                    
                    <form id="Saveform" method="post" action="{{ route('master.maincategory.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                            
                            <input type="hidden" name="maincategory_cd" id="maincategory_cd">
                            
                            <div class="form-group row">
                                <label for="maincategory_name" class="col-md-6 col-form-label OriginalLabel">大分類名</label>
                                <input type="text" name="maincategory_name" id="maincategory_name" value="" class="form-control col-md-3">
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
                            <input type="hidden" id="delete_maincategory_cd" name="delete_maincategory_cd" value="">
                            <input type="hidden" id="delete_maincategory_name" name="delete_maincategory_name" value="">
            

                            <table class="Dlete_Modal_Table">

                                <tr>
                                    <td class="Dlete_Modal_Table-Column">大分類CD：</td>
                                    <td class="Dlete_Modal_Table-Value"><span id="Display_Maincategory_CD"></span></td>
                                </tr>
                                <tr>
                                    <td class="Dlete_Modal_Table-Column">大分類名称：</td> 
                                    <td class="Dlete_Modal_Table-Value"><span id="Display_Maincategory_Name"></span></td>                                                                       
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

        // イベント発生元
        let evCon = $(e.relatedTarget);

        var maincategory_cd = evCon.data('maincategorycd');
        var maincategory_name = evCon.data('maincategoryname');

          


        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');
        if(processflg == '0'){
            $('#Save_Modal_Title').html('新規登録処理');
            $('#maincategory_cd_display').val(maincategory_cd);
            $('#maincategory_cd').val(0);
            $('#Save_Modal_Button_Display').html('登録');
        }else{
            $('#Save_Modal_Title').html('更新処理（大分類CD：' + maincategory_cd+'）');
            $('#maincategory_cd_display').val(maincategory_cd);
            $('#maincategory_cd').val(maincategory_cd);
            $('#Save_Modal_Button_Display').html('更新');
        }

        
        $('#maincategory_name').val(maincategory_name); 
        
    });


    //削除モーダル表示時
    $('#Dlete_Modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var maincategory_cd = evCon.data('maincategorycd');
        var maincategory_name = evCon.data('maincategoryname');    
        var deleteflg = evCon.data('deleteflg');
    
        if (deleteflg == 0) {
            var wording = "利用可能にする";
            $('#Deleteform').prop('action','{{ route('master.maincategory.restore') }}')
            $('#Dlete_Modal_RunButton').css({'background-color':'blue','border-color':'blue'});

        } else {
            var wording = "利用不可にする";     
            $('#Deleteform').prop('action','{{ route('master.maincategory.delete') }}')
            $('#Dlete_Modal_RunButton').css({'background-color':'red','border-color':'red'});
        }
    
        $('#Display_Maincategory_CD').html(maincategory_cd);    
        $('#Display_Maincategory_Name').html(maincategory_name);    
        $('.Dlete_Modal_Wording').html(wording);


        $('#delete_maincategory_cd').val(maincategory_cd);
        $('#delete_maincategory_name').val(maincategory_name);  

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

