@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', '求人公開用パスワード管理')  
@endsection
@section('content')


<style>

.password-sale-change-modal-open-button{
    /* padding: 2px;
    margin: 0 0 0 3px; */
}



 /* === ボタンを表示するエリア ============================== */
 .switch_area {
  line-height    : 30px;                /* 1行の高さ          */
  letter-spacing : 0;                   /* 文字間             */
  text-align     : center;              /* 文字位置は中央     */
  font-size      : 13px;                /* 文字サイズ         */
  position       : relative;            /* 親要素が基点       */
  margin         : auto;                /* 中央寄せ           */
  width          : 75px;               /* ボタンの横幅       */
  background     : transparent;                /* デフォルト背景色   */
}

 /* === チェックボックス ==================================== */
.switch_area input[type="checkbox"] {
  display        : none;            /* チェックボックス非表示 */
}




/* off時  start */

/* === チェックボックスのラベル ==================== */
.switch_area label {
  display        : block;               /* ボックス要素に変更 */
  box-sizing     : border-box;          /* 枠線を含んだサイズ */
  height         : 30px;                /* ボタンの高さ       */
  border         : 1px solid red;   /* 未選択タブのの枠線 */
  border-radius  : 15px;                /* 角丸               */
  background-color: white;
}

/* === 表示する文字 ================================ */
.switch_area label span:after{
  content        : "販売前";               /* 表示する文字       */
  padding        : 0 0 0 18px;          /* 表示する位置       */
  color          : red;             /* 文字色             */
}

/* === 丸部分のSTYLE =============================== */
.switch_area .switch_image {
  position       : absolute;            /* 親要素からの相対位置*/
  width          : 24px;                /* 丸の横幅           */
  height         : 24px;                /* 丸の高さ           */
  background     : red;             /* カーソルタブの背景 */
  top            : 3px;                 /* 親要素からの位置   */
  left           : 3px;                 /* 親要素からの位置   */
  border-radius  : 12px;                /* 角丸               */
  transition     : .1s;                 /* 滑らか変化         */  
}

/* off時  end */

/* on時  start */

  /* === チェックボックスのラベル（ONのとき） ================ */
  .on-class label {
    border-color   : #0d6efd;             /* 選択タブの枠線     */
  }

  /* === 表示する文字（ONのとき） ============================ */
  .on-class label span:after{
    content        : "販売済";                /* 表示する文字       */
    padding        : 0 20px 0 0px;          /* 表示する位置       */
    color          : #0d6efd;             /* 文字色             */
  }

  /* === 丸部分のSTYLE（ONのとき） =========================== */
  .on-class .switch_image {
    transform      : translateX(45px);    /* 丸も右へ移動       */
    background     : #0d6efd;             /* カーソルタブの背景 */    
  }
/* on時  end */

 
</style>



