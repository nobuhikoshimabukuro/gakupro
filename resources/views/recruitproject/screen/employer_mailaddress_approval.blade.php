@extends('recruitproject.common.layouts_beforelogin')

@section('pagehead')
@section('title', 'メールアドレス認証画面')  
@endsection
@section('content')

<style>
   


</style>
<div class="mt-3 text-center container">
    
    
    <form action="{{ route('recruitproject.mailaddress_approval_check') }}" id='ApproveForm' method="post" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="mailaddress" id="mailaddress" value="{{$mailaddress}}" class="form-control text-right">
        <div class="row">                                   

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
            
            
                                
            @if(session('employer_mailaddress_approval_error'))
            
                <div class="row ajax-msg"> 
                    <div class="col-4"></div>      
                    <div class="col-4">
                        <div class="alert alert-danger text-center">
                            {{session('employer_mailaddress_approval_error')}}  
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
<script src="{{ asset('js/common.js') }}"></script>
<script type="text/javascript">

$(function(){


    

    $("#ApproveForm").keypress(function(e) {
        if(e.which == 13) {
            return false;
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

