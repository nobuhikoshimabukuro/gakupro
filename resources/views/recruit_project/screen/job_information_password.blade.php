@extends('recruit_project.common.layouts_afterlogin')

@section('pagehead')
@section('title', '求人毎掲載期間確認')  
@endsection
@section('content')





<div id="main" class="mt-3 text-center container">
    
   <div class="row">

        @include('recruit_project.common.alert')

        <div class="row">        

            <div class="col-6 text-start">
                <h4 class="master-title">
                    求人パスワード履歴
                </h4>
            </div>    


            <div class="col-6 text-end">
                <button type="button" class='btn btn-success search-modal-button' data-bs-toggle='modal' data-bs-target='#search-modal'></button>
            </div>

        </div>    


        <div class="row">


        </div>



        <div id="data-display-area" class="scroll-wrap-x m-0">

            
            
            <table id='' class='data-info-table'>
                
                <tr>
                    <th></th>
                    <th>掲載期間</th>                
                    <th></th>
                </tr>

                @foreach ($job_password_connection_t as $item)
                <tr>
                    <td>
                        {{$item->branch_number}}
                    </td>

                    
                

                    <td>                    
                    </td>
                    <td>                    
                    </td>
                    
                    

                </tr>

                @endforeach
            </table>

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

