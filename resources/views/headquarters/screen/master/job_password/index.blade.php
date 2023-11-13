@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', '求人公開用パスワード')  
@endsection
@section('content')





<div id="main" class="mt-3 text-center container">
    
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row">        

        <div class="col-6 text-start">
            <h4 class="master-title">
                求人公開用パスワード
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
        @if(count($job_password_t_list) > 0)                                
          <div class="m-0">{{ $job_password_t_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="data-display-area" class="scroll-wrap-x m-0">

       
       
        <table id='' class='data-info-table'>
            
            <tr>
                <th>ID</th>
                <th>商品の種類</th>
                <th>パスワード</th>
                <th>使用状況</th>
                <th>販売状況</th>
                <th>表示日数</th>
                <th>作成者/作成日</th>
                <th>件数【<span id='data-total-count'>{{count($job_password_t_list)}}</span>件】</th>
            </tr>

            @foreach ($job_password_t_list as $item)
            <tr>
                <td>{{$item->job_password_id}}</td>
                <td>{{$item->product_type}}</td>
                <td>{{$item->password}}</td>
                <td>{{$item->usage_status}}</td>
                <td>{{$item->sold_status}}</td>
                <td>{{$item->date_range}}</td>
                <td>
                    {{$item->created_by}}:{{$item->created_by_name}}
                    <br>
                    {{$item->created_at}}
                </td>    
                
                <td>

                    @if($item->usage_flg == 1)
                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#remarks-modal'
                            data-employerid='{{$item->employer_id}}'
                            data-employername='{{$item->employer_name}}'
                            data-jobid='{{$item->job_id}}'
                            data-title='{{$item->title}}'
                            data-publishstartdate='{{$item->publish_start_date}}'
                            data-publishenddate='{{$item->publish_end_date}}'
                            > 
                            <i class='far fa-edit'></i>
                    </button>
                    @endif
                
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
                                
                                <label for="search_job_password_name" class="col-12 col-form-label original-label">プロジェクト名（あいまい）</label>
                                <input type="text" id="search_job_password_name" name="search_job_password_name" value="{{$search_element_array['search_product_type']}}" class="form-control">
                                                        
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
                    
                    <form id="save-form" method="post" action="{{ route('master.job_password.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                            
                            <input type="hidden" name="job_password_id" id="job_password_id">
                            
                            <div class="form-group row">
                                <label for="create_password_count" class="col-md-6 col-form-label original-label">作成数</label>
                                <input type="text" name="create_password_count" id="create_password_count" value="" class="form-control col-md-3">                               

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

        var job_password_id = evCon.data('job_passwordid');
        var job_password_name = evCon.data('job_passwordname');
        var remarks = evCon.data('remarks');
        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');

        
        var title ="";        

        $(button_id).removeClass('insert-button');
        $(button_id).removeClass('update-button');        
        
        if(processflg == '0'){
            title = "新規登録処理";
            $(button_id).addClass('insert-button');            
            $('#job_password_id').val(0);
            
        }else{
            title = '更新処理（プロジェクトID：' + job_password_id+'）';
            $(button_id).addClass('update-button');            
            $('#job_password_id').val(job_password_id);            
        }

        $('#save-modal-title').html(title);        
        $('#job_password_name').val(job_password_name); 
        $('#remarks').val(remarks);
        
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

