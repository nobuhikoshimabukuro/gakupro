@extends('recruit_project.common.layouts_beforelogin')

@section('pagehead')
@section('title', 'メールアドレス認証画面')  
@endsection
@section('content')

<style>
   


</style>
<div id="main" class="mt-3 text-center container">
    
    
    <form action="{{ route('recruit_project.mailaddress_approval_check') }}" id='approve_form' method="post" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="key_code" id="key_code" value="{{$key_code}}">
        <input type="hidden" name="cipher" id="cipher" value="{{$cipher}}">
        
        <div class="row">                                   

            <div class="row">                    
                <div class="col-4 text-end">
                    <label for="" class="col-form-label original-label">パスワード</label>
                </div>
                <div class="col-4">                    
                    <input type="password" name="password" id="password" value="" class="form-control text-end">
                </div>

                <div class="col-4 text-start">
                    <button type="button" id='approve_button' class="btn btn-secondary">GO</button>
                </div>      
            </div>   
            
            
                                
            @if(session('authentication_error'))
            
                <div class="row ajax-msg">
                    <div class="col-12 text-center">
                        ※パスワードが異なります。
                        <br>
                        受信したメールに記載されているパスワードを再度入力してください。
                    </div>                          
                </div>

            @endif
            

        </div>      


    </form>
    
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){


    $(document).ready(function () {        
        $('#password').focus();
    });

    

    $("#approve_form").keypress(function(e) {

        if(e.which == 13) {            
            // 判定
            if( document.getElementById("approve_button") == document.activeElement ){
                
                PasswordCheckProcess();         

            }else if( document.getElementById("password") == document.activeElement ){

                $('#approve_button').focus();
                return false;

            }else{
                return false;
            }            
        }
    });

    
    $('#approve_button').click(function () {
        PasswordCheckProcess();  

    });

    function PasswordCheckProcess(){

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.is-invalid').removeClass('is-invalid');


        var password = $("#password").val();

        if(password == ""){            
            $("#password").addClass("is-invalid");            
            return false;
        }

        //{{-- マウスカーソルを待機中に --}}         
        document.body.style.cursor = 'wait';


        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $(this).prop("disabled", true);


        // 確認画面へ画面遷移
        $('#approve_form').submit(); 

    }


        


});

</script>
@endsection

