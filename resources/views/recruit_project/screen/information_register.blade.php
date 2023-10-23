@php

    if($login_flg == 0){
        $extends = "recruit_project.common.layouts_beforelogin";
        $title = "雇用者情報登録画面";
        $action = route('recruit_project.information_save');
        $process_button = "登録";

    }elseif($login_flg == 1){

        $extends = "recruit_project.common.layouts_afterlogin";
        $title = "雇用者情報編集画面";
        $action = route('recruit_project.information_update');
        $process_button = "更新";
    }


@endphp


@extends($extends)


@section('pagehead')



@section('title', $title)



@endsection
@section('content')

<style>
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


select
{
  -moz-appearance: none;
  /* -webkit-appearance: none; */
  -webkit-box-shadow: none;
  box-shadow: none;
  outline: none;
  border: none;

  background: #ebf4f8;
  /* display: block; */
  display: inline;
  font-size: 16px;
  padding: 7px 2px;
  transition: 0.8s;
  margin: 0;
  border-radius: 6px;
  font-weight: 600;
}


input[type="text"]
,input[type="tel"]
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
,input[type="tel"]:placeholder-shown
{
    background: #243355;

}

input[type="text"]:focus
,input[type="tel"]:focus
,select:focus
{
  /* background: #e9f5fb; */
  background: #f7f7f6;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}


input::placeholder{
  color: white;
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
    background: linear-gradient(-225deg, #e7e7e5 0%, #e8e8e6 56%, #e9e9e9 100%);

    position: relative;
    text-align: left;
    padding: 1vw;
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


.span-mailaddress{
    padding: 7px;
    font-weight: 650;

}

#employer_name
,#employer_name_kana
,#address1
,#address2
,#hp_url
{
    width: calc( 100% - 40px );
}

#employer_division
,#tel
,#fax
{
    width: 130px;
}

#post_code1
{
    text-align: center;
    width: 45px;
}

#post_code2
{
    text-align: center;
    width: 60px;
}


.required{
    display:inline;
    background-color: red;
    color: wheat;
    font-weight: 500;
    text-align: center;
    border-radius: 7px; /* ボックスの四つ角を丸くする */
    padding: 0 3px 0 3px;
    
}

.error-border{
    border: solid red ;
}

.hyphen{
    padding: 0;
    font-size: 21px;
    font-weight: 700;
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

    .non-mobile{
        /* display: none; */
    }
    .mobile{
        display: none;
    }


}



/* スマホ用 */
@media (max-width:768px) {  /*画面幅が768px以下の場合とする*/

    .non-mobile{
        display: none;
    }
    .mobile{
        /* display: none; */
    }

    .form-table th,
    .form-table td {
        display: block;
        width: 100%;
    }

    .form-table th {
        border-right: none;
    }

    #employer_name
    ,#employer_name_kana
    ,#address1
    ,#address2
    ,#hp_url
    {
        width: 100%;
    }

}





</style>

<div id="main" class="mt-3 text-center container">

    <div class="row p-0 d-flex justify-content-center">

        <div class="col-11 col-md-9">

            <div class="ajax-msg m-2">
            </div>

            <form id="save_form" method="post" action="{{ $action }}">
                @csrf

            <table class="form-table">

                <tbody>

                    <tr class="employer_division-tr">
                        <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                            雇用者区分<span class="required mobile">必須</span>
                        </th>
                        <td>

                            <select id='employer_division' name='employer_division' class=''>                             
                                @foreach($employer_division_list as $item)
                                    <option value="{{$item->employer_division_cd}}" 
                                        @if(($login_flg == 1) && ($item->employer_division_cd == $employer_info->employer_division)) selected @endif>
                                        {{$item->employer_division_name}}
                                    </option>
                                @endforeach
                            </select>
                            <span class="required non-mobile">必須</span>

                        </td>


                    </tr>

                    <tr class="employer_name-tr">
                        <th class="">
                            雇用者名<span class="required mobile">必須</span>
                        </th>
                        <td>

                            <input type="text" name="employer_name" id="employer_name" class="" placeholder="例：株式会社崎原商事"
                            value="@if($login_flg == 1){{$employer_info->employer_name}}@endif">
                            <span class="required non-mobile">必須</span>

                        </td>


                    </tr>

                    <tr class="employer_name_kana-tr">
                        <th>
                            雇用者名カナ<span class="required mobile">必須</span>
                        </th>
                        <td>
                            <input type="text" name="employer_name_kana" id="employer_name_kana" class="" placeholder="例：カブシキガイシャサキハラショウジ"
                            value="@if($login_flg == 1){{$employer_info->employer_name_kana}}@endif">
                            <span class="required non-mobile">必須</span>
                        </td>

                    </tr>

                    <tr class="tel-tr">
                        <th>
                            TEL
                        </th>
                        <td>
                            <input type="tel" name="tel" id="tel" class="" placeholder="例：098-123-1234"
                            value="@if($login_flg == 1){{$employer_info->tel}}@endif">
                        </td>

                    </tr>

                    <tr class="fax-tr">
                        <th>
                            FAX
                        </th>
                        <td>
                            <input type="tel" name="fax" id="fax" class="" placeholder="例：098-987-6543"
                            value="@if($login_flg == 1){{$employer_info->tel}}@endif">
                        </td>

                    </tr>

                    <tr class="mailaddress-tr">
                        <th>
                            メールアドレス
                        </th>
                        <td>
                            <input type="hidden" name="mailaddress" id="mailaddress" class="" value="@if($login_flg == 0){{$mailaddress}}@elseif($login_flg == 1){{$employer_info->mailaddress}}@endif">
                            <div class="row m-0 p-0">
                                <div class="col-10 m-0 p-0 text-start">
                                    <span class="span-mailaddress">@if($login_flg == 0){{$mailaddress}}@elseif($login_flg == 1){{$employer_info->mailaddress}}@endif</span>
                                </div>

                                <div class="col-2 m-0 p-0">

                                </div>

                            </div>

                        </td>

                    </tr>

                    <tr class="post_code-tr">
                        <th>
                            郵便番号                            
                        </th>
                        <td  style="">

                            @php
                                $post_code = "";
                                $post_code1 = "";
                                $post_code2 = "";
                                if($login_flg == 1){
                                    $post_code = $employer_info->post_code;

                                    $post_code1 = substr($post_code, 0, 3);  // 最初から3文字取得
                                    $post_code2 = substr($post_code, 4);     // 4文字目から最後まで取得
                                }


                            @endphp

                            <input type="text" name="post_code1" id="post_code1" value="{{$post_code1}}" placeholder="例：904">
                            <span class="hyphen">-</span>
                            <input type="text" name="post_code2" id="post_code2" value="{{$post_code2}}" placeholder="例：0002">

                            <input type="hidden" name="post_code" id="post_code" placeholder="" value="">

                            <button type="button" id="address_search_button" class="btn btn-warning mb-1">検索<i class="fas fa-search"></i></button>

                        </td>

                    </tr>

                    <tr class="address1-tr">
                        <th>
                            住所1
                        </th>
                        <td>
                            <input type="text" name="address1" id="address1" class="" placeholder="例：沖縄県沖縄市安慶田0-0-0"
                            value="@if($login_flg == 1){{$employer_info->address1}}@endif">
                        </td>

                    </tr>

                    <tr class="address2-tr">
                        <th>
                            住所2
                        </th>
                        <td>
                            <input type="text" name="address2" id="address2" class="" placeholder="例：崎原ビル101"
                            value="@if($login_flg == 1){{$employer_info->address2}}@endif">
                        </td>

                    </tr>

                    <tr class="hp_url-tr">
                        <th>
                            HP_URL
                        </th>
                        <td>
                            <input type="text" name="hp_url" id="hp_url" class="" placeholder="例：https://www.example.com/"
                            value="@if($login_flg == 1){{$employer_info->hp_url}}@endif">
                        </td>
                    </tr>




                </tbody>
            </table>

            <div class="row text-end">
                <div class="col-12 mt-3">
                    <button type="button" id="save_button" class="btn btn-primary" >{{$process_button}}</button>
                </div>
            </div>

            </form>

        </div>
    </div>
</div>

@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){

    $(window).on('load', function() {

        required_check();

    });

    $(document).on('blur', '#employer_name,#employer_name_kana' , function() {	

        required_check();

    });

    function required_check(){

        $('.item-flash').removeClass('item-flash');

        var employer_name = $('#employer_name').val();
        var employer_name = employer_name.replace(/\s/g, "");
        if(employer_name == ""){
            $('#employer_name').val("");
            $(".employer_name-tr .required").addClass('item-flash');
        }

        var employer_name_kana = $('#employer_name_kana').val();
        var employer_name_kana = employer_name_kana.replace(/\s/g, "");
        if(employer_name_kana == ""){
            $('#employer_name_kana').val("");
            $(".employer_name_kana-tr .required").addClass('item-flash');
        }        

    }

    window.addEventListener("beforeunload", function(e) {

        var login_flg = $('#login_flg').val();
        if(login_flg == 0){
            var confirmationMessage = "入力内容を破棄します。";
            e.returnValue = confirmationMessage;
            return confirmationMessage;
        }

    });


    // url_check_button押下イベント
	$('#url_check_button').on('click', function() {


        $("#hp_url").removeClass('is-invalid');
        $('#hp_url').attr('placeholder', 'https://www.example.com/');
        var Url = $('#hp_url').val();

        if(Url == ""){
            $("#hp_url").addClass('is-invalid');
            $('#hp_url').attr('placeholder', 'URLを入力してください。');
            return false;
        }


        $(this).prop("disabled", true);

        var vh = $(window).height() / 2;
        var vw = $(window).width() / 2;
        var top = vh;
        var left = vw;

        var SubWindowPosition = "top=" + top + ",left=" + left + ",width=" + vw + ",height=" + vh ;

        var Newwindow = window.open(Url,1,'toolbar=no,status=no,menubar=no,scrollbars=yes,' + SubWindowPosition);

        setTimeout(function(){

            Newwindow.close();
            $('#url_check_button').prop("disabled", false);

        },5000);

        return false;

    });



    // address_search_button押下イベント
	$('#address_search_button').on('click', function() {

        $('.ajax-msg').html("");        

        var post_code1 = $('#post_code1').val();
        var post_code1_judge = true;
        var post_code2 = $('#post_code2').val();
        var post_code2_judge = true;



		if(!$.isNumeric(post_code1)){
            post_code1_judge = false;		
		}

        if(!$.isNumeric(post_code2)){
            post_code2_judge = false;		
		}


        if(post_code1_judge == false || post_code2_judge == false){

            let errorsHtml = '<div class="alert alert-danger text-start">';
			errorsHtml += '<li>郵便番号は数字で入力してください</li>';
			errorsHtml += '</div>';

			//{{-- アラート --}}
			$('.ajax-msg').html(errorsHtml);
			//{{-- 画面上部へ --}}
			$("html,body").animate({
				scrollTop: 0
			}, "300");

            if(post_code1_judge == false){
                $("#post_code1").focus();
                $("#post_code1").addClass('is-invalid');
            }

            if(post_code2_judge == false){
                $("#post_code2").focus();
                $("#post_code2").addClass('is-invalid');                
            }

			return false;
        }

        var address1 = $('input[name="address1"]').val();

        if(address1 != ""){

            var message = "住所1の項目に既に入力があります。"
                message += "\n"
                message += "住所1に検索処理にて取得した住所が上書きされます。"
                message += "\n"
                message += "住所検索を実行しますか？"

            if (confirm(message)) {
                $('input[name="address1"]').val("");
            } else {
                $('input[name="address1"]').focus();
                return false
            }
        }


		//マウスカーソルを砂時計に
		document.body.style.cursor = 'wait';

		//プレースホルダーの初期化

		$('input[name="address1"]').removeAttr('placeholder');

		var Zipcode = post_code1 + '-' + post_code2;

		//受け取った入力値をセット
		var parameter = {zipcode:Zipcode}

		//zipcloudのAPIのURL
		var zipcloud_url = "https://zipcloud.ibsnet.co.jp/api/search";

		$.ajax({
		type: "GET",
		cache: false,
		data: parameter,
		url: zipcloud_url,
		dataType: "jsonp",
		success: function (ReturnValue) {

			//結果によって処理を振り分ける
			//status == 200は、送信成功＆正常に値が返却された場合
			if (ReturnValue.status == 200) {

				//郵便番号で取得できた情報が0件の場合
				//該当する住所が無いと判断
				if(ReturnValue.results === null){

					var ErrorMessage = '住所情報所得なし';
					//プレースホルダーを設定する
					$('input[name="Addr1"]').attr('placeholder', ErrorMessage);

					//マウスカーソルを通常に
					document.body.style.cursor = 'auto';

				//郵便番号で取得できた情報が1件の場合
				//郵便番号で絞り込み成功
				}else if(ReturnValue.results.length == 1){

					var AddressInfo = ReturnValue.results[0];
					var zipcode = AddressInfo.zipcode;
					var prefcode = AddressInfo.prefcode;
					var address1 = AddressInfo.address1;
					var address2 = AddressInfo.address2;
					var address3 = AddressInfo.address3;
					var kana1 = AddressInfo.kana1;
					var kana2 = AddressInfo.kana2;
					var kana3 = AddressInfo.kana3;

                    var addressinfo = address1 + address2 + address3;

					$('input[name="address1"]').val(addressinfo);
					$('input[name="address1"]').focus();

					//マウスカーソルを通常に
					document.body.style.cursor = 'auto';

				//郵便番号で取得できた情報が2件以上の場合
				}else if(ReturnValue.results.length > 1){

					var ErrorMessage = '2件以上の住所情報取得';
					//プレースホルダーを設定する
					$('input[name="address1"]').attr('placeholder', ErrorMessage);

					//マウスカーソルを通常に
					document.body.style.cursor = 'auto';
				}

			} else {
			//送信失敗、または他のエラー時

                var ErrorMessage = '住所情報所得なし';
				//プレースホルダーを設定する
				$('input[name="address1"]').attr('placeholder', ErrorMessage);

				//マウスカーソルを通常に
				document.body.style.cursor = 'auto';
			}
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
				var ErrorMessage = '住所検索処理でエラーが発生しました';
				//プレースホルダーを設定する
				$('input[name="Addr1"]').attr('placeholder', ErrorMessage);

				//マウスカーソルを通常に
				document.body.style.cursor = 'auto';
			}
		});





    });






    // 処理実行ボタンがクリックされたら
    $('#save_button').click(function () {

        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $('#save_button').prop("disabled", true);

        setTimeout(function () {
            $('#save_button').prop("disabled", false);
        }, 3000);

        var post_code1 = $('#post_code1').val();
        var post_code2 = $('#post_code2').val();        

        if(post_code1 == '' && post_code2 == ''){
            $('#post_code').val("");
        }else{
            $('#post_code').val(post_code1 + "-" + post_code2);
        }
        

        $('.ajax-msg').html('');
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

                //{{-- ボタン有効 --}}
                $('#save_button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}
                document.body.style.cursor = 'auto';


                var result_array = data.result_array;

                var Result = result_array["Result"];

                if(Result=='success'){

                    //画面遷移時のメッセージ表示抑制の為(addEventListener)
                    $('#login_flg').val("1");
                    var Url = result_array["Url"];

                    //※新規登録処理成功時と更新処理成功時の画面遷移先は別

                    //新規登録処理成功時はログインIDとパスワードのお知らせ画面
                    //更新処理成功時は雇用者情報管理画面
                    window.location.href = Url;

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

                }


            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {

                //{{-- ボタン有効 --}}
                $('#save_button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}
                document.body.style.cursor = 'auto';

                //{{-- アラートメッセージ表示 --}}
                let errorsHtml = '<div class="alert alert-danger text-start">';

                if (data.status == '422') {
                    //{{-- vlidationエラー --}}
                    $.each(data.responseJSON.errors, function (key, value) {
                        //{{-- responsからerrorsを取得しメッセージと赤枠を設定 --}}
                        errorsHtml += '<li  class="text-start">' + value[0] + '</li>';

                        if(key == "post_code"){

                            $("[name='post_code1']").addClass('error-border');
                            $("[name='post_code2']").addClass('error-border');                            
                        }else{
                            $("[name='" + key + "']").addClass('error-border');                            
                        }
                        
                    });

                } else {

                    //{{-- その他のエラー --}}
                    // errorsHtml += '<li class="text-start">' + data.status + ':' + errorThrown + '</li>';
                    errorsHtml += '<li  class="text-start">エラーが発生しました</li>';

                }

                errorsHtml += '</div>';

                //{{-- アラート --}}
                $('.ajax-msg').html(errorsHtml);
                //{{-- 画面上部へ --}}
                $("html,body").animate({
                    scrollTop: 0
                }, "300");


            });

    });








});

</script>
@endsection

