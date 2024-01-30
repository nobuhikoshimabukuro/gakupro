@extends('recruit_project.common.layouts_afterlogin')

@section('pagehead')
@section('title', '求人公開履歴')  
@endsection
@section('content')




<style>







table {
  border-collapse: collapse;
}



@media (min-width:993px) {  

   

    .form-table th 
    ,.form-table td
    {        
        text-align: left;
    }

}



/* スマホ用 */
@media (max-width:992px) {  /*画面幅が768px以下の場合とする*/

   

    .form-table th,
    .form-table td {
        display: block;
        width: 100%;
        text-align: left;
    }

    .form-table th {
        border-right: none;        
    }

  

}
























   
    .item-center{
        display: flex;
        justify-content: center; /*左右中央揃え*/
        align-items: center;     /*上下中央揃え*/
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

            <div class="col-7 text-start">
                <h4 class="master-title">
                    求人公開履歴
                </h4>
            </div>    

            <div class="col-5 text-end">
                <button id="reset-button" type="button" class='reset-button btn btn-secondary m-1'>リセット</button>
            </div>    

        </div>    


        <div class="col-12">

            <table class="form-table w-100">

                <tr class="">

                    <th class="col-12 col-md-2 col-xl-2">
                        <label for="send_password">パスワード</label>
                    </th>

                    <th class="col-12 col-md-4 col-xl-4">
                        
                        <div class="row m-0 p-0 password-set-area align-items-center">

                            <div class="col-6 m-0 p-0 text-start">
                                <input type="text" name="send_password" id="send_password" class="form-control" placeholder="" maxlength="10">
                            </div>    
                
                            <div class="col-6 m-0 p-0 text-end">
                                <button id="job-password-check-button" type="button" 
                                class='job-password-check-button btn btn-success m-1'>パスワード確認</button>  
                            </div>    
                
                        </div>    

                        
                    </td>     
                    
                    <th class="col-12 col-md-2 col-xl-2">
                        <label>商品名</label>
                    </th>

                    <th class="col-12 col-md-4 col-xl-4">
                        <input type="text" name="" id="job-password-item-name" class="form-control" readonly>
                    </td>   
                    
                    

                </tr>

                <tr class="">

                    <th class="">
                        <label for="publish_start_date">公開開始日</label>
                    </th>

                    <td class="date-set-area text-start">

                        <div class="row m-0 p-0 align-items-center">

                            <div class="col-6 m-0 p-0 text-start">
                                <input type="date" name="publish_start_date" id="publish_start_date" class="form-control" value="{{$set_publish_end_date}}">
                            </div>    
                
                            <div class="col-6 m-0 p-0 text-end">                        
                                <button id="date-setting-button" type="button" 
                                class='date-setting-button btn btn-success m-1'>確認</button>
                            </div>    
                
                        </div>    
                        
                    </td>                       
                    
                    <th class="">
                        <label>公開期間</label>
                    </th>

                    <td class="date-set-process-area">

                        <div class="row m-0 p-0 align-items-center">

                            <div class="col-6 m-0 p-0 text-start publishing_period">
                                
                            </div>    
                
                            <div class="col-6 m-0 p-0 text-end">                        
                                <button id="job-publish-confirmation-process-button" type="button" 
                                    class='btn btn-success m-1'>設定</button>  
                            </div>                
                        </div>    
                    </td>
               

                </tr>

            </table>
            
        </div>

        

        <div id="data-display-area" class="scroll-wrap-x m-0">
            
            <table id='' class='data-info-table'>
                
                <tr>
                    <th>公開番号</th>
                    <th>公開期間</th>                
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

    

    $(document).ready(function() {
        set_inoperable(0);
    }); 


    function set_inoperable(process_branch){

        var class_name = "inoperable";

        $("." + class_name).removeClass(class_name);

        switch(process_branch) {

            case 0:

                $(".date-set-area").addClass(class_name);
                $(".date-set-process-area").addClass(class_name);    
                break;

            case 1:

                $(".password-set-area").addClass(class_name);
                $(".date-set-process-area").addClass(class_name);
    
                break;

            case 2:

                $(".password-set-area").addClass(class_name);
                $(".date-set-area").addClass(class_name);    
                break;
            default:
  
        }

    }


    $('#reset-button').click(function () {

        $("#send_password").val('');
        $("#send_password").focus();

        
        $('#job-password-item-name').val("");
        $('.publishing_period').html("");

        alert_reset();
        set_inoperable(0);
     
    });

    // 「パスワード確認」ボタンがクリックされたら
    $('#job-password-check-button').click(function () {

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
                                            
                                     

                        $('#job-password-item-name').val(job_password_item_name);
                        set_inoperable(1);                        

                    }else if(result_type >= 1){     
                        
                        alert_display("#main" , message);

                    }

                }else{       

                    
                
                }

            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
                //{{-- ボタン有効 --}}                
                end_processing();               

            });

    });



    //求人公開開始日時変更時
    $(document).on("click", "#date-setting-button", function (e) {

        alert_reset();
        var employer_id = $('#employer_id').val();
        var job_id = $('#job_id').val();   
        var publish_start_date = $('#publish_start_date').val();
        var password = $('#send_password').val();

        if(publish_start_date == ""){
            alert_display("#main" , "公開開始日を設定してください。");
            $('#publish_start_date').focus();            
            return false;
        }
        

        start_processing("#main");

        
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

                var display_message = "";
                if(result == 'success'){


                    var get_info_array = result_array["get_info_array"];

                    var result_type = get_info_array["result_type"];                                        

                    if(result_type == 0){

                        var publish_start_date = get_info_array["publish_start_date"];
                        var publish_end_date = get_info_array["publish_end_date"];
                        var added_date = get_info_array["added_date"];
                        
                        display_message = publish_start_date + "～" + publish_end_date;                        
                                    
                        set_inoperable(2);                        

                    }else if(result_type == 1 || result_type == 2){
                        
                        display_message = get_info_array["message"];                          

                    }else if(result_type == 3){
                        
                        var branch_number = get_info_array["branch_number"]; 
                        display_message =  "公開番号【" + branch_number + "】と公開期間が重複しています。";                                                

                    }                                   

                }else{       

                    display_message = get_info_array["message"];
                
                }   
                
                $('.publishing_period').html(display_message);
            
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

        alert_reset();        
        var employer_id = $('#employer_id').val();
        var job_id = $('#job_id').val();        
        var password = $('#send_password').val();
        var publish_start_date = $('#publish_start_date').val();



        start_processing("#main");

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
                }
            
            })
            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
                end_processing();                         

            });


    });




});

</script>
@endsection

