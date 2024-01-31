@extends('hp.common.layouts_app')

@section('pagehead')
@section('title', '雇用者様へ')  
@endsection
@section('content')

<style>

  .form-control{
    padding: 3px;
  }
  
</style>

<div id="main" class="mt-3 text-center container  d-flex justify-content-center">  
    
    <div class="col-11">

        {{-- 概要説明エリア  Start --}}
        <div id="" class="row">  

        </div>

        {{-- 概要説明エリア  End --}}
        
        {{-- メール送信エリア   Start --}}
        <div id="" class="row ">  

            
            {{-- メールアドレス登録説明 Start --}}
            <div class="col-12 col-md-6 m-0 p-0">

                <div id="" class="row m-0 p-0">  

                    
                    <div id="" class="">
                        メールアドレスの登録説明記載予定
                    </div>
                    

                </div>

            </div>
            {{-- メールアドレス登録説明 End --}}

            <div class="col-12 col-md-6 m-0 p-0">

                <form action="{{ route('recruit_project.mailaddress_temporary_registration_process') }}" id='send_mail_form' method="post" enctype="multipart/form-data">
                    @csrf

                    <table class="w-100">

                        <tr>
                            <th class="text-start">
                                宛先名
                            </th>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" name="destination_name" id="destination_name" value="" class="form-control text-start" autocomplete="off">
                            </td>
                        </tr>

                        <tr>
                            <th class="text-start">
                                メールアドレス
                            </th>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" name="mailaddress" id="mailaddress" value="" class="form-control text-start" autocomplete="off">                                
                            </td>
                        </tr>

                        <tr>
                            <td class="text-end">                                
                                <button type="button" id='send_mail_button' class="btn btn-secondary mt-1">メール送信</button>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div id="mail_message_area" class="">                    
                                        
                                </div>
                            </td>
                        </tr>

                    </table>

                </form>

            </div>
            {{-- メール送信エリア   End --}}

        </div>

        {{-- ログインエリア  Start --}}
        <div id="" class="row">  
            
            <div class="col-12 col-md-6 m-0 p-0">
                
                <div id="" class="row m-0 p-0">  

                    {{-- ログイン説明 Start --}}
                    <div id="" class="">

                    </div>
                    {{-- ログイン説明 End --}}

                </div>

            </div>

            <div class="col-12 col-md-6 m-0 p-0">

                <form action="{{ route('recruit_project.login_password_check') }}" id='approve_form' method="post" target="_blank" enctype="multipart/form-data">
                    @csrf


                    <table style="min-width: 100%">

                        <tr>
                            <th class="text-start">
                                ログインID
                            </th>
                        </tr>

                        <tr>
                            <td>
                                <div class="col-6 m-0 p-0">
                                <input type="text" name="login_id" id="login_id" value="" class="form-control text-end" autocomplete="off">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th class="text-start">
                                パスワード
                            </th>
                        </tr>

                        <tr>
                            <td>
                                <input type="password" name="password" id="password" value="" class="form-control text-end" autocomplete="off">                                
                            </td>
                        </tr>

                        <tr>
                            <td class="text-end">                                
                                <button type="button" id='approve_button' class="btn btn-secondary mt-1">ログイン</button>

                                <button type="button" class="btn btn-success" onclick="location.href='{{ route('recruit_project.login') }}'">ログイン画面へ</button>                                
                                
                            </td>
                        </tr>                 

                    </table>
                            
                </form>

            </div>        

        </div>
        {{-- ログインエリア  End --}}
    

    </div>


</div>




