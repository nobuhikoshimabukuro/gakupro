@extends('recruit_project.common.layouts_afterlogin')

@section('pagehead')
@section('title', '求人掲載履歴')  
@endsection
@section('content')




<style>

    label {
      font-size: 16px;
      font-weight: bold;
      text-align: center;  
    }
    
   
    
    input[type="text"]    
    {
        background: #ebf4f8;
      /* display: block; */
      display: inline;
      font-size: 16px;
      padding: 7px;
      transition: 0.8s;
      margin: 0;
      border-radius: 6px;
    }
    
    /*未入力*/
    input[type="text"]:placeholder-shown
    
    {
        background: #243355;
    
    }
    
    input[type="text"]:focus    
    {
      /* background: #e9f5fb; */
      background: #f7f7f6;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }
   
  
    .item-flash{
        animation: flash 2s linear infinite;
    }
    
    @keyframes flash {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }
    
    /* PC用 */
    @media (min-width:769px) {  /*画面幅が769px以上の場合とする*/
    
    
    
    }
    
    
    
    /* スマホ用 */
    @media (max-width:768px) {  /*画面幅が768px以下の場合とする*/
    
    }
    
    
    
    
    
</style>


<div id="main" class="mt-3 text-center container">
    
   <div class="row">

        @include('recruit_project.common.alert')

         

        <div class="row m-0 mt-2 p-0">        

            <div class="col-6 text-start">
                <h4 class="master-title">
                    求人掲載履歴
                </h4>
            </div>    


            <div class="col-6 text-end">
                
                <button class='btn btn-success' data-bs-toggle='modal' data-bs-target='#password-modal'>掲載期間を伸ばす</button>
                
            </div>

        </div>    



        <div id="data-display-area" class="scroll-wrap-x m-0">
            
            <table id='' class='data-info-table'>
                
                <tr>
                    <th>番号</th>
                    <th>掲載期間</th>                
                    <th></th>
                </tr>

                @foreach ($job_password_connection_t as $item)
                    <tr>
                        <td>
                            {{$item->branch_number}}
                        </td>

                        <td>                    
                            {{$item->publish_start_date}}～{{$item->publish_end_date}}
                        </td>
                        <td>                            
                        </td>
                    </tr>

                @endforeach
            </table>

        </div>

        

    </div>






    {{-- パスワード入力モーダル --}}
    <div class="modal fade" id="password-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="password-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title" id=""><span id="password-modal-title"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               
                <div class="modal-body">
                    
                    <div class="col-12 text-start">
                        <label>パスワード</label>
                        <input type="text" name="password" id="password" class="">
                        <button id="job-password-check-button" type="button" class='job-password-check-button btn btn-success'>パスワード確認</button>
                    </div>

                    <div class="col-12 text-start">
                        <div class="password-result-area">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">               
                    <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>
                </div>
            </div>
        </div>
    </div>


    
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){


// 「パスワード確認」ボタンがクリックされたら
$('#job-password-check-button').click(function () {
 
    // ２重送信防止
    // 保存tを押したらdisabled, 10秒後にenable
    $('#job-password-check-button').prop("disabled", true);

    setTimeout(function () {
        $('#job-password-check-button').prop("disabled", false);
    }, 3000);

    //{{-- メッセージクリア --}}
    $('.ajax-msg').html('');

    var password = $('#password').val();
            
    //マウスカーソルを砂時計に
    document.body.style.cursor = 'wait';


    $.ajax({	
        url: "{{ route('recruit_project.job_password_check') }}", // 送信先
        type: 'post',
        dataType: 'json',
        data: { 'password' : password },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}            
    })
        // 送信成功
        .done(function (data, textStatus, jqXHR) {
            
            //{{-- ボタン有効 --}}
            $("#job-password-check-button").prop("disabled", false);
            //{{-- マウスカーソルを通常に --}}                    
            document.body.style.cursor = 'auto';

            var result_array = data.result_array;

            var Result = result_array["Result"];


            if(Result=='success'){

                var result_type = result_array["result_type"];
                var Message = result_array["Message"];

                if(result_type == 0){

                

                }else if(result_type == 1){

                

                }else if(result_type == 2){

                // alert(Message);

                }


                
                //{{-- アラートメッセージ表示 --}}
                var errorsHtml = '';
                errorsHtml = '<div class="alert alert-danger text-start">';
                errorsHtml += '<li class="text-start">' + Message + '</li>';
                errorsHtml += '</div>';

                    //{{-- アラート --}}
                $('.password-result-area').html(errorsHtml);

            }else{

                var ErrorMessage = result_array["Message"];

                //{{-- アラートメッセージ表示 --}}
                var errorsHtml = '';
                errorsHtml = '<div class="alert alert-danger text-start">';
                errorsHtml += '<li class="text-start">パスワード確認処理エラー</li>';
                errorsHtml += '</div>';

                    //{{-- アラート --}}
                $('.password-result-area').html(errorsHtml);
               
             

            }

        
        })

        // 送信失敗
        .fail(function (data, textStatus, errorThrown) {

            //{{-- マウスカーソルを通常に --}}                    
            document.body.style.cursor = 'auto';
            
            //{{-- アラートメッセージ表示 --}}
            let errorsHtml = '<div class="alert alert-danger text-start">';                
            errorsHtml += '<li class="text-start">パスワード確認処理エラー</li>';
            errorsHtml += '</div>';
            
            //{{-- アラート --}}
            $('.ajax-msg').html(errorsHtml);
            //{{-- 画面上部へ --}}
            $("html,body").animate({
                scrollTop: 0
            }, "300");
            //{{-- ボタン有効 --}}
            $('#job-password-check-button').prop("disabled", false);
            

        });

});

});

</script>
@endsection

