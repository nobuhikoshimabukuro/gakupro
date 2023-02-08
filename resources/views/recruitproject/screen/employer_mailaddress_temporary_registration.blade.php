@extends('recruitproject.common.layouts_beforelogin')

@section('pagehead')
@section('title', 'メールアドレス仮登録画面')  
@endsection
@section('content')

<style>
   
    
    
    
</style>

<div id="main" class="mt-3 text-center container">
    
    <div class="ajax-msg"></div>
    <form action="{{ route('recruitproject.mailaddress_temporary_registration_process') }}" id='SendMailForm' method="post" enctype="multipart/form-data">
        @csrf

        <div class="row">                    

            <div class="row m-1">          

                <div class="col-xl-6 col-sm-12">  

                    <p>
                        ここに説明書き
                    </p>

                </div>
                
                <div class="col-xl-6 col-sm-12">  

                    <table style="min-width: 100%">

                        <tr>
                            <th class="text-start">
                                宛先名
                            </th>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" name="destination_name" id="destination_name" value="" class="form-control text-start">
                            </td>
                        </tr>

                        <tr>
                            <th class="text-start">
                                メールアドレス
                            </th>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" name="mailaddress" id="mailaddress" value="" class="form-control text-start">                                
                            </td>
                        </tr>

                        <tr>
                            <td class="text-end">                                
                                <button type="button" id='SendMailButton' class="btn btn-secondary">メール送信</button>
                            </td>
                        </tr>

                    </table>
                    
                </div>


            </div>       




            <div class="row">                    
                <div class="col-4 text-end">
                  
                </div>
                <div id="Message-Area" class="col-4">                    
                                      
                </div>

                <div class="col-4 text-start">
                  
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
            display_html = '<div class="text-start">';
            display_html += '<li class="text-start">メール送信中</li>';
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
                    
                    display_html = '<div class="text-start">';
                    display_html += 'メールを送信しました。';
                    display_html += '</div>';

                    $('#Message-Area').html(display_html);                   

                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");          


                }else{

                    var ErrorMessage = ResultArray["Message"];

                    
                    
                    display_html = '<div class="alert alert-danger text-start">';
                    display_html += '<li class="text-start">' + ErrorMessage + '</li>';
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
                
                
                display_html = '<div class="alert alert-danger text-start">';
                display_html += '<li class="text-start">メール送信処理でエラーが発生しました。</li>';
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

