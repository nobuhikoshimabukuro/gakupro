@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', '大分類マスタ')  
@endsection
@section('content')





<div id="Main" class="mt-3 text-center container">
    
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row">
        <div class="col-6 text-start">
            <h4 class="MasterTitle">
                大分類マスタ
            </h4>
        </div>

   
        <div algin='right' class="col-6 new_addition_button">
            <a href="" class="btn btn--red btn--radius btn--cubic" 
            data-bs-toggle='modal' data-bs-target='#save_modal'
            data-maincategorycd='新規登録時に自動採番'
            data-processflg='0'
            ><i class='fas fa-plus-circle'></i><span class="new_addition_button_name"></span></a>               
        </div>

    </div>

    <form id="SearchForm" class="row" action="" method="get">

        <div class="col-12">
    
            <div id="SearchFormArea" class="table_wrap m-0 p-0">
                <table id='' class='search_info_table'>
                    <tr>                
                        <th>大分類名</th>                                      
                        <th>
                            <a id="" class="original_button clear_button">クリア</a>  
                        </th>                    
                    </tr>

                    <tr>                        
                        <td>
                            <input type="text" id="" name="search_maincategory_name" value="{{$SearchElementArray['search_maincategory_name']}}" class="form-control">
                        </td>                
                        
                        <td>                         
                            <button type="submit" id="" class="original_button search_button" onclick="return SearchFormCheck();">検索 <i class="fas fa-search"></i></button>                                                                                              
                        </td>
                    </tr>

                </table>
            </div>
        
        </div>
             
    </form>

    <div class="m-0 text-start">
        {{-- ページャー --}}                
        @if(count($maincategory_m_list) > 0)                                
          <div class="m-0">{{ $maincategory_m_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="DataDisplayArea" class="table_wrap m-0">

       
       
        <table id='' class='data_info_table'>
            
            <tr>
                <th>大分類CD</th>
                <th>大分類名</th>            
                <th>件数【<span id='TotalCount'>{{count($maincategory_m_list)}}</span>件】</th>
            </tr>

            @foreach ($maincategory_m_list as $item)
            <tr>
                <td>{{$item->maincategory_cd}}</td>
                <td>{{$item->maincategory_name}}</td>   
                <td>
                    <button class='modal_button' data-bs-toggle='modal' data-bs-target='#save_modal'
                        data-maincategorycd='{{$item->maincategory_cd}}'
                        data-maincategoryname='{{$item->maincategory_name}}'
                        data-processflg='1'> 
                        <i class='far fa-edit'></i>
                    </button>

                    <button class='modal_button' data-bs-toggle='modal' data-bs-target='#dlete_modal'
                        data-maincategorycd='{{$item->maincategory_cd}}'
                        data-maincategoryname='{{$item->maincategory_name}}'
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
                    
                    <form id="save_form" method="post" action="{{ route('master.maincategory.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                            
                            <input type="hidden" name="maincategory_cd" id="maincategory_cd">
                            
                            <div class="form-group row">
                                <label for="maincategory_name" class="col-md-6 col-form-label original-label">大分類名</label>
                                <input type="text" name="maincategory_name" id="maincategory_name" value="" class="form-control col-md-3">
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

                    <form id="delete_form" method="post" action="{{ route('master.maincategory.delete_or_restore') }}">                           
                        @csrf
                        <div class="modal-body">  
                            <input type="hidden" id="delete_flg" name="delete_flg" value="">
                            <input type="hidden" id="delete_maincategory_cd" name="delete_maincategory_cd" value="">
                            <input type="hidden" id="delete_maincategory_name" name="delete_maincategory_name" value="">
            

                            <tr>
                                <td class="text-start">大分類CD</td>                                
                            </tr>

                            <tr>                                
                                <td class="text-start"><span id="display_maincategory_cd"></span></td>
                            </tr>
                         
                            <tr>
                                <td class="text-start">大分類名称</td>                                
                            </tr>

                            <tr>                                
                                <td class="text-start"><span id="display_maincategory_name"></span></td>
                            </tr>

               

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

        // イベント発生元
        let evCon = $(e.relatedTarget);

        var maincategory_cd = evCon.data('maincategorycd');
        var maincategory_name = evCon.data('maincategoryname');

          


        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');
        if(processflg == '0'){
            $('#save_modal_title').html('新規登録処理');
            $('#maincategory_cd_display').val(maincategory_cd);
            $('#maincategory_cd').val(0);
            $('#save_modal_button_display').html('登録');
        }else{
            $('#save_modal_title').html('更新処理（大分類CD：' + maincategory_cd+'）');
            $('#maincategory_cd_display').val(maincategory_cd);
            $('#maincategory_cd').val(maincategory_cd);
            $('#save_modal_button_display').html('更新');
        }

        
        $('#maincategory_name').val(maincategory_name); 
        
    });


    //削除モーダル表示時
    $('#dlete_modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var maincategory_cd = evCon.data('maincategorycd');
        var maincategory_name = evCon.data('maincategoryname');    
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

       
    
        $('#display_maincategory_cd').html(maincategory_cd);    
        $('#display_maincategory_name').html(maincategory_name);    
        $('.dlete_modal_wording').html(wording);


        $('#delete_flg').val(delete_flg);
        $('#delete_maincategory_cd').val(maincategory_cd);
        $('#delete_maincategory_name').val(maincategory_name);  

    });

    // 「クリア」ボタンがクリックされたら
    $('.clear_button').click(function () {

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

