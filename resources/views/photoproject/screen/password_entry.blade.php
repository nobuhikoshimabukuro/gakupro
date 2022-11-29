@extends('photoproject.common.layouts_customer')

@section('pagehead')
@section('title', 'パスワード入力画面')  
@endsection
@section('content')

<style>
   


</style>
<div class="mt-3 text-center container">
    
    

    

    <div class="ajax-msg">
        
    </div>

    <div id='PasswordArea' class="">
        
        <form action="{{ route('photoproject.photo_confirmation') }}" id='ApproveForm' method="post" enctype="multipart/form-data">
            @csrf                

            <input type="hidden" name="key_code" id="" value="{{$key_code}}" class="form-control">
            <input type="hidden" name="Cipher" id="" value="{{$Cipher}}" class="form-control">

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

            @if(session('photo_get_password_check_error'))
        
                <div class="row"> 
                    <div class="col-12 text-center">
                            {{session('photo_get_password_check_error')}}  
                        </div>
                    </div>                                  
                </div> 

            @endif

        </form>
        
    </div>
   
    
</div>
@endsection

@section('pagejs')
<script src="{{ asset('js/common.js') }}"></script>
<script type="text/javascript">

$(function(){


    $("#ApproveForm").keypress(function(e) {

        if(e.which == 13) {
            // 判定
            if( document.getElementById("ApproveButton") != document.activeElement ){            
                return false;
            }            
        }

    });



    $('#ApproveButton').click(function () {

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

    });




});

</script>
@endsection

