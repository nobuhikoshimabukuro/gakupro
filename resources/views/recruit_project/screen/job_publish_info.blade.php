@extends('recruit_project.common.layouts_afterlogin')

@section('pagehead')
@section('title', '求人掲載履歴')  
@endsection
@section('content')




<style>

    
.label-area{
    display: flex;    
    align-items: center;
}



table {
  border-collapse: collapse;
}

p {
  font-size: 16px;
  font-weight: bold;
  text-align: center;  
}

input[type="submit"],
input[type="text"],
input[type="tel"],
textarea,
button {
  -moz-appearance: none;
  -webkit-appearance: none;
  -webkit-box-shadow: none;
  box-shadow: none;
  outline: none;
  border: none;
  font-weight: 600;
}


textarea {
    resize: none;
}



select
{
  -moz-appearance: none;  
  -webkit-box-shadow: none;
  box-shadow: none;
  outline: none;
  border: none;

  background: #ebf4f8;  
  display: inline;
  font-size: 16px;
  padding: 7px 2px;
  transition: 0.8s;
  margin: 0;
  border-radius: 6px;
  font-weight: 600;
}


input[type="text"]
{
    background: #ebf4f8;  
    display: inline;
    font-size: 16px;
    padding: 7px;
    transition: 0.8s;
    margin: 0;
    border-radius: 6px;  
    
}

/*未入力*/
input[type="text"]:placeholder-shown
,input[type="tel"]:placeholder-shown
,textarea:placeholder-shown
{
    background: #243355;

}

input[type="text"]:focus
,input[type="tel"]:focus
,textarea:focus
,select:focus
{
  /* background: #e9f5fb; */
  background: #f7f7f6;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}


input::placeholder{
  color: white;
  font-size: 14px;
  opacity: 0.9;
}


.form-table {
    border: 1px solid #d7d7d7;
    width: 100%;

    border-collapse: separate;/*collapseから変更*/
    border-spacing: 0;
    border-radius: 6px;
    overflow: hidden;
}


.form-table th {
    white-space: nowrap;
    border-bottom: 1px solid #d7d7d7;
    border-right: 1px solid #d7d7d7;
    /* background: #ffecea;   */
    background: linear-gradient(-225deg, #eaf3f1 0%, #ececd7 56%, #ebeedf 100%);
    font-size: 20px;
    position: relative;
    text-align: left;
    padding: 2px 0 2px 5px;

    
}


.form-table td {        
    position: relative;
    white-space: nowrap;
    text-align: left;
    border-bottom: 1px solid #d7d7d7;
    padding: 5px;
}

.form-table tbody tr:last-child th,
.form-table tbody tr:last-child td {
    border-bottom: none;
}
   
   .job-password-error-area{
        padding: 3px;
        margin: 3px;
        
        color:  rgb(233, 37, 37);
        font-weight: 600;
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

            <div class="col-12 text-start">
                <h4 class="master-title">
                    求人掲載履歴
                </h4>
            </div>    

        </div>    

        <div class="col-12 text-start">

            <table class="form-table">

                <tbody>

                    <tr class="">

                        <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                            <label for="title">パスワード</label>
                        </th>
                        <td>

                            <input type="text" name="password" id="password" class="" placeholder="" maxlength="10">  
                            <button id="job-password-check-button" type="button" class='job-password-check-button btn btn-success'>パスワード確認</button>
                            <button id="reset-button" type="button" class='reset-button btn btn-secondary'>リセット</button>
                        </td>

                    </tr>

                    <tr class="job-password-error-tr d-none">

                        <td colspan="2"> 
                            
                            <div class="job-password-error-area">                                
                            </div>                           

                        </td>

                    </tr>

                    <tr class="job-password-item-tr d-none">
                        <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                            <label>商品名</label>
                        </th>
                        <td class="job-password-item-td">                            
                        </td>
                    </tr>

                    <tr class="job-password-publish-date-tr d-none">
                        <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                            <label>掲載開始日</label>
                        </th>
                        <td>
                            <input type="date" name="publish_start_date" id="publish_start_date" class="">
                        </td>
                    </tr>                  

                </tbody>

            </table>

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



    
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){


    $('#reset-button').click(function () {

        $(".job-password-error-tr").removeClass('d-none');
        $(".job-password-item-tr").removeClass('d-none');
        $(".job-password-publish-date-tr").removeClass('d-none');

        $(".job-password-error-tr").addClass('d-none');
        $(".job-password-item-tr").addClass('d-none');
        $(".job-password-publish-date-tr").addClass('d-none');

        $("#password").val('');
        $("#password").focus();
     
    });

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

        $(".job-password-error-tr").removeClass('d-none');
        $(".job-password-item-tr").removeClass('d-none');
        $(".job-password-publish-date-tr").removeClass('d-none');

        $(".job-password-error-tr").addClass('d-none');
        $(".job-password-item-tr").addClass('d-none');
        $(".job-password-publish-date-tr").addClass('d-none');


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

                var result = result_array["result"];


                if(result == 'success'){

                    var get_info_array = result_array["get_info_array"];
                    var result_type = get_info_array["result_type"];
                    var message = get_info_array["message"];
                    

                    if(result_type == 0){

                        var job_password_item_name = get_info_array["job_password_item_name"];
                        var added_date = get_info_array["added_date"];
                    
                        $(".job-password-item-tr").removeClass('d-none');
                        $(".job-password-publish-date-tr").removeClass('d-none');

                        $('.job-password-item-td').html(job_password_item_name);
                        

                    }else if(result_type >= 1){
                        //{{-- アラート --}}
                        $(".job-password-error-tr").removeClass('d-none');
                        $('.job-password-error-area').html(message);

                    }


                    
                

                }else{       

                    //{{-- アラート --}}
                    $(".job-password-error-tr").removeClass('d-none');
                    $('.job-password-error-area').html("パスワード確認処理エラー");
                
                }

            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
                //{{-- アラート --}}
                $(".job-password-error-tr").removeClass('d-none');
                $('.job-password-error-area').html("パスワード確認処理エラー");
                

            });

    });

});

</script>
@endsection

