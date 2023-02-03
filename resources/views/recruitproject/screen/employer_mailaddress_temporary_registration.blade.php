@extends('recruitproject.common.layouts_beforelogin')

@section('pagehead')
@section('title', 'メールアドレス仮登録画面')  
@endsection
@section('content')

<style>
   
    
    
    
</style>

<div id="Main" class="mt-3 text-center container">
    
    <div class="ajax-msg"></div>
    <form action="{{ route('recruitproject.mailaddress_temporary_registration_process') }}" id='SendMailForm' method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">                    

            <div id="Input-Area"class="row">                    
                <div class="col-4 text-right">
                    <label for="" class="col-form-label original-label">メールアドレス</label>
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

    </form>
    
</div>

@endsection

@section('pagejs')

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
        

        var display_html = '';
            display_html = '<div class="alert alert-danger text-left">';
            display_html += '<li class="text-left">メール送信中</li>';
            display_html += '</div>';
        $('#Message-Area').html(display_html);

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
                
                var ResultArray = data.ResultArray;

                var Result = ResultArray["Result"];

                phpProcessingEnd();

                if(Result=='success'){
                    
                    display_html = '<div class="text-left">';
                    display_html += 'メールを送信しました。';
                    display_html += '</div>';

                    $('#Message-Area').html(display_html);                   

                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");          


                }else{

                    var ErrorMessage = ResultArray["Message"];

                    
                    
                    display_html = '<div class="alert alert-danger text-left">';
                    display_html += '<li class="text-left">' + ErrorMessage + '</li>';
                    display_html += '</div>';

                        //{{-- アラート --}}
                    $('#Message-Area').html(display_html);
                    //{{-- 画面上部へ --}}

                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");                 

                }

            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
                phpProcessingEnd();
                
                
                display_html = '<div class="alert alert-danger text-left">';
                display_html += '<li class="text-left">メール送信処理でエラーが発生しました。</li>';
                display_html += '</div>';

                //{{-- アラート --}}
                $('#Message-Area').html(display_html);
                //{{-- 画面上部へ --}}
                $("html,body").animate({
                    scrollTop: 0
                }, "300");
               

            });


    }




 

    

    





});

</script>
@endsection

