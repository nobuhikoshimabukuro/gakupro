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
    
    .error-area{

    }
    
    .alert-area{
        position: absolute;        
        top: calc(50% - 20px);
        right: calc(50% - 150px);
        
        width: 300px;
        background-color: rgb(221, 20, 20);
        font-size: 20px;
        font-weight: bold;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;    
        opacity: 0.8;
        z-index: 102;
        transition: all 0.6s;
    }
    
    
</style>


<input type="hidden" name="employer_id" id="employer_id" value="{{$employer_id}}">
<input type="hidden" name="job_id" id="job_id" value="{{$job_id}}">

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
                            <label for="send_password">パスワード</label>
                        </th>
                        <td>

                            <input type="text" name="send_password" id="send_password" class="" placeholder="" maxlength="10">  
                            <button id="job-password-check-button" type="button" class='job-password-check-button btn btn-success'>パスワード確認</button>
                            <button id="reset-button" type="button" class='reset-button btn btn-secondary'>リセット</button>
                        </td>

                    </tr>

                                  

                </tbody>

            </table>

        </div>



        <div id="data-display-area" class="scroll-wrap-x m-0">
            
            <table id='' class='data-info-table'>
                
                <tr>
                    <th>掲載番号</th>
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



{{-- モーダル --}}
<div class="modal fade" id="job-password-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="job-password-modal-label" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="job-password-modal-label">操作確認</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            
                <div class="modal-body">  
                       
                    <table class="form-table">

                        <tbody>                    
        
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
                                    <button id="date-setting-button" type="button" class='date-setting-button btn btn-success'>確認</button>                                    
                                    <input type="hidden" name="password" id="password" value="">
                                </td>
                            </tr>        
                            
                            <tr class="job-password-publish-setting-date-tr">
                                <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                    <label>掲載期間</label>
                                </th>
                                <td>
                                    
                                    
                                    

                               
                                    
                                </td>




                            </tr>        
        
                        </tbody>
        
                    </table>



                </div>
                

                <div class="modal-footer">                                                                                      
                    <div class="col-6 m-0 p-0 text-start">
                        <button id="job-publish-confirmation-process-button" type="button" 
                        class='btn btn-success d-none'>掲載期間設定</button>
                    </div>

                    <div class="col-6 m-0 p-0 text-end">
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


    


    $('#reset-button').click(function () {

        $(".job-password-error-tr").removeClass('d-none');
        $(".job-password-item-tr").removeClass('d-none');
        $(".job-password-publish-date-tr").removeClass('d-none');

        $(".job-password-error-tr").addClass('d-none');
        $(".job-password-item-tr").addClass('d-none');
        $(".job-password-publish-date-tr").addClass('d-none');

        $("#send_password").val('');
        $("#send_password").focus();

        alert_reset();
     
    });

    // 「パスワード確認」ボタンがクリックされたら
    $('#job-password-check-button').click(function () {
    
 
        //{{-- メッセージクリア --}}        
        alert_reset();

        var password = $('#send_password').val();
                
        if(password == ""){

            alert_display("#main" , "パスワードを入力してください。");
            $('#send_password').focus();
            return false;
        }

        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $('#job-password-check-button').prop("disabled", true);

        setTimeout(function () {
            $('#job-password-check-button').prop("disabled", false);
        }, 3000);

        
        $(".job-password-error-tr").removeClass('d-none');
        $(".job-password-item-tr").removeClass('d-none');
        $(".job-password-publish-date-tr").removeClass('d-none');

        $(".job-password-error-tr").addClass('d-none');
        $(".job-password-item-tr").addClass('d-none');
        $(".job-password-publish-date-tr").addClass('d-none');


        $('.job-password-publish-setting-date-tr td').html("");        
        $('#password').val("");

        
        start_processing("#main");

        $.ajax({	
            url: "{{ route('recruit_project.job_password_check') }}", // 送信先
            type: 'get',
            dataType: 'json',
            data: { 'password' : password },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}            
        })
            // 送信成功
            .done(function (data, textStatus, jqXHR) {
                
                
                //{{-- ボタン有効 --}}
                $("#job-password-check-button").prop("disabled", false);
                end_processing();

                var result_array = data.result_array;

                var result = result_array["result"];


                if(result == 'success'){

                    var get_info_array = result_array["get_info_array"];
                    var result_type = get_info_array["result_type"];
                    var message = get_info_array["message"];
                    

                    if(result_type == 0){

                        var job_password_item_name = get_info_array["job_password_item_name"];
                        var added_date = get_info_array["added_date"];
                                            
                        $('#password').val(password);

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


                $("#job-publish-confirmation-process-button").removeClass('d-none');
                $("#job-publish-confirmation-process-button").addClass('d-none');
                // モーダルを表示。
                $('#job-password-modal').modal('show');
            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
                //{{-- ボタン有効 --}}
                $("#job-password-check-button").prop("disabled", false);
                end_processing();

                //{{-- アラート --}}
                $(".job-password-error-tr").removeClass('d-none');
                $('.job-password-error-area').html("パスワード確認処理エラー");
                // // モーダルを表示。
                $('#job-password-modal').modal('show');

            });

    });



    //求人公開開始日時変更時
    $(document).on("click", "#date-setting-button", function (e) {

        var employer_id = $('#employer_id').val();
        var job_id = $('#job_id').val();   
        var publish_start_date = $('#publish_start_date').val();
        var password = $('#password').val();

        if(publish_start_date == ""){

            return false;
        }
        
        $("#job-publish-confirmation-process-button").removeClass('d-none');
        $("#job-publish-confirmation-process-button").addClass('d-none');

        $(".job-password-error-tr").removeClass('d-none');
        $(".job-password-error-tr").addClass('d-none');



        start_processing("#job-password-modal");

        
        $.ajax({	
            url: "{{ route('recruit_project.job_password_date_setting') }}", // 送信先
            type: 'get',
            dataType: 'json',
            data: { 'employer_id' : employer_id, 'job_id' : job_id ,'password' : password,'publish_start_date' : publish_start_date},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}            
        })
            // 送信成功
            .done(function (data, textStatus, jqXHR) {
                
                
                
                end_processing();

                var result_array = data.result_array;

                var result = result_array["result"];


                if(result == 'success'){


                    var get_info_array = result_array["get_info_array"];

                    var result_type = get_info_array["result_type"];                                        

                    if(result_type == 0){

                        var publish_start_date = get_info_array["publish_start_date"];
                        var publish_end_date = get_info_array["publish_end_date"];
                        var added_date = get_info_array["added_date"];
                        
                        var display_message = publish_start_date + "～" + publish_end_date;
                        $(".job-password-publish-setting-date-tr").removeClass('d-none');
                        $('.job-password-publish-setting-date-tr td').html(display_message);
                    
                        $("#job-publish-confirmation-process-button").removeClass('d-none');

                    }else if(result_type == 1 || result_type == 2){
                        var message = get_info_array["message"];  
                        //{{-- アラート --}}
                        $(".job-password-error-tr").removeClass('d-none');
                        $('.job-password-error-area').html(message);

                    }else if(result_type == 3){
                        
                        var branch_number = get_info_array["branch_number"]; 
                        var display_message =  "掲載番号【" + branch_number + "】と掲載期間が重複しています。";
                        //{{-- アラート --}}
                        $(".job-password-error-tr").removeClass('d-none');
                        $('.job-password-error-area').html(display_message);

                    }
                    
                

                }else{       

                    //{{-- アラート --}}
                    $(".job-password-error-tr").removeClass('d-none');
                    $('.job-password-error-area').html(message);
                
                }


                
            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
               
                end_processing();

                //{{-- アラート --}}
                $(".job-password-error-tr").removeClass('d-none');
                $('.job-password-error-area').html("パスワード確認処理エラー");

               
                

            });


        
        

    });



    //求人公開開始日時確定処理時
    $(document).on("click", "#job-publish-confirmation-process-button", function (e) {

        
        var employer_id = $('#employer_id').val();
        var job_id = $('#job_id').val();        
        var password = $('#password').val();
        var publish_start_date = $('#publish_start_date').val();



        $(".job-password-error-tr").removeClass('d-none');
        $(".job-password-error-tr").addClass('d-none');



        start_processing("#job-password-modal");

        var url = "{{ route('recruit_project.job_publish_confirmation_process') }}";
                

        $.ajax({
            url: url, // 送信先
            type: 'post',
            dataType: 'json',
            data: { 'employer_id' : employer_id, 'job_id' : job_id ,'password' : password,'publish_start_date' : publish_start_date},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
	    })
	    .done(function (data, textStatus, jqXHR) {
                
                end_processing();

                var result_array = data.result_array;

                var result = result_array["result"];

                

                if(result == 'success'){


                    location.reload();
                

                }else{       

                    var message = result_array["message"];

                    //{{-- アラート --}}
                    $(".job-password-error-tr").removeClass('d-none');
                    $('.job-password-error-area').html(message);
                
                }


                
            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
            
                end_processing();

                //{{-- アラート --}}
                $(".job-password-error-tr").removeClass('d-none');
                $('.job-password-error-area').html("パスワード承認処理エラー");

            
                

            });


    });










});

</script>
@endsection