<div id="main" class="mt-3 text-center container">
    
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row m-0 mb-1 p-0">

        <div class="col-6 text-start">
            <h4 class="master-title">
                求人公開用パスワード管理
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
                
                <th>商品名</th>
                
                <th>パスワード</th>

                <th>
                    使用/販売状況                    
                </th>
                
                <th>加算日数</th>
                <th>
                    作成情報                    
                </th>

                <th>                    
                    販売情報
                </th>                
            </tr>

            @foreach ($job_password_t_list as $item)
            <tr>
                <td>
                    {{$item->job_password_id}}
                </td>

                <td>
                    {{$item->job_password_item_id}}:{{$item->job_password_item_name}}
                </td>

                <td>
                    {{$item->password}}
                </td>

                <td class="text-start">

                    @if($item->usage_flg == 1) 

                        使用中
                        <button class='btn btn-outline-info btn-sm m-0 p-1' data-bs-toggle='modal' data-bs-target='#remarks-modal'
                            data-jobpasswordid='{{$item->job_password_id}}'
                            data-employerid='{{$item->employer_id}}'
                            data-employername='{{$item->employer_name}}'
                            data-jobid='{{$item->job_id}}'
                            data-title='{{$item->title}}'
                            data-publishstartdate='{{$item->publish_start_date}}'
                            data-publishenddate='{{$item->publish_end_date}}'


                            data-createdby='{{$item->created_by}}'
                            data-createdat='{{$item->created_at}}'
                            data-createdstafflastname='{{$item->created_staff_last_name}}'
                            data-createdstafffirstname='{{$item->created_staff_first_name}}'
                            data-createdstafflastnameyomi='{{$item->created_staff_last_name_yomi}}'
                            data-createdstafffirstnameyomi='{{$item->created_staff_first_name_yomi}}'

                            data-seller='{{$item->seller}}'
                            data-saledatetime='{{$item->sale_datetime}}'
                            data-sellerstafflastname='{{$item->seller_staff_last_name}}'
                            data-sellerstafffirstname='{{$item->seller_staff_first_name}}'
                            data-sellerstafflastnameyomi='{{$item->seller_staff_last_name_yomi}}'
                            data-sellerstafffirstnameyomi='{{$item->seller_staff_first_name_yomi}}'
                            >詳細　
                            <i class='far fa-edit'></i>
                        </button>

                    @else 

                        <div id="switch{{$item->job_password_id}}" 
                            @if($item->sale_flg == 0) 
                                class="switch_area" 
                            @else
                                class="switch_area on-class" 
                            @endif                                                      
                            data-jobpasswordid='{{$item->job_password_id}}'
                            data-saleflg='{{$item->sale_flg}}'                            
                        >                            
                            <label><span></span></label>
                            <div class="switch_image"></div>
                        </div>                       
                    
                    @endif                    

                </td>

                <td>
                    {{$item->added_date}}
                </td>

                <td class="text-start">
                    作成者:{{$item->created_by}}:{{$item->created_staff_last_name}}　{{$item->created_staff_first_name}}
                    <br>
                    作成日時:{{$item->created_at}}
                </td>

                <td class="text-start">
                    @if($item->sale_flg == 1)
                        販売者:{{$item->seller}}:{{$item->seller_staff_last_name}}　{{$item->seller_staff_last_name}}
                        <br>
                        販売日時:{{$item->sale_datetime}}

                    @else
                        販売者:
                        <br>
                        販売日時:

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
                                
                                <label for="search_job_password_item_id" class="col-12 col-form-label original-label">商品</label>
                                <select id='search_job_password_item_id' name='search_job_password_item_id' class='form-control input-sm'>
									<option value=''></option>
										@foreach($job_password_item_list as $job_password_item_info)
										<option value="{{$job_password_item_info->job_password_item_id}}"
                                        @if($search_element_array['search_job_password_item_id'] == $job_password_item_info->job_password_item_id)  
                                        selected
                                        @endif  
                                        >
                                            {{$job_password_item_info->job_password_item_name}}
                                        </option>
										@endforeach
                                </select>

                                <label for="search_usage_flg" class="col-12 col-form-label original-label">使用状況</label>
                                <select id='search_usage_flg' name='search_usage_flg' class='form-control input-sm'>
									<option value=''></option>

                                    <option value='0'
                                    @if($search_element_array['search_usage_flg'] == 0)  
                                    selected
                                    @endif  
                                    >使用前</option>

                                    <option value='1'
                                    @if($search_element_array['search_usage_flg'] == 1)  
                                    selected
                                    @endif  
                                    >使用済</option>                                    
                                </select>


                                <label for="search_sale_flg" class="col-12 col-form-label original-label">販売状況</label>
                                <select id='search_sale_flg' name='search_sale_flg' class='form-control input-sm'>
									<option value=''></option>

                                    <option value='0'
                                    @if($search_element_array['search_sale_flg'] == 0)  
                                    selected
                                    @endif  
                                    >販売前</option>

                                    <option value='1'
                                    @if($search_element_array['search_sale_flg'] == 1)  
                                    selected
                                    @endif  
                                    >販売済</option>                                    
                                </select>
                                



                              
                                
                                <label for="search_created_by" class="col-12 col-form-label original-label">作成者</label>
                                <select id='search_created_by' name='search_created_by' class='form-control input-sm'>
									<option value=''></option>
										@foreach($staff_list as $created_by)
										<option value="{{$created_by->staff_id}}"
                                        @if($search_element_array['search_created_by'] == $created_by->staff_id)  
                                        selected
                                        @endif  
                                        >
                                            {{$created_by->staff_full_name}}
                                        </option>
										@endforeach
                                </select>

                                <label for="search_seller" class="col-12 col-form-label original-label">販売者</label>
                                <select id='search_seller' name='search_seller' class='form-control input-sm'>
									<option value=''></option>
										@foreach($staff_list as $seller)
										<option value="{{$seller->staff_id}}"
                                        @if($search_element_array['search_seller'] == $seller->staff_id)  
                                        selected
                                        @endif  
                                        >
                                            {{$seller->staff_full_name}}
                                        </option>
										@endforeach
                                </select>
                                                        
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
                            
                            <div class="form-group row">

                                <label for="create_password_count" class="col-md-6 col-form-label original-label">作成数</label>
                                <select id='create_password_count' name='create_password_count' class='form-control input-sm'>									                                                                           
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>                                    
                                </select>

                                <label for="job_password_item_id" class="col-md-6 col-form-label original-label">商品</label>
                                <select id='job_password_item_id' name='job_password_item_id' class='form-control input-sm'>
									
										@foreach($job_password_item_list as $job_password_item_info)                                            
                                            <option value="{{$job_password_item_info->job_password_item_id}}"
                                                @if($job_password_item_info->sale_flg == 0) disabled @endif
                                                >
                                                {{$job_password_item_info->job_password_item_name}}
                                            </option>
										@endforeach
                                </select>

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

        


        {{-- 備考モーダル --}}
        <div class="modal fade" id="remarks-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="remarks-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="remarks-modal-label"><span id="remarks-modal-title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg m-2">
                        
                    </div>
                    
                    
                    <div class="modal-body">                                
            
                        <table class="w-100">
                            
                            <tr>
                                <th class="text-start">雇用者情報</th>                                
                            </tr>

                            <tr>                                
                                <td class="employer_info text-start"></td>
                            </tr>

                            <tr>
                                <th class="text-start">求人情報</th>                                   
                            </tr>                            

                            <tr>                                
                                <td class="job_info text-start"></td>
                            </tr>
                            
                            <tr>
                                <th class="text-start">公開期間</th>                                
                            </tr>

                            <tr>                                
                                <td class="publish_date_info text-start"></td>
                            </tr>

                            <tr>
                                <th class="text-start">作成情報</th>                                
                            </tr>

                            <tr>                                
                                <td class="created_info text-start"></td>
                            </tr>

                            <tr>
                                <th class="text-start">販売情報</th>                                
                            </tr>

                            <tr>                                
                                <td class="seller_info text-start"></td>
                            </tr>

                            

                        </table>                        
                        
                    </div>



                    <div class="modal-footer">                            
                        <div class="col-6 m-0 p-0 text-start">
                                                    
                        </div>

                        <div class="col-6 m-0 p-0 text-end">
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
        $('#remarks').val(remarks);
        
    });

    

    //備考モーダル表示時
    $('#remarks-modal').on('show.bs.modal', function(e) {

      
        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');
        $('.remarks-area').html("");

        // イベント発生元
        let evCon = $(e.relatedTarget);

        var job_password_id = evCon.data('jobpasswordid');

        var employer_id = evCon.data('employerid');
        var employer_name = evCon.data('employername');

        var job_id = evCon.data('jobid');
        var title = evCon.data('title');

        var publish_start_date = evCon.data('publishstartdate');
        var publish_end_date = evCon.data('publishenddate');

        
        var created_by = evCon.data('createdby');
        var created_at = evCon.data('createdat');
        var created_staff_last_name = evCon.data('createdstafflastname');
        var created_staff_first_name = evCon.data('createdstafffirstname');
        var created_staff_last_name_yomi = evCon.data('createdstafflastnameyomi');
        var created_staff_first_name_yomi = evCon.data('createdstafffirstnameyomi');

        var seller = evCon.data('seller');
        var sale_datetime = evCon.data('saledatetime');        
        var seller_staff_last_name = evCon.data('sellerstafflastname');
        var seller_staff_first_name = evCon.data('sellerstafffirstname');
        var seller_staff_last_name_yomi = evCon.data('sellerstafflastnameyomi');
        var seller_staff_first_name_yomi = evCon.data('sellerstafffirstnameyomi');
        


        $('.employer_info').html(employer_id + ':' + employer_name);

        $('.job_info').html(job_id + ':' + title);
        
        $('.publish_date_info').html(publish_start_date + '～' + publish_end_date);
        
        $('.created_info').html(created_at + '<br>' + created_by + ":" + created_staff_last_name + created_staff_first_name);

        $('.seller_info').html(sale_datetime + '<br>' + seller + ":" + seller_staff_last_name + seller_staff_first_name);

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

                
                if(Result =='success'){

                    location.reload();

                }else if(Result =='non_session'){

                    // 店舗ログイン画面へ
				    window.location.href = "{{ route('headquarters.login') }}";

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


    $(document).on("click", ".switch_area", function (e) {
    
        var job_password_id = $(this).data("jobpasswordid");
        var sale_flg = $(this).data("saleflg");
        
        var message = "";    

        if (sale_flg == 0) {
            message = "パスワードを販売済み状態しますか？";     
        } else {
            message = "パスワードを販売前状態しますか？";     
        }

        if(!confirm(message)){     
        return false;
        }

        start_processing("#main");

        $.ajax({
                url: "{{ route('master.job_password.sale_flg_change') }}",
                type: 'post',
                dataType: 'json',
                data: {job_password_id : job_password_id , sale_flg : sale_flg},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
        // 送信成功
        .done(function (data, textStatus, jqXHR) {
            
            var result_array = data.result_array;

            var Result = result_array["Result"];
            
                        
            end_processing();

            if(Result =='success'){

                $("#switch" + job_password_id).removeClass("on-class");
            
            if (sale_flg == 0) {
                $("#switch" + job_password_id).addClass("on-class");
                $("#switch" + job_password_id).data("saleflg", 1);
            } else{
                $("#switch" + job_password_id).data("saleflg", 0);
            }

            location.reload();

            }else if(Result =='non_session'){

                // 本部ログイン画面へ
                window.location.href = "{{ route('headquarters.login') }}";

            }else{          
            

            }

        
        })

        // 送信失敗
        .fail(function (data, textStatus, errorThrown) {
            
            end_processing();
            


        });











    

    

  });























});

</script>
@endsection

