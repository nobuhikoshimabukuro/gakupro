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
                    <input type="text" name="mailaddress" id="mailaddress" value="" class="form-control text-left">
                </div>

                <div class="col-4 text-left">
                    <button type="button" id='SendMailButton' class="btn btn-secondary">メール送信</button>
                </div>      
            </div>       

            <div class="row">                    
                <div class="col-4 text-right">
                  
                </div>
                <div id="Message-Area" class="col-4">                    
                                      
                </div>

                <div class="col-4 text-left">
                  
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


    $(document).ready(function () {        
        $('#mailaddress').focus();
    });
    

    $("#SendMailForm").keypress(function(e) {
        if(e.which == 13) {            
            // 判定
            if( document.getElementById("SendMailButton") == document.activeElement ){
                
                SendMail();
            
            }else if( document.getElementById("mailaddress") == document.activeElement ){

                $('#SendMailButton').focus();
                return false;         
            }else{
                return false;
            }            
        }
    });


    $(document).on("click", "#SendMailButton", function (e) {
        SendMail();
    });



    function SendMail(){

    //{{-- メッセージクリア --}}
    $('#Message-Area').html('');
        $('.is-invalid').removeClass('is-invalid');

        var mailaddress = $("#mailaddress").val();        

        if(mailaddress == ""){
            $("#mailaddress").addClass("is-invalid");   
            $('#mailaddress').focus();               
            return false;
        }
        
        let f = $('#SendMailForm');

        phpProcessingStart();

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

                phpProcessingEnd();

                if(Result=='success'){

                    // location.reload();

                    

                    //{{-- アラートメッセージ表示 --}}
                    var errorsHtml = '';
                    errorsHtml = '<div class="text-left">';
                    errorsHtml += 'メールを送信しました。';
                    errorsHtml += '</div>';

                        //{{-- アラート --}}
                    $('#Message-Area').html(errorsHtml);
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
                    $('#Message-Area').html(errorsHtml);
                    //{{-- 画面上部へ --}}

                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");                 

                }

            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
                phpProcessingEnd();
                
                //{{-- アラートメッセージ表示 --}}
                var errorsHtml = '';
                    errorsHtml = '<div class="alert alert-danger text-left">';
                    errorsHtml += '<li class="text-left">メール送信処理でエラーが発生しました。</li>';
                    errorsHtml += '</div>';

                //{{-- アラート --}}
                $('#Message-Area').html(errorsHtml);
                //{{-- 画面上部へ --}}
                $("html,body").animate({
                    scrollTop: 0
                }, "300");
               

            });


    }




 

    

    





});

</script>
@endsection

