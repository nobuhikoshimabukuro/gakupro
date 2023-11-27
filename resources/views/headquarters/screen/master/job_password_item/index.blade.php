@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', '求人パスワード商品マスタ')  
@endsection
@section('content')





<div id="main" class="mt-3 text-center container">
    
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row m-0 p-0">

        <div class="col-6 text-start">
            <h4 class="master-title">
                求人パスワード商品マスタ
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
        @if(count($job_password_item_m_list) > 0)                                
          <div class="m-0">{{ $job_password_item_m_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="data-display-area" class="scroll-wrap-x m-0">

       
       
        <table id='' class='data-info-table'>
            
            <tr>
                <th>商品ID</th>
                <th>商品名</th>
                <th>料金</th>
                <th>求人公開加算日</th>
                <th>販売期間</th>
                <th>件数【<span id='data-total-count'>{{count($job_password_item_m_list)}}</span>件】</th>
            </tr>

            @foreach ($job_password_item_m_list as $item)

            <tr>
                <td>{{$item->job_password_item_id}}</td>
                <td class="text-start">{{$item->job_password_item_name}}</td>
                <td class="text-end">{{number_format($item->price)}}円</td>
                <td class="text-center">{{$item->added_date}}</td>
                <td>{{$item->sales_start_date}}～{{$item->sales_end_date}}</td>
               
                
                

                <td>
                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#save-modal'
                        data-jobpassworditemid='{{$item->job_password_item_id}}'
                        data-jobpassworditemname='{{$item->job_password_item_name}}'
                        data-price='{{$item->price}}'
                        data-addeddate='{{$item->added_date}}'
                        data-salesstartdate='{{$item->sales_start_date}}'
                        data-salesenddate='{{$item->sales_end_date}}'
                        data-remarks='{{$item->remarks}}'
                        data-processflg='1'> 
                        <i class='far fa-edit'></i>
                    </button>

                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#delete-modal'
                        data-jobpassworditemid='{{$item->job_password_item_id}}'
                        data-jobpassworditemname='{{$item->job_password_item_name}}'
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
                                
                                <label for="search_job_password_item_name" class="col-12 col-form-label original-label">求人パスワード商品名（あいまい）</label>
                                <input type="text" id="search_job_password_item_name" name="search_job_password_item_name" value="{{$search_element_array['search_job_password_item_name']}}" class="form-control">
                                                        
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
                    
                    <form id="save-form" method="post" action="{{ route('master.job_password_item.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                            
                            <input type="hidden" name="job_password_item_id" id="job_password_item_id">
                            
                            <div class="form-group row">

                                <label for="job_password_item_name" class="col-md-6 col-form-label original-label">商品名</label>
                                <input type="text" name="job_password_item_name" id="job_password_item_name" value="" class="form-control col-md-3">

                                <label for="price" class="col-md-6 col-form-label original-label">料金（円）</label>
                                <input type="text" name="price" id="price" value="" class="form-control col-md-3">

                                <label for="added_date" class="col-md-6 col-form-label original-label">求人公開加算日</label>
                                <input type="text" name="added_date" id="added_date" value="" class="form-control col-md-3">

                                <label for="sales_start_date" class="col-md-6 col-form-label original-label">販売開始日</label>
                                <input type="date" name="sales_start_date" id="sales_start_date" value="" class="form-control col-md-3">

                                <label for="sales_end_date" class="col-md-6 col-form-label original-label">販売終了日</label>
                                <input type="date" name="sales_end_date" id="sales_end_date" value="" class="form-control col-md-3">

                                <label for="remarks" class="col-md-6 col-form-label original-label">備考</label>
                                <textarea id="remarks" class="form-control col-md-3" rows="4" cols="40"></textarea>                                

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

                    <form id="delete-form" method="post" action="{{ route('master.job_password_item.delete_or_restore') }}">                           
                        @csrf
                        <div class="modal-body">  
                            <input type="hidden" id="delete_flg" name="delete_flg" value="">
                            <input type="hidden" id="delete_job_password_item_id" name="delete_job_password_item_id" value="">
                            <input type="hidden" id="delete_job_password_item_name" name="delete_job_password_item_name" value="">
            

                            <table class="w-100">

                                <tr>
                                    <td class="text-start">求人パスワード商品ID</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_job_password_item_id"></span></td>
                                </tr>
                             
                                <tr>
                                    <td class="text-start">求人パスワード商品名称</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_job_password_item_name"></span></td>
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

        var job_password_item_id = evCon.data('jobpassworditemid');
        var job_password_item_name = evCon.data('jobpassworditemname');
        var price = evCon.data('price');
        var added_date = evCon.data('addeddate');
        var sales_start_date = evCon.data('salesstartdate');
        var sales_end_date = evCon.data('salesenddate');
        var remarks = evCon.data('remarks');

        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');        
        var title ="";        

        $(button_id).removeClass('insert-button');
        $(button_id).removeClass('update-button');        
        
        if(processflg == '0'){
            title = "新規登録処理";
            $(button_id).addClass('insert-button');            
            job_password_item_id = 0;
            
        }else{
            title = '更新処理（求人パスワード商品ID：' + job_password_item_id+'）';
            $(button_id).addClass('update-button');                                   
        }

        $('#save-modal-title').html(title);        

        $('#job_password_item_name').val(job_password_item_name);
        $('#job_password_item_name').val(job_password_item_name);
        $('#price').val(price);
        $('#added_date').val(added_date);
        $('#sales_start_date').val(sales_start_date);
        $('#sales_end_date').val(sales_end_date);
        $('#remarks').val(remarks);        
        
    });


    //削除モーダル表示時
    $('#delete-modal').on('show.bs.modal', function(e) {

        var button_id = "#delete-modal-execution-button";

        // イベント発生元
        let evCon = $(e.relatedTarget);

        var job_password_item_id = evCon.data('jobpassworditemid');
        var job_password_item_name = evCon.data('jobpassworditemname');    
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

       
    
        $('#display_job_password_item_id').html(job_password_item_id);    
        $('#display_job_password_item_name').html(job_password_item_name);           


        $('#delete_flg').val(delete_flg);
        $('#delete_job_password_item_id').val(job_password_item_id);
        $('#delete_job_password_item_name').val(job_password_item_name);  

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

