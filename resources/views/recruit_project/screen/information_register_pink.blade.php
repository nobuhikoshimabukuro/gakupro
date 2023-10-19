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
  margin: 60px auto 40px;
}
 
input[type="submit"],
input[type="text"],
select,
textarea,
button {
  -moz-appearance: none;
  -webkit-appearance: none;
  -webkit-box-shadow: none;
  box-shadow: none;
  outline: none;
  border: none;
}
 
 
input[type="text"],
textarea {
  background: #f8f8f8;
  display: block;
  font-size: 16px;
  /* padding: 12px 15px; */
  padding: 10px;
  width: 480px;
  width: 100%;
  transition: 0.8s;
  border-radius: 0;
}
 
input[type="text"]:focus,
textarea:focus {
  background: #e9f5fb;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
 
textarea[name="content"] {
  display: inline-block;
  width: 100%;
  height: 200px;
}
 
input::placeholder,
textarea::placeholder {
  color: #ccc;
}
 
/* ::-webkit-input-placeholder {
  color: #ccc;
  opacity: 1;
}
 
::-moz-placeholder {
  color: #ccc;
  opacity: 1;
}
 
:-ms-input-placeholder {
  color: #ccc;
  opacity: 1;
} */
 
.form-table {
  width: 100%;
}
 
.form-table th,
.form-table td {
  border-top: 1px solid #d7d7d7;
  border-bottom: 1px solid #d7d7d7;
  padding: 20px;
}
 
.form-table th {
  background: #ffecea;
  padding-left: 50px;
  position: relative;
  text-align: left;
  width: 300px;
}


/* スマホ用 */
@media (max-width:768px) {  /*画面幅が768px以下の場合とする*/

    .form-table th,
    .form-table td {
    display: block;
    width: 100%;
    border-bottom: none;
    }
 


}


 

 

</style>

<div id="main" class="mt-3 text-center container">
    
 

    <div class="row p-0">

        <div class="ajax-msg m-2">            
        </div>

        <form id="save_form" method="post" action="{{ $action }}">
        @csrf

        <table class="form-table">
            <tbody>
              <tr>
                <th>氏名</th>
                <td><input type="text" name="name" size="60" value="" placeholder="山田太郎">
                </td>
              </tr>
              <tr>
                <th>メールアドレス</th>
                <td><input type="text" name="email" size="60" value="" placeholder="sample@sample.jp">
                </td>
              </tr>
              <tr>
                <th>電話番号</th>
                <td><input type="text" name="tel" size="60" value="" placeholder="03-1234-5678">
                </td>
              </tr>             
            </tbody>
          </table>

        </form>

    </div>


      
    
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){

    $(window).on('load', function() { 

        LoaderEnd();

    });


    window.addEventListener("beforeunload", function(e) {

        var login_flg = $('#login_flg').val();
        if(login_flg == 0){
            var confirmationMessage = "入力内容を破棄します。";
            e.returnValue = confirmationMessage;
            return confirmationMessage;
        }
        
    });


    // UrlcheckButton押下イベント
	$('#UrlcheckButton').on('click', function() {
	

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
            $('#UrlcheckButton').prop("disabled", false);

        },5000);

        return false;

    });



    // AddressSearchButton押下イベント
	$('#AddressSearchButton').on('click', function() {
	
        $('.ajax-msg').html("");
        $("[name='post_code']").removeClass('is-invalid');

        var post_code = $('input[name="post_code"]').val();
		
        
		if(!$.isNumeric(post_code)){

			let errorsHtml = '<div class="alert alert-danger text-start">';			
			errorsHtml += '<li>郵便番号は数字7桁で入力してください</li>';
			errorsHtml += '</div>';
				
			//{{-- アラート --}}
			$('.ajax-msg').html(errorsHtml);
			//{{-- 画面上部へ --}}
			$("html,body").animate({
				scrollTop: 0
			}, "300");
			
			$("[name='post_code']").addClass('is-invalid');			

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

		var Zipcode = post_code.substr(0,3) + '-' + post_code.substr(3,4);

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
				var ErrorMessage = ReturnValue.message;				
				//プレースホルダーを設定する
				$('input[name="Addr1"]').attr('placeholder', ErrorMessage);                  			
			
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


                var ResultArray = data.ResultArray;

                var Result = ResultArray["Result"];

                if(Result=='success'){

                    //画面遷移時のメッセージ表示抑制の為(addEventListener)
                    $('#login_flg').val("1");
                    var Url = ResultArray["Url"];
                    
                    //※新規登録処理成功時と更新処理成功時の画面遷移先は別

                    //新規登録処理成功時はログインIDとパスワードのお知らせ画面
                    //更新処理成功時は雇用者情報管理画面
                    window.location.href = Url;

                }else{

                    var ErrorMessage = ResultArray["Message"];

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
                    
                        $("[name='" + key + "']").addClass('is-invalid');                        
                        $("[name='" + key + "']").next('.invalid-feedback').text(value);
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