@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){


    $("#send_mail_form").keypress(function(e) {

        if(e.which == 13) {            
            // 判定
            if( document.getElementById("send_mail_button") == document.activeElement ){

                button_wait(1);
                send_mail();
            
            }else if( document.getElementById("destination_name") == document.activeElement ){

                $('#mailaddress').focus();
                return false;         

            }else if( document.getElementById("mailaddress") == document.activeElement ){

                $('#send_mail_button').focus();
                return false;         

            }else{
                return false;
            }            
        }

    });

    $(document).on("click", "#send_mail_button", function (e) {
        button_wait(1);
        send_mail();
    });

    function send_mail(){

        //{{-- メッセージクリア --}}
        $('#mail_message_area').html('');
        $('.is-invalid').removeClass('is-invalid');

        var mailaddress = $("#mailaddress").val();        

        if(mailaddress == ""){
            $("#mailaddress").addClass("is-invalid");   
            $('#mailaddress').focus();               
            return false;
        }

        //{{-- ボタン無効 --}}
        $('#send_mail_button').prop("disabled", true);

        var display_html = '';
            display_html = '<div class="text-start">';
            display_html += '<li class="text-start">メール送信中</li>';
            display_html += '</div>';
        $('#mail_message_area').html(display_html);

        let f = $('#send_mail_form');

        

        $.ajax({
            url: f.prop('action'), // 送信先
            type: f.prop('method'),
            dataType: 'json',
            data: f.serialize(),
        })
            // 送信成功
            .done(function (data, textStatus, jqXHR) {
                
                //{{-- ボタン有効 --}}
                $('#send_mail_button').prop("disabled", false);
                
                var result_array = data.result_array;

                var Result = result_array["Result"];

                if(Result=='success'){
                    
                    display_html = '<div class="text-start">';
                    display_html += 'メールを送信しました。';
                    display_html += '</div>';

                    $('#mail_message_area').html(display_html);                   

                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");          


                }else{

                    var ErrorMessage = result_array["Message"];

                    
                    
                    display_html = '<div class="alert alert-danger text-start">';
                    display_html += '<li class="text-start">' + ErrorMessage + '</li>';
                    display_html += '</div>';

                        //{{-- アラート --}}
                    $('#mail_message_area').html(display_html);
                    //{{-- 画面上部へ --}}

                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");                 

                }

            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
                 //{{-- ボタン有効 --}}
                 $('#send_mail_button').prop("disabled", false);

                display_html = '<div class="alert alert-danger text-start">';
                display_html += '<li class="text-start">メール送信処理でエラーが発生しました。</li>';
                display_html += '</div>';

                //{{-- アラート --}}
                $('#mail_message_area').html(display_html);
                //{{-- 画面上部へ --}}
                $("html,body").animate({
                    scrollTop: 0
                }, "300");
            

            });


    }


    $("#approve_form").keypress(function(e) {

        if(e.which == 13) {            
            // 判定
            if( document.getElementById("approve_button") == document.activeElement ){
                                
                button_wait(2);
                login_process();
            
            }else if( document.getElementById("login_id") == document.activeElement ){

                $('#password').focus();
                return false;

            }else if( document.getElementById("password") == document.activeElement ){

                $('#approve_button').focus();
                return false;

            }else{
                return false;
            }            
        }
    });    

    $('#approve_button').click(function () {        
        button_wait(2);
        login_process();
        
    });


    function login_process(){

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.is-invalid').removeClass('is-invalid');

        var login_id = $("#login_id").val();
        var password = $("#password").val();
        var Judge = true;

        if(password == ""){
            $('#password').focus();
            Judge = false;
            $("#password").addClass("is-invalid");            
        }

        if(login_id == ""){
            $('#login_id').focus();
            Judge = false;
            $("#login_id").addClass("is-invalid");                              
        }


        if(!Judge){
            return false;
        }
        
        // 確認画面へ画面遷移
        $('#approve_form').submit();         
    }

    function button_wait(process_branch){

        var target_button_id = "";
        if(process_branch == 1){
            target_button_id = "send_mail_button";
        }else{
            target_button_id = "approve_button";
        }

        // ボタンを無効にする
        document.getElementById(target_button_id).disabled = true;

        // 3秒後にボタンを有効にする
        setTimeout(function() {
            document.getElementById(target_button_id).disabled = false;
        }, 3000);
    }



});

</script>
@endsection

