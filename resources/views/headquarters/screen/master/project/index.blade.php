@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'プロジェクトマスタ')  
@endsection
@section('content')





<div id="main" class="mt-3 text-center container">
    
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row m-0 p-0">

        <div class="col-6 text-start">
            <h4 class="master-title">
                プロジェクトマスタ
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
        @if(count($project_m_list) > 0)                                
          <div class="m-0">{{ $project_m_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="data-display-area" class="scroll-wrap-x m-0">

       
       
        <table id='' class='data-info-table'>
            
            <tr>
                <th>プロジェクトID</th>
                <th>プロジェクト名</th>
                <th>備考</th>
                <th>件数【<span id='data-total-count'>{{count($project_m_list)}}</span>件】</th>
            </tr>

            @foreach ($project_m_list as $item)
            <tr>
                <td>{{$item->project_id}}</td>
                <td>{{$item->project_name}}</td>   
               
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
                        data-projectid="{{$item->project_id}}"
                        data-projectname='{{$item->project_name}}'
                        data-remarks='{{$item->remarks}}'											
                        >{{$remarks_button_name}}                  
                   
                    @endif                  
                
                </td>

                <td>
                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#save-modal'
                        data-projectid='{{$item->project_id}}'
                        data-projectname='{{$item->project_name}}'
                        data-remarks='{{$item->remarks}}'
                        data-processflg='1'> 
                        <i class='far fa-edit'></i>
                    </button>

                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#delete-modal'
                        data-projectid='{{$item->project_id}}'
                        data-projectname='{{$item->project_name}}'
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
                                
                                <label for="search_project_name" class="col-12 col-form-label original-label">プロジェクト名（あいまい）</label>
                                <input type="text" id="search_project_name" name="search_project_name" value="{{$search_element_array['search_project_name']}}" class="form-control">
                                                        
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
                    
                    <form id="save-form" method="post" action="{{ route('master.project.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                            
                            <input type="hidden" name="project_id" id="project_id">
                            
                            <div class="form-group row">
                                <label for="project_name" class="col-md-6 col-form-label original-label">プロジェクト名</label>
                                <input type="text" name="project_name" id="project_name" value="" class="form-control col-md-3">

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

                    <form id="delete-form" method="post" action="{{ route('master.project.delete_or_restore') }}">                           
                        @csrf
                        <div class="modal-body">  
                            <input type="hidden" id="delete_flg" name="delete_flg" value="">
                            <input type="hidden" id="delete_project_id" name="delete_project_id" value="">
                            <input type="hidden" id="delete_project_name" name="delete_project_name" value="">
            

                            <table class="w-100">

                                <tr>
                                    <td class="text-start">プロジェクトID</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_project_id"></span></td>
                                </tr>
                             
                                <tr>
                                    <td class="text-start">プロジェクト名称</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_project_name"></span></td>
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

        let project_name = evCon.data('projectname');
        let remarks = evCon.data('remarks');

        var title = project_name + "の備考"
        $('#remarks_modal_title').html(title);
        $('#remarks_modal_remarks').val(remarks);
        
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

        var project_id = evCon.data('projectid');
        var project_name = evCon.data('projectname');
        var remarks = evCon.data('remarks');
        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');

        
        var title ="";        

        $(button_id).removeClass('insert-button');
        $(button_id).removeClass('update-button');        
        
        if(processflg == '0'){
            title = "新規登録処理";
            $(button_id).addClass('insert-button');            
            $('#project_id').val(0);
            
        }else{
            title = '更新処理（プロジェクトID：' + project_id+'）';
            $(button_id).addClass('update-button');            
            $('#project_id').val(project_id);            
        }

        $('#save-modal-title').html(title);        
        $('#project_name').val(project_name); 
        $('#remarks').val(remarks);
        
    });


    //削除モーダル表示時
    $('#delete-modal').on('show.bs.modal', function(e) {

        var button_id = "#delete-modal-execution-button";

        // イベント発生元
        let evCon = $(e.relatedTarget);

        var project_id = evCon.data('projectid');
        var project_name = evCon.data('projectname');    
        var deleteflg = evCon.data('deleteflg');
    
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

       
    
        $('#display_project_id').html(project_id);    
        $('#display_project_name').html(project_name);           


        $('#delete_flg').val(delete_flg);
        $('#delete_project_id').val(project_id);
        $('#delete_project_name').val(project_name);  

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

