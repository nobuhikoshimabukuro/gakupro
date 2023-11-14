@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', '雇用形態マスタ')  
@endsection
@section('content')





<div id="main" class="mt-3 text-center container">
    
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row m-0">        

        <div class="col-6 text-start m-0 p-0">
            <h4 class="master-title">
                雇用形態マスタ
            </h4>
        </div>    

        <div class="col-6 text-end m-0 p-0">

            <button type="button" class='btn btn-link'>
                <a href="{{ route('master.index') }}">マスタ一覧へ</a>
            </button>


        </div>

        <div class="col-6 text-start m-0 p-0">
            <button type="button" class='btn btn-success search-modal-button' data-bs-toggle='modal' data-bs-target='#search-modal'></button>
        </div>

        <div class="col-6 text-end m-0 p-0">
            <button type="button" id="" class="btn btn-primary add-data-button"
                data-bs-toggle='modal' data-bs-target='#save-modal'            
                data-processflg='0'>
            </button>
        </div>      

    </div>    


    <div class="m-0 text-start">
        {{-- ページャー --}}                
        @if(count($employment_status_m_list) > 0)                                
          <div class="m-0">{{ $employment_status_m_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="data-display-area" class="scroll-wrap-x m-0">

       
       
        <table id='' class='data-info-table'>
            
            <tr>
                <th>雇用形態ID</th>
                <th>雇用形態名</th>
                <th>並び順</th>
                <th>件数【<span id='data-total-count'>{{count($employment_status_m_list)}}</span>件】</th>
            </tr>

            @foreach ($employment_status_m_list as $item)
            <tr>
                <td>{{$item->employment_status_id}}</td>
                <td>{{$item->employment_status_name}}</td>
                <td>{{$item->display_order}}</td>                

                <td>
                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#save-modal'
                        data-employmentstatusid='{{$item->employment_status_id}}'
                        data-employmentstatusname='{{$item->employment_status_name}}'
                        data-displayorder='{{$item->display_order}}'
                        data-processflg='1'> 
                        <i class='far fa-edit'></i>
                    </button>

                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#delete-modal'
                        data-employmentstatusid='{{$item->employment_status_id}}'
                        data-employmentstatusname='{{$item->employment_status_name}}'
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
                                
                                <label for="search_employment_status_name" class="col-12 col-form-label original-label">雇用形態名（あいまい）</label>
                                <input type="text" id="search_employment_status_name" name="search_employment_status_name" value="{{$search_element_array['search_employment_status_name']}}" class="form-control">
                                                        
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
                    
                    <form id="save-form" method="post" action="{{ route('master.employment_status.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                            
                            <input type="hidden" name="employment_status_id" id="employment_status_id">
                            
                            <div class="form-group row">
                                <label for="employment_status_name" class="col-md-6 col-form-label original-label">雇用形態名</label>
                                <input type="text" name="employment_status_name" id="employment_status_name" value="" class="form-control col-md-3">

                                <label for="display_order" class="col-md-6 col-form-label original-label">表示順</label>                                
                                <input type="text" name="display_order" id="display_order" value="" class="form-control col-md-3">

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

                    <form id="delete-form" method="post" action="{{ route('master.employment_status.delete_or_restore') }}">                           
                        @csrf
                        <div class="modal-body">  
                            <input type="hidden" id="delete_flg" name="delete_flg" value="">
                            <input type="hidden" id="delete_employment_status_id" name="delete_employment_status_id" value="">
                            <input type="hidden" id="delete_employment_status_name" name="delete_employment_status_name" value="">
            

                            <table class="w-100">

                                <tr>
                                    <td class="text-start">雇用形態ID</td>                             
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_employment_status_id"></span></td>
                                </tr>
                             
                                <tr>
                                    <td class="text-start">雇用形態名</td>                             
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_employment_status_name"></span></td>
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


        
      

    </div>
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){

    //備考モーダル
    $('#display_order_modal').on('show.bs.modal',function(e){
        // イベント発生元
        let evCon = $(e.relatedTarget);

        let employment_status_name = evCon.data('employment_statusname');
        let display_order = evCon.data('display_order');

        var title = employment_status_name + "の備考"
        $('#display_order_modal_title').html(title);
        $('#display_order_modal_display_order').val(display_order);
        
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

        var employment_status_id = evCon.data('employmentstatusid');
        var employment_status_name = evCon.data('employmentstatusname');
        var display_order = evCon.data('displayorder');
        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');

        
        var title ="";        

        $(button_id).removeClass('insert-button');
        $(button_id).removeClass('update-button');        
        
        if(processflg == '0'){
            title = "新規登録処理";
            $(button_id).addClass('insert-button');            
            $('#employment_status_id').val(0);
            
        }else{
            title = '更新処理（雇用形態ID：' + employment_status_id+'）';
            $(button_id).addClass('update-button');            
            $('#employment_status_id').val(employment_status_id);            
        }

        $('#save-modal-title').html(title);        
        $('#employment_status_name').val(employment_status_name); 
        $('#display_order').val(display_order);
        
    });


    //削除モーダル表示時
    $('#delete-modal').on('show.bs.modal', function(e) {

        var button_id = "#delete-modal-execution-button";

        // イベント発生元
        let evCon = $(e.relatedTarget);

        var employment_status_id = evCon.data('employmentstatusid');
        var employment_status_name = evCon.data('employmentstatusname');    
            
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

       
    
        $('#display_employment_status_id').html(employment_status_id);    
        $('#display_employment_status_name').html(employment_status_name);           


        $('#delete_flg').val(delete_flg);
        $('#delete_employment_status_id').val(employment_status_id);
        $('#delete_employment_status_name').val(employment_status_name);  

    });

    // 「クリア」ボタンがクリックされたら
    $('.clear-button').click(function () {

        var FormData = $("#search-form").serializeArray();        

        $.each(FormData, function(i, element) {		
            $("[name='"+ element.name +"']").val("");          
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

