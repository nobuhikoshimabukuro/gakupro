@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', '住所')  
@endsection
@section('content')





<div id="main" class="mt-3 text-center container">
    
   <div class="row">

    @include('headquarters.common.alert')

    <div class="row">        

        <div class="col-6 text-start">
            <h4 class="master-title">
                住所マスタ
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


    <div class="row">


    </div>

    {{-- <div class="m-0 text-start "> --}}
    <div class="m-0 text-start scroll-wrap-x">
        {{-- ページャー --}}                
        @if(count($address_m_list) > 0)                                
          <div class="m-0">{{ $address_m_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="data-display-area" class="scroll-wrap-x m-0">

       
       
        <table id='' class='data-info-table'>
            
            <tr>
                <th>都道府県CD</th>
                <th>都道府県名</th>
                <th>市区町村CD</th>
                <th>市区町村名</th>
                <th>件数【<span id='data-total-count'>{{count($address_m_list)}}</span>件】</th>
            </tr>

            @foreach ($address_m_list as $item)
            <tr>
                <td>
                    {{$item->prefectural_cd}}
                </td>

                <td>
                    <ruby>{{$item->prefectural_name}}
                        <rt>{{$item->prefectural_name_kana}}</rt>
                    </ruby>                    
                </td>   

                <td>
                    {{$item->municipality_cd}}
                </td>

                <td>
                    <ruby>{{$item->municipality_name}}
                        <rt>{{$item->municipality_name_kana}}</rt>
                    </ruby>                    
                </td>  

                <td></td>
               
                

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
                                
                                <label for="search_prefectural_cd" class="col-12 col-form-label original-label">都道府県コード</label>
                                <input type="text" id="search_prefectural_cd" name="search_prefectural_cd" value="{{$search_element_array['search_prefectural_cd']}}" class="form-control">

                                <label for="search_prefectural_name" class="col-12 col-form-label original-label">都道府県名（あいまい）</label>
                                <input type="text" id="search_prefectural_name" name="search_prefectural_name" value="{{$search_element_array['search_prefectural_name']}}" class="form-control">
                                             
                                <label for="search_municipality_cd" class="col-12 col-form-label original-label">市区町村コード</label>
                                <input type="text" id="search_municipality_cd" name="search_municipality_cd" value="{{$search_element_array['search_municipality_cd']}}" class="form-control">

                                <label for="search_municipality_name" class="col-12 col-form-label original-label">市区町村名（あいまい）</label>
                                <input type="text" id="search_municipality_name" name="search_municipality_name" value="{{$search_element_array['search_municipality_name']}}" class="form-control">

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
                    
                    <form id="save-form" method="post" action="{{ route('master.address.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                            
                            <div class="form-group row">
                                最新の住所データCSVをダウンロードしてください。
                                
                                    <a href="https://postaladdress.jp/municipality/download" target="_blank">
                                        <button type="button" class="btn btn-secondary">郵政ダウンロードページ</button>
                                    </a>
                                ダウンロードページでは下記の項目にチェックを必ず入れてダウンロードしてください。
                                <ul>
                                    <li>市区町村コード</li>
                                    <li>市区町村名</li>
                                    <li>市区町村名カナ</li>
                                    <li>都道府県コード</li>
                                    <li>都道府県名</li>
                                    <li>都道府県名カナ</li>
                                </ul>
                                
                                

                            </div>   
                            
                            
                            <div class="form-group row">
                                <input type="file" name="csv_file" accept=".csv">

                            </div>                     
                     
                            
                        </div>

                        <div class="modal-footer row">                            
                            <div class="col-6 m-0 p-0 text-start">
                                <button type="button" id='save-button' class="btn btn-primary save-button">アップロード後登録</button>
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

        // FormDataオブジェクトを作成
        let formData = new FormData(f[0]);

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';

        $.ajax({
            url: f.prop('action'), // 送信先
            type: f.prop('method'),
            dataType: 'json',
            data: formData,
            processData: false, // データをシリアライズせずに送信
            contentType: false, // デフォルトのContent-Typeヘッダを使わない
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
                errorsHtml += '<li class="text-start">登録処理エラー</li>';
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

