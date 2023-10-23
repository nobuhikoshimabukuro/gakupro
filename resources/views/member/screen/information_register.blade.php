@php


        $extends = "member.common.layouts_beforelogin";
        $title = "情報登録画面";
        $action = route('member.information_save');
        $process_button = "登録";   

@endphp


@extends($extends)


@section('pagehead')



@section('title', $title)  



@endsection
@section('content')

<style>

   

</style>

<div id="main" class="mt-3 text-center container">    
 
    <div class="row p-0">

        <div class="ajax-msg m-2">            
        </div>

        <form id="save_form" method="post" action="{{ route('member.information_save') }}">
        @csrf

            

        <div class="row m-1">          

            <div class="col-xl-6 col-sm-12">  

                <div class="pdf" style="width: 100%; height:100%">  
                    <embed src="{{ asset('pdf/privacypolicy.pdf')}}" type="application/pdf" style="width: 100%; height:100%">
                </div>

            </div>
            
            <div class="col-xl-6 col-sm-12">  

                <div class="form-group row">

                    <label for="member_last_name" class="col-12 col-form-label original-label">氏名</label>                                
                    <div class="col-5 p-0 last_name_class">
                        <input type="text" name="member_last_name" id="member_last_name" value="" class="form-control col-md-3">
                    </div>
                  
                    <div class="col-5 m-0 p-0">
                        <input type="text" name="member_first_name" id="member_first_name" value="" class="form-control col-md-3">
                    </div>


                    <label for="member_last_name_yomi" class="col-12 col-form-label original-label">シメイ</label>
                    
                    <div class="col-5 p-0 last_name_class">
                        <input type="text" name="member_last_name_yomi" id="member_last_name_yomi" value="" class="form-control col-md-3 last_name">
                    </div>
                    <div class="col-5 m-0 p-0">
                        <input type="text" name="member_first_name_yomi" id="member_first_name_yomi" value="" class="form-control col-md-3 first_name">
                    </div>      
                            
                    <label for="gender" class="col-md-6 col-form-label original-label">性別</label>                               
                    <select id='gender' name='gender' class='form-control input-sm'>		
                            <option value="">---</option>							
                            @foreach($gender_list as $item)
                                <option value="{{$item->gender_cd}}">
                                    {{$item->gender_name}}
                                </option>
                            @endforeach
                    </select>

                    <label for="birthday" class="col-md-6 col-form-label original-label">生年月日<span id="display_age"></span></label>                                
                    <input type="date" name="birthday" id="birthday" value="" class="form-control col-md-3">

                    <label for="tel" class="col-md-6 col-form-label original-label">TEL</label>
                    <input type="tel" name="tel" id="tel" value="" class="form-control col-md-3">

                    <label for="mailaddress" class="col-md-6 col-form-label original-label">メールアドレス</label>
                    <p class="text-start"style="text-decoration: none; border-bottom: 0.5px solid rgb(131, 126, 126); padding-bottom: 2px;">{{$mailaddress}}</p>
                    <input type="hidden" name="mailaddress" id="mailaddress" value="{{$mailaddress}}" class="form-control col-md-3" readonly>

                    <label for="school_cd" class="col-md-6 col-form-label original-label">学校選択</label>
                    <select id='school_cd' name='school_cd' class='form-control input-sm'>									
                        <option value="">---</option>
                        @foreach($school_list as $item)
                        <option value="{{$item->school_cd}}">
                            {{$item->school_name}}
                        </option>
                        @endforeach
                    </select>

                    <label for="majorsubject_cd" class="col-md-6 col-form-label original-label">専攻選択</label>
                    <select id='majorsubject_cd' name='majorsubject_cd' class='form-control input-sm impossible'>
                        <option value="">学校を選択してください。</option>
                        @foreach($majorsubject_list as $item)
                        <option value="{{$item->majorsubject_cd}}" data-memberid='{{$item->member_id}}'>
                            {{$item->majorsubject_name}}
                        </option>
                        @endforeach
                    </select>

                    <label for="admission_yearmonth" class="col-md-6 col-form-label original-label">入学年月</label>
                    <input type="month" name="admission_yearmonth" id="admission_yearmonth" value="" class="form-control col-md-3">

                    <label for="graduation_yearmonth" class="col-md-6 col-form-label original-label">卒業予定年月</label>
                    <input type="month" name="graduation_yearmonth" id="graduation_yearmonth" value="" class="form-control col-md-3">

                    <label for="emergencycontact_relations" class="col-md-6 col-form-label original-label">緊急時連絡先</label>
                    <input type="text" name="emergencycontact_relations" id="emergencycontact_relations" value="" placeholder="両親、兄弟など" class="form-control col-md-3">

                    <label for="emergencycontact_tel" class="col-md-6 col-form-label original-label">緊急時連絡先電話番号</label>
                    <input type="text" name="emergencycontact_tel" id="emergencycontact_tel" value="" class="form-control col-md-3">
                                                 
                
                    <button type="button" id='save_button' class="original_button save_button">登録</button>
                </div>           
                
            </div>


        </div>       
    

        </form>

    </div>


      
    
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){

    $(window).on('load', function() { 

        

    });


    window.addEventListener("beforeunload", function(e) {

        var login_flg = $('#login_flg').val();
        if(login_flg == 0){
            var confirmationMessage = "入力内容を破棄します。";
            e.returnValue = confirmationMessage;
            return confirmationMessage;
        }
        
    });



    $(document).on("blur", "#admission_yearmonth", function (e) {
        graduation_yearmonth_get();
    });

    $(document).on("blur", "#birthday", function (e) {
        age_measurement();
    });

    function age_measurement(){

        var display_age = "";

        var input_birthday = new Date($('#birthday').val());

        if(input_birthday == "" ){
            return false;
        }
      
        //今日
        var today = new Date();
 
        //今年の誕生日
        var thisYearsBirthday = new Date(today.getFullYear(), input_birthday.getMonth(), input_birthday.getDate());

        //年齢
        var age = today.getFullYear() - input_birthday.getFullYear();

        if(today < thisYearsBirthday){
            //今年まだ誕生日が来ていない
            age--;
        }

        if($.isNumeric(age)){

            if(age < 0){
                age = 0;
            }
            display_age = "【" + age + "歳】"
        }

        $('#display_age').html(display_age);
    }


    $('#search_school_division').change(function() {
        school_list_get(1);
    });

    $('#search_school_cd').change(function() {
        majorsubject_list_get(1);
    });

    $('#school_cd').change(function() {
        majorsubject_list_get(2);
    });


    function graduation_yearmonth_get(){
    
        var school_cd = $('#school_cd').val();
        var majorsubject_cd = $('#majorsubject_cd').val();
        var admission_yearmonth = $('#admission_yearmonth').val();

        var graduation_yearmonth = $('#graduation_yearmonth').val();

        var get_graduation_yearmonth = "";

        if(school_cd != "" && majorsubject_cd != "" && admission_yearmonth != "" && graduation_yearmonth == ""){

            var check_date = new Date((admission_yearmonth + "-01").replace("-", "/"));
                        
            var studyperiod = $('[name=majorsubject_cd] option:selected').data('studyperiod');

            check_date.setMonth(check_date.getMonth() + studyperiod);

            get_graduation_yearmonth = check_date.getFullYear() + "-" + check_date.getMonth().toString().padStart(2, "0");
        }

        if(get_graduation_yearmonth != ""){
            $('#graduation_yearmonth').val(get_graduation_yearmonth);
        }


    }

    function school_list_get(branch){
       
        var target_form_id = "";
        var search_school_division = "";
        var target_element_id = "";
       
        if(branch == 1){

            target_form_id = "#search_form";
            search_school_division = $('#search_school_division').val();
            target_element_id = "#search_school_cd";
        }else if(branch == 2){

            target_form_id = "#save_form";
            search_school_division = $('#school_division').val();
            target_element_id = "#school_cd";
        }

       $("select" + target_element_id + " option").remove();

       $(target_element_id).removeClass("impossible");
       
       if(search_school_division == ""){
           $(target_element_id).addClass("impossible");
           $(target_element_id).append($("<option>").val("").text("学校区分を選択してください。"));
           return false;
       }

       //マウスカーソルを砂時計に
       document.body.style.cursor = 'wait';
       $(target_form_id).addClass("impossible");
       
       var Url = "{{ route('get_data.school_list_get')}}"

       $.ajax({
           url: Url, // 送信先
           type: 'get',
           dataType: 'json',
           data: {search_school_division : search_school_division},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}

       })
       .done(function (data, textStatus, jqXHR) {
           // テーブルに通信できた場合
           var result_array = data.result_array;

           var status = result_array["status"];

           //テーブルに通信時、データを検索できたか判定
           if (status == 'success') {

                var school_list = result_array["school_list"];

                $(target_element_id).append($("<option>").val("").text("------"));
                $.each(school_list, function(index, info) {

                    var school_cd = info["school_cd"];
                    var school_name = info["school_name"];

                    $(target_element_id).append($("<option>").val(school_cd).text(school_name));

                })

               $(target_element_id).removeClass("impossible");
               
           }else if(status == 'nodata'){
                       
               $(target_element_id).append($("<option>").val('').text('学校情報なし'));

           }else{
        
               $(target_element_id).append($("<option>").val('').text('学校情報取得エラー'));

           }

           //マウスカーソルを通常に
           document.body.style.cursor = 'auto';
           $(target_form_id).removeClass("impossible");

       })
           .fail(function (data, textStatus, errorThrown) {
           
                 //マウスカーソルを通常に
               document.body.style.cursor = 'auto';
               $(target_form_id).removeClass("impossible");
               $(target_element_id).append($("<option>").val('').text('学校情報取得エラー'));

           });


   }


    function majorsubject_list_get(branch){
       
        var target_form_id = "";
        var search_school_cd = "";
        var target_element_id = "";
        
        if(branch == 1){

            target_form_id = "#search_form";
            search_school_cd = $('#search_school_cd').val();
            target_element_id = "#search_majorsubject_cd";
        }else if(branch == 2){

            target_form_id = "#save_form";
            search_school_cd = $('#school_cd').val();
            target_element_id = "#majorsubject_cd";
        }

        $("select" + target_element_id + " option").remove();

        $(target_element_id).removeClass("impossible");
        
        if(search_school_cd == ""){
            $(target_element_id).addClass("impossible");
            $(target_element_id).append($("<option>").val("").text("学校を選択してください。"));
            return false;
        }

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';
        $(target_form_id).addClass("impossible");

        var Url = "{{ route('get_data.majorsubject_list_get')}}"

        $.ajax({
            url: Url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {search_school_cd : search_school_cd},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}

        })
        .done(function (data, textStatus, jqXHR) {
            // テーブルに通信できた場合
            var result_array = data.result_array;

            var status = result_array["status"];

            //テーブルに通信時、データを検索できたか判定
            if (status == 'success') {

                var majorsubject_list = result_array["majorsubject_list"];

                $(target_element_id).append($("<option>").val("").text("------"));
                $.each(majorsubject_list, function(index, info) {

                    var majorsubject_cd = info["majorsubject_cd"];
                    var majorsubject_name = info["majorsubject_name"];
                    var studyperiod = info["studyperiod"];

                    var append_text = "<option value='" + majorsubject_cd + "' data-studyperiod='" + studyperiod + "'>" + majorsubject_name + "</option>";
                                    
                
                    $(target_element_id).append(append_text);
                    

                })

                $(target_element_id).removeClass("impossible");
                
            }else if(status == 'nodata'){
                        
                $(target_element_id).append($("<option>").val('').text('専攻情報なし'));

            }else{
         
                $(target_element_id).append($("<option>").val('').text('専攻情報取得エラー'));

            }

            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';
            $(target_form_id).removeClass("impossible");

        })
            .fail(function (data, textStatus, errorThrown) {
            
                  //マウスカーソルを通常に
                document.body.style.cursor = 'auto';
                $(target_form_id).removeClass("impossible");
                $(target_element_id).append($("<option>").val('').text('専攻情報取得エラー'));

            });


    }

    

    // 「保存」ボタンがクリックされたら
    $('#save_button').click(function () {
        
        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $(this).prop("disabled", true);

        setTimeout(function () {
            $('#save_button').prop("disabled", false);
        }, 3000);

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        let f = $('#save_form');

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';

        $.ajax({
            url: f.prop('action'), // 送信先
            type: f.prop('method'),
            dataType: 'json',
            data: f.serialize(),
        })
            // 送信成功
            .done(function (data, textStatus, jqXHR) {
                
                var result_array = data.result_array;

                var Result = result_array["Result"];

                if(Result=='success'){

                     //{{-- アラートメッセージ表示 --}}
                     var errorsHtml = '';
                    errorsHtml = '<div class="alert alert-danger text-start">';
                    errorsHtml += '<li class="text-start">登録成功</li>';
                    errorsHtml += '</div>';

                        //{{-- アラート --}}
                    $('.ajax-msg').html(errorsHtml);
                    //{{-- 画面上部へ --}}
                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");
                    //{{-- ボタン有効 --}}
                    $('#save_button').prop("disabled", false);
                    //{{-- マウスカーソルを通常に --}}                    
                    document.body.style.cursor = 'auto';

                }else{

                    var ErrorMessage = result_array["Message"];

                    //{{-- アラートメッセージ表示 --}}
                    var errorsHtml = '';
                    errorsHtml = '<div class="alert alert-danger text-start">';
                    errorsHtml += '<li class="text-start">' + ErrorMessage + '</li>';
                    errorsHtml += '</div>';

                        //{{-- アラート --}}
                    $('.ajax-msg').html(errorsHtml);
                    //{{-- 画面上部へ --}}
                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");
                    //{{-- ボタン有効 --}}
                    $('#save_button').prop("disabled", false);
                    //{{-- マウスカーソルを通常に --}}                    
                    document.body.style.cursor = 'auto';

                }

            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
                //{{-- アラートメッセージ表示 --}}
                let errorsHtml = '<div class="alert alert-danger text-start">';

                if (data.status == '422') {
                    //{{-- vlidationエラー --}}
                    $.each(data.responseJSON.errors, function (key, value) {
                        //{{-- responsからerrorsを取得しメッセージと赤枠を設定 --}}
                        errorsHtml += '<li  class="text-start">' + value[0] + '</li>';
                    
                        $("[name='" + key + "']").addClass('is-invalid');
                        
                        $("[name='" + key + "']").next('.invalid-feedback').text(value);
                    });

                } else {

                    //{{-- その他のエラー --}}
                    errorsHtml += '<li class="text-start">登録処理エラー</li>';

                }

                errorsHtml += '</div>';
                
                //{{-- アラート --}}
                // $('.ajax-msg').html(errorsHtml);
                //{{-- 画面上部へ --}}
                $("html,body").animate({
                    scrollTop: 0
                }, "300");
                //{{-- ボタン有効 --}}
                $('#save_button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';

            });

    });











});

</script>
@endsection

