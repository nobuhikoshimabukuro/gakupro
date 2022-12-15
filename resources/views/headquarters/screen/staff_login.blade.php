@extends('recruitproject.common.layouts_beforelogin')

@section('pagehead')
@section('title', 'ログイン画面')  
@endsection
@section('content')

<style>
   


</style>
<div class="mt-3 text-center container">
    
    <div class="ajax-msg">
        
    </div>

    <form action="{{ route('headquarters.login_password_check') }}" id='ApproveForm' method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">                    

            <div class="row">                    
                <div class="col-4 text-right">
                    <label for="" class="col-form-label OriginalLabel">ログインID</label>
                </div>
                <div class="col-4">                    
                    <input type="text" name="login_id" id="login_id" value="" class="form-control text-right input_number_only">
                </div>

                <div class="col-4 text-left">                    
                </div>      
            </div>       

            <div class="row">                    
                <div class="col-4 text-right">
                    <label for="" class="col-form-label OriginalLabel">パスワード</label>
                </div>
                <div class="col-4">                    
                    <input type="password" name="password" id="password" value="" class="form-control text-right">
                </div>

                <div class="col-4 text-left">
                    <button type="button" id='ApproveButton' class="btn btn-secondary">GO</button>
                </div>      
            </div>   
            
            
                                
            @if(session('staff_loginerror'))
            
                <div class="row ajax-msg"> 
                    <div class="col-4"></div>      
                    <div class="col-4">
                        <div class="alert alert-danger text-center">
                            {{session('staff_loginerror')}}  
                        </div>
                    </div>      
                    <div class="col-4"></div>      
                </div>   
            @endif
            

        </div>      


    </form>
    
    <div class="col-6 col-md-4 col-xl-3 p-3 ">
        <a href="{{ route('headquarters.test') }}">
            <div class="bg-dark rounded-lg text-light p-2 ">                    
                <i class="fas fa-qrcode fa-3x mb-1"></i>
                <h6>test</h6>
            </div>
        </a>
    </div>      

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

    


      

    // $('#login_id').change(function() {
    //     $('#login_id').val(test($('#login_id').val()));
    // });

    // function test(before_value){
        
    //     var after_value = '';

    //     var before_value_array = before_value.toLowerCase().split('');

    //     $.each(before_value_array, function (key, value) {
			
    //         if (($.isNumeric(value))) {
		
    //             after_value = after_value.toString() + value.toString();
    //         }

					
	// 	});

    //     return after_value;
    // }


});

</script>
@endsection

