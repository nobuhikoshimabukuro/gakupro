@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', '中分類マスタ')  
@endsection
@section('content')

<div id="main" class="mt-3 text-center container">
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row">        

        <div class="col-6 text-start">
            <h4 class="master-title">
                中分類マスタ
            </h4>
        </div>    

        <div class="col-6 text-end">

            <button type="button" class='original-button'>
                <a href="{{ route('master.index') }}">マスタ一覧へ</a>
            </button>
            
        </div>

        <div class="col-6 text-start">
            <button type="button" class='btn btn-success search-moda-button' data-bs-toggle='modal' data-bs-target='#search-modal'>検索する</button>
        </div>

        <div class="col-6 text-end">
            <button type="button" id="" class="btn btn-primary add-data-button"
                data-bs-toggle='modal' data-bs-target='#save-modal'            
                data-process_flg='0'>
            </button>
        </div>      

    </div>  

    <div class="m-0 text-start">
        {{-- ページャー --}}                
        @if(count($subcategory_m_list) > 0)                                
          <div class="m-0">{{ $subcategory_m_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="data-display-area" class="scroll-wrap-x m-0">

        <table id='' class='data-info-table'>
            
            <tr>
                <th>大分類名</th>
                <th>中分類名</th>            
                <th>件数【<span id='data-total-count'>{{count($subcategory_m_list)}}</span>件】</th>
            </tr>

            @foreach ($subcategory_m_list as $item)
            <tr>
                <td>{{$item->maincategory_name}}</td>
                <td>{{$item->subcategory_name}}</td>   
                <td>
                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#save-modal'                        
                        data-maincategorycd='{{$item->maincategory_cd}}'
                        data-subcategorycd='{{$item->subcategory_cd}}'                        
                        data-displayorder='{{$item->display_order}}'
                        data-subcategoryname='{{$item->subcategory_name}}'
                        data-process_flg='1'> 
                        <i class='far fa-edit'></i>
                    </button>

                    <button class='modal-button' data-bs-toggle='modal' data-bs-target='#delete-modal'
                        data-maincategorycd='{{$item->maincategory_cd}}'
                        data-subcategorycd='{{$item->subcategory_cd}}'
                        data-maincategoryname='{{$item->maincategory_name}}'
                        data-subcategoryname='{{$item->subcategory_name}}'
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
                                
                                <label for="search_maincategory_cd" class="col-12 col-form-label original-label">大分類選択</label>
                                <select id='search_maincategory_cd' name='search_maincategory_cd' class='form-control input-sm'>
                                    <option value=''>未選択</option>
                                        @foreach($maincategory_m_list as $item)
                                        <option value="{{$item->maincategory_cd}}"@if($search_element_array['search_maincategory_cd'] == $item->maincategory_cd) selected @endif>
                                            {{$item->maincategory_name}}
                                        </option>
                                        @endforeach
                                </select>
                            
                                <label for="search_subcategory_name" class="col-12 col-form-label original-label">中分類名（あいまい）</label>
                                <input type="text" id="" name="search_subcategory_name" value="{{$search_element_array['search_subcategory_name']}}" class="form-control">                                              
                            
                            </div>     
                                                

                        </div>

                        <div class="modal-footer row">         

                            <div class="col-6 m-0 p-0 text-start">
                                
                                <button type="button" id="" class="btn btn-light clear-button"></button>
                                <button type="submit" id="" class="btn btn-success" onclick="return search_form_check();">検索 <i class="fas fa-search"></i></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary close-modal-button" data-bs-dismiss="modal"></button>
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
                    
                    <form id="save-form" method="post" action="{{ route('master.subcategory.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                            
                            <input type="hidden" name="subcategory_cd" id="subcategory_cd" value="">
                            <input type="hidden" name="process_flg" id="process_flg" value="">                            
                                                        
                            <div class="form-group row">
                                <label for="maincategory_name" class="col-md-6 col-form-label original-label">大分類名</label>
                               
                                <select id='maincategory_cd' name='maincategory_cd' class='form-control input-sm'>
									<option value=''>
										@foreach($maincategory_m_list as $item)
										<option value="{{$item->maincategory_cd}}">
                                            {{$item->maincategory_name}}
                                        </option>
										@endforeach
                                </select>
                               
                                <label for="subcategory_name" class="col-md-6 col-form-label original-label">中分類名</label>
                                <input type="text" name="subcategory_name" id="subcategory_name" value="" class="form-control col-md-3">

                                <label for="display_order" class="col-md-6 col-form-label original-label">表示順</label>
                                <input type="text" name="display_order" id="display_order" value="" class="form-control col-md-3">
                              </div>                     
                            <p></p>
                            
                        </div>

                        <div class="modal-footer row">                            
                            <div class="col-6 m-0 p-0 text-start">
                                <button type="button" id='save-button' class="btn btn-primary save-button"></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary close-modal-button" data-bs-dismiss="modal"></button>
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

                    <form id="delete-form" method="post" action="{{ route('master.subcategory.delete_or_restore') }}">                    
                        @csrf
                        <div class="modal-body">  
                            <input type="hidden" id="delete_flg" name="delete_flg" value="">
                            <input type="hidden" id="delete_maincategory_cd" name="delete_maincategory_cd" value="">
                            <input type="hidden" id="delete_subcategory_cd" name="delete_subcategory_cd" value="">
                            <input type="hidden" id="delete_maincategory_name" name="delete_maincategory_name" value="">
                            <input type="hidden" id="delete_subcategory_name" name="delete_subcategory_name" value="">
            

                            <table class="w-100">

                                <tr>
                                    <td class="text-start">大分類名</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_maincategory_name"></span></td>
                                </tr>
                             
                                <tr>
                                    <td class="text-start">中分類名</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="Display_Subcategory_Name"></span></td>
                                </tr>
    
                            </table>                           
                           
                        </div>

                        <div class="modal-footer row">                                                                                      
                            <div class="col-6 m-0 p-0 text-start">
                                <button type="submit" id='delete-modal-execution-button' class="original-button delete-modal-execution-button"><span class="delete-modal_wording"></span></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary close-modal-button" data-bs-dismiss="modal"></button>      
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

        var maincategory_cd = evCon.data('maincategorycd');
        var subcategory_cd = evCon.data('subcategorycd');

        var maincategory_name = evCon.data('maincategoryname');
        var subcategory_name = evCon.data('subcategoryname');

        var display_order = evCon.data('displayorder');

        //登録処理か更新処理か判断
        var process_flg = evCon.data('process_flg');


        $('#maincategory_cd').removeClass("impossible");

        if(process_flg == '0'){
            $('#save-modal-title').html('登録処理');         
            $('#subcategory_cd').val(0);            
                        

        }else{
            $('#save-modal-title').html('更新処理');   
            $('#subcategory_cd').val(subcategory_cd);            
            

            $('#maincategory_cd').addClass("impossible");
        }
        
        $('#process_flg').val(process_flg); 
        $('#maincategory_cd').val(maincategory_cd); 

        $('#subcategory_name').val(subcategory_name);
        $('#display_order').val(display_order);
        
    });


    //削除モーダル表示時
    $('#delete-modal').on('show.bs.modal', function(e) {
        // イベント発生元
        let evCon = $(e.relatedTarget);

        var maincategory_cd = evCon.data('maincategorycd');
        var subcategory_cd = evCon.data('subcategorycd');

        var maincategory_name = evCon.data('maincategoryname');    
        var subcategory_name = evCon.data('subcategoryname');    

        var delete_flg = evCon.data('deleteflg');

        $('#delete-modal-execution-button').removeClass('delete_button');
        $('#delete-modal-execution-button').removeClass('restore_button');        

        if (delete_flg == 0) {            
            var wording = "利用不可にする";                 
            $('#delete-modal-execution-button').addClass('delete_button');  

        } else {
            
            var wording = "利用可能にする";
            $('#delete-modal-execution-button').addClass('restore_button');  
        }
               
        $('#display_maincategory_name').html(maincategory_name);    
        $('#Display_Subcategory_Name').html(subcategory_name);   
        $('.delete-modal_wording').html(wording);

        $('#delete_flg').val(delete_flg);

        $('#delete_maincategory_cd').val(maincategory_cd);
        $('#delete_subcategory_cd').val(subcategory_cd);

        $('#delete_maincategory_name').val(maincategory_name);  
        $('#delete_subcategory_name').val(subcategory_name);  

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
                $('#save-button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';

            });

    });

});

</script>
@endsection

