@extends('recruitproject.common.layouts_beforelogin')

@section('pagehead')
@section('title', 'メールアドレス仮登録画面')  
@endsection
@section('content')

<style>
   
    
    
    
</style>

<div class="mt-3 text-center container">
    
    <div class="ajax-msg"></div>
    <form action="{{ route('recruitproject.mailaddress_temporary_registration_process') }}" id='SendMailForm' method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">                    

            <div class="row">                    
                <div class="col-4 text-right">
                    <label for="" class="col-form-label OriginalLabel">メールアドレス</label>
                </div>
                <div class="col-4">                    
                    <input type="text" name="mailaddress" id="mailaddress" value="" class="form-control text-right">
                </div>

                <div class="col-4 text-left">
                    <button type="button" id='SendMailButton' class="btn btn-secondary">メール送信</button>
                </div>      
            </div>       
           

        </div>      

        {{-- @php phpinfo() @endphp --}}
        
        


    </form>
    
</div>

@endsection

@section('pagejs')
<script src="{{ asset('js/common.js') }}"></script>
<script type="text/javascript">

$(function(){


    
    

    $("#SendMailForm").keypress(function(e) {
        if(e.which == 13) {
            return false;
        }
    });

    
    $('#SendMailButton').click(function () {

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.is-invalid').removeClass('is-invalid');

        var mailaddress = $("#mailaddress").val();        

        if(mailaddress == ""){
            $("#mailaddress").addClass("is-invalid");                  
            return false;
        }
        
        let f = $('#SendMailForm');

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
                
                //{{-- ボタン有効 --}}
                $('#SendMailButton').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';


                var ResultArray = data.ResultArray;

                var Result = ResultArray["Result"];

                if(Result=='success'){

                    // location.reload();

                    

                    //{{-- アラートメッセージ表示 --}}
                    var errorsHtml = '';
                    errorsHtml = '<div class="alert alert-danger text-left">';
                    errorsHtml += '<li class="text-left">登録成功</li>';
                    errorsHtml += '</div>';

                        //{{-- アラート --}}
                    $('.ajax-msg').html(errorsHtml);
                    //{{-- 画面上部へ --}}

                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");          


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

                }

            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
                //{{-- ボタン有効 --}}
                $('#SendMailButton').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';

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
                    // errorsHtml += '<li class="text-left">' + data.status + ':' + errorThrown + '</li>';
                    errorsHtml += '<li  class="text-left">エラーが発生しました</li>';

                }

                errorsHtml += '</div>';
                
                //{{-- アラート --}}
                $('.ajax-msg').html(errorsHtml);
                //{{-- 画面上部へ --}}
                $("html,body").animate({
                    scrollTop: 0
                }, "300");
               

            });

    });

    

    





});

</script>
@endsection

