@extends('recruitproject.common.layouts_beforelogin')

@section('pagehead')
@section('title', 'ログイン画面')  
@endsection
@section('content')

<style>
   


</style>
<div id="main" class="mt-3 text-center container">
    
    
    <form action="{{ route('recruitproject.login_password_check') }}" id='ApproveForm' method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">                    

            <div class="row">                    
                <div class="col-4 text-end">
                    <label for="" class="col-form-label original-label">ログインID</label>
                </div>
                <div class="col-4">                    
                    <input type="text" name="login_id" id="login_id" value="" class="form-control text-end">
                </div>

                <div class="col-4 text-start">                    
                </div>      
            </div>       

            <div class="row">                    
                <div class="col-4 text-end">
                    <label for="" class="col-form-label original-label">パスワード</label>
                </div>
                <div class="col-4">                    
                    <input type="password" name="password" id="password" value="" class="form-control text-end">
                </div>

                <div class="col-4 text-start">
                    <button type="button" id='ApproveButton' class="btn btn-secondary">GO</button>
                </div>      
            </div>   
            
            
                                
            @if(session('employer_loginerror'))
            
                <div class="row ajax-msg"> 
                    <div class="col-4"></div>      
                    <div class="col-4">
                        <div class="alert alert-danger text-center">
                            {{session('employer_loginerror')}}  
                        </div>
                    </div>      
                    <div class="col-4"></div>      
                </div>   
            @endif
            

        </div>      

        {{-- @php phpinfo() @endphp --}}
        
        


    </form>
    
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){


    
    $(document).ready(function () {        
        $('#login_id').focus();
    });

    
    $("#ApproveForm").keypress(function(e) {

        if(e.which == 13) {            
            // 判定
            if( document.getElementById("ApproveButton") == document.activeElement ){
                
                LoginProcess();
            
            }else if( document.getElementById("login_id") == document.activeElement ){

                $('#password').focus();
                return false;

            }else if( document.getElementById("password") == document.activeElement ){

                $('#ApproveButton').focus();
                return false;

            }else{
                return false;
            }            
        }
    });    
    
    $('#ApproveButton').click(function () {        
        LoginProcess();
    });


    function LoginProcess(){

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
        
        //{{-- マウスカーソルを待機中に --}}         
        document.body.style.cursor = 'wait';

        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $(this).prop("disabled", true);

        // 確認画面へ画面遷移
        $('#ApproveForm').submit(); 

    }

        


});

</script>
@endsection

