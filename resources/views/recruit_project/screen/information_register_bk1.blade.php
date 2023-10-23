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

    .div-area{
        margin: 1vh;
        padding: 1vh;
    }

    .label-area{
        text-align: left;
    }

    label{        
        display:inline;
    }

    .input-area{
        text-align: left;
    }

    .required{
        display:inline;
        background-color: red;
        color: wheat;
        font-weight: 600;        
        text-align: center;
        border-radius: 10px; /* ボックスの四つ角を丸くする */
        padding: 0 3px 0 3px;        
    }

   

</style>

<div id="main" class="mt-3 text-center container">
    
 

    <div class="row p-0">

        <div class="ajax-msg m-2">            
        </div>

        <form id="save_form" method="post" action="{{ $action }}">
        @csrf

            <input type="hidden" name="login_flg" id="login_flg" class="form-control" value="{{$login_flg}}">

            <div class="row div-area">
                <div class="col-12 col-md-3 label-area">   
                    <label for="employer_division">雇用者区分</label>                
                    <div class="required">必須</div>                              
                </div>

                <div class="col-12 col-md-9 input-area">   
                    <select id='employer_division' name='employer_division' class='form-control input-sm'>
                            <option value="">
                                未選択
                            </option>
                            @foreach($employer_division_list as $item)
                                <option value="{{$item->employer_category_cd}}" @if(($login_flg == 1) && ($item->employer_division == $employer_info->employer_division)) selected @endif>
                                    {{$item->employer_division_name}}
                                </option>
                            @endforeach
                    </select>
                </div>
            </div>

            <div class="row div-area">
                <div class="col-12 col-md-3 label-area">   
                    <label for="employer_name">雇用者名</label>                
                    <div class="required">必須</div>                              
                </div>

                <div class="col-12 col-md-9 input-area">   
                    <input type="text" name="employer_name" id="employer_name" class="form-control" value="@if($login_flg == 1){{$employer_info->employer_name}}@endif">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="row div-area">
                <div class="col-12 col-md-3 label-area">   
                    <label for="employer_name_kana">雇用者名カナ</label>                
                    <div class="required">必須</div>                              
                </div>

                <div class="col-12 col-md-9 input-area">   
                    <input type="text" name="employer_name_kana" id="employer_name_kana" class="form-control" value="@if($login_flg == 1){{$employer_info->employer_name_kana}}@endif">                    
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="row div-area">
                <div class="col-12 col-md-3 label-area">   
                    <label for="tel">TEL</label>                
                    <div class="required">必須</div>                              
                </div>

                <div class="col-12 col-md-9 input-area">
                    
                    <input type="tel" name="tel" id="tel" class="form-control" value="@if($login_flg == 1){{$employer_info->tel}}@endif">                       
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="row div-area">
                <div class="col-12 col-md-3 label-area">   
                    <label for="fax">FAX</label>                                                         
                </div>

                <div class="col-12 col-md-9 input-area">
                    <input type="tel" name="fax" id="fax" class="form-control" value="@if($login_flg == 1){{$employer_info->fax}}@endif">                    
                    <div class="invalid-feedback"></div>
                </div>
            </div>


            <div class="row div-area">
                <div class="col-12 col-md-3 label-area">   
                    <label for="mailaddress">メールアドレス</label>
                </div>

                <div class="col-12 col-md-9 input-area">   
                    @if($login_flg == 0)
                        <input type="text" name="mailaddress" id="mailaddress" class="form-control" value="{{$mailaddress}}" readonly>
                    @elseif($login_flg == 1)
                        <input type="text" name="mailaddress" id="mailaddress" class="form-control" value="{{$employer_info->mailaddress}}" readonly>
                    @endif

                </div>
            </div>


            <div class="row div-area">
                <div class="col-12 col-md-3 label-area">   
                    <label for="post_code">郵便番号</label>                      
                    <button type="button" id="AddressSearchButton" class=""><i class="fas fa-search"></i></button>
                </div>

                <div class="col-12 col-md-9 input-area">   
                    <input type="text" name="post_code" id="post_code" class="form-control" value="@if($login_flg == 1){{$employer_info->post_code}}@endif">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="row div-area">
                <div class="col-12 col-md-3 label-area">   
                    <label for="address1">住所1</label>                                                
                </div>

                <div class="col-12 col-md-9 input-area">   
                    <input type="text" name="address1" id="address1" class="form-control" value="@if($login_flg == 1){{$employer_info->address1}}@endif">                    
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="row div-area">
                <div class="col-12 col-md-3 label-area">   
                    <label for="address2">住所2</label>                                                
                </div>

                <div class="col-12 col-md-9 input-area">   
                    <input type="text" name="address2" id="address2" class="form-control" value="@if($login_flg == 1){{$employer_info->address2}}@endif">                    
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="row div-area">
                <div class="col-12 col-md-3 label-area">   
                    <label for="url">HP_URL</label>                
                    <button type="button" id="UrlcheckButton" class="btn btn-warning" >Check</button>                                             
                </div>

                <div class="col-12 col-md-9 input-area">   

                    <input type="text" name="hp_url" id="hp_url" class="form-control" placeholder="https://www.example.com/" value="@if($login_flg == 1){{$employer_info->hp_url}}@endif"> 
                    <div class="invalid-feedback"></div>
                </div>
            </div>


            <div id="Buttonarea" class="row div-area">        
                <div class="col-12" align="right">              
                    <button type="button" id="save_button" class="btn btn-primary" >{{$process_button}}</button>
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

