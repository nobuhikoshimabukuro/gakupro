@extends('photoproject.common.layouts_customer')

@section('pagehead')
@section('title', 'パスワード入力画面')  
@endsection
@section('content')

<style>
   


</style>
<div id="Main" class="mt-3 text-center container">
    
    <div class="ajax-msg">
        
    </div>

        
    <form action="{{ route('photoproject.photo_confirmation') }}" id='ApproveForm' method="post" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="key_code" id="" value="{{$key_code}}" class="form-control">
        <input type="hidden" name="Cipher" id="" value="{{$Cipher}}" class="form-control">

        <div class="row">                    

            <div class="row">                    

                <div class="col-4 text-right">
                    <label for="" class="col-form-label OriginalLabel">パスワード</label>
                </div>
                <div class="col-4">                    
                    <input type="tel" name="password" id="password" value="" class="form-control text-right">
                </div>

               
                <div class="col-4 text-left">
                    <button type="button" id='ApproveButton' class="btn btn-secondary">GO</button>
                </div>         

            </div>          
            
            
                                
            @if(session('photo_get_password_check_error'))
    
                <div class="row"> 
                    <div class="col-12 text-center">
                            {{session('photo_get_password_check_error')}}  
                        </div>
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

    
    $("#ApproveForm").keypress(function(e) {

        if(e.which == 13) {            
            // 判定
            if( document.getElementById("ApproveButton") == document.activeElement ){
                
                PasswordCheckProcess();            
        
            }else if( document.getElementById("password") == document.activeElement ){

                $('#ApproveButton').focus();
                return false;

            }else{
                return false;
            }            
        }
    });    
    
    $('#ApproveButton').click(function () {        
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
        $('#ApproveForm').submit(); 

    }







});

</script>
@endsection

