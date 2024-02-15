@extends('hp.common.layouts_app_test')


@section('pagehead')
@section('title', '画像リサイズ')  
@endsection
@section('content')

<style>

body{
    overflow-y: scroll;
}



.image-area{       
    padding: 3px;
}

#upload-area{        
    margin-top: 1vh;
    margin-bottom: 1vh;
}


.upload-button-area{
    margin-top: 1vh;
    margin-bottom: 1vh;
}

.image{       
    width: 100%;
}

#drop_zone{        
    padding: 20px;
    border: 1px solid; 
}

</style>

<div id='main' class="mt-3 text-center container">        
        
        <div id='' class="row">

            <div class="ajax-msg"></div>

            <form action="{{ route('hp.image_resize_process') }}" id='upload_form' method="post" enctype="multipart/form-data" >
                @csrf

                <div class="row">   
                
                    <div id="upload-area">
                                    
                    
                                
                        <div id="drop_zone">               
                            <p>ファイルをドラッグ＆ドロップもしくはファイル選択してください。</p>
                            <p>※複数アップロードする場合は一度に選択してください。</p> 
                            <input type="file" id='file_input'name="file[]" lang="ja" accept=".jpg, .jpeg, .png, .gif" multiple>
                        </div>

                        <div class="upload-button-area d-none">
                            <div align="left">                        
                                <button type="button" class="reset-button btn btn-secondary">リセット <i class="fas fa-minus-square"></i></button>
                                <button type="button" class="upload-button btn btn-secondary">アップロード <i class="fas fa-cloud-upload-alt"></i></button>
                            </div>
                        </div>

                                

                        {{-- 画像を追加したらここにプレビュー画像が追加される↓ --}}
                        <div id="preview_area" class="row">
                        </div>
                            
                        <div class="upload-button-area d-none">
                            <div align="right">                        
                                <button type="button" class="reset-button btn btn-secondary">リセット <i class="fas fa-minus-square"></i></button>
                                <button type="button" class="upload-button btn btn-secondary">アップロード <i class="fas fa-cloud-upload-alt"></i></button>
                            </div>
                        </div>

                    </div>
                </div>

            </form>

        </div>
        
    </div>



    <div class="row video_forpc">
        <div class="col-12 col-md-6 col-lg-4">
    <div style="max-width: 500px; margin: 0 auto;">
      <div align="center" class="youtube_wrap">          
        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/BzkU254aUd8?si=eS_JQGsBnwXjhsm6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
      </div>
    </div>
    <div>
      <p class="mb-0 video_title">ストデリ概要編（2:52）</p>
      <span style="font-size:small;">専門店に預け、取りに行っていた常識から、宅配便を使って専門店を便利に活用する時代へ。</span>
    </div>
  </div>
        <div class="col-12 col-md-6 col-lg-4">
    <div style="max-width: 500px; margin: 0 auto;">
      <div align="center" class="youtube_wrap">          
        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/DSOAkawl38A?si=7bdRA2Nw2ACdXg6k" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
      </div>
    </div>
    <div>
      <p class="mb-0 video_title">ストデリ登録編（3:43）</p>
      <span style="font-size:small;">LINEアプリ会員登録や電子マネー登録の方法を紹介しています。</span>
    </div>
  </div>
        <div class="col-12 col-md-6 col-lg-4">
    <div style="max-width: 500px; margin: 0 auto;">
      <div align="center" class="youtube_wrap">          
        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/3QQEJlcD-9g?si=nH8V1W6jlfQJlDRY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
      </div>
    </div>
    <div>
      <p class="mb-0 video_title">ストデリ利用編（6:17）</p>
      <span style="font-size:small;">アプリを使ってガットやテンションの選択方法、梱包の手軽さを説明しています。</span>
    </div>
  </div>
      </div>

    
















      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>
      <div style="margin: auto; width:initial;"><a href='https://checkout.rakuten.co.jp/' target='_blank'><img alt='楽天ペイ' src='https://checkout.rakuten.co.jp/rpay/logo/w_wb_10091.jpg' border='0'/></a></div>






    @php
        phpinfo();
    @endphp

@endsection

@section('pagejs')

<script type="text/javascript">


$(function(){

    // 画像アップロード処理
    var drop_zone = document.getElementById('drop_zone');    
    var preview_area = document.getElementById('preview_area');
    var file_input = document.getElementById('file_input');

    //FormDataオブジェクトを作成
    var formData = new FormData();   

    drop_zone.addEventListener('dragover', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#e1e7f0';
    }, false);

    drop_zone.addEventListener('dragleave', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffffff';
    }, false);

    drop_zone.addEventListener('drop', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffffff'; //背景色を白に戻す
        var files = e.dataTransfer.files; //ドロップしたファイルを取得
        file_input.files = files; //inputのvalueをドラッグしたファイルに置き換える。
    }, false);

	file_input.addEventListener('change', function () {

		// プレビュー内で表示している画像を一旦クリア
		$("#preview_area").empty();

		// 選択したファイルの全情報取得
		let element = document.getElementById('file_input');

		// 選択したファイルをファイル名で格納
		let files = element.files;

		// 取得したファイル数分、画像をプレビューさせるメソッドを繰り返し呼び出し
		for (var i = 0; i < files.length; i++) {

			preview_image(this.files[i],i);
            $('.upload-button-area').removeClass('d-none');
		}

    });    

	

	//ファイルがドロップされたときに呼ばれる
	$('#drop_zone').on('drop', function(ev) {

		// プレビュー内で表示している画像を一旦全削除
		$("#preview_area").empty();

		var files = ev.originalEvent.dataTransfer.files;

		for (var i = 0; i < files.length; i++) {
			//FormDataオブジェクトにファイルを追加
			//名前は'document_files[]'
			formData.append('document_files[]', files[i]);

			preview_image(files[i],i);
          
            $('.upload-button-area').removeClass('d-none');
		}
        
	});


    function preview_image(file,i) {

        // プレビュー画像を追加する要素
        const preview_area = document.getElementById('preview_area');

        // FileReaderオブジェクトを作成
        const reader = new FileReader();

        // URLとして読み込まれたときに実行する処理
        reader.onload = function (e) {

            // URLはevent.target.resultで呼び出せる
            const imageUrl = e.target.result;

            // img要素を作成
            // ("embed")...jpeg,img,pingは通常表示、PDFファイルはスクロールバー付きで表示
            const img = document.createElement("embed");
            img.setAttribute('class', 'image');

            var preview_id = "Previewimage-area" + i;

            var Element ="<div id='"+ preview_id + "' class='col-6 col-md-4 col-xl-3 p-3 image-area'></div>";           

            
            $('#preview_area').append(Element);

            // URLをimg要素にセット
            img.src = imageUrl;

            const Previewimage_area = document.getElementById(preview_id);

            // #Previewの中に追加
            Previewimage_area.appendChild(img);
           
        }

        // ファイルをURLとして読み込む
        reader.readAsDataURL(file);
    }


    // リセットボタン押下イベント
	$('.reset-button').on('click', function() {
		//{{-- メッセージクリア --}}
		$('.ajax-msg').html('');	

        // プレビュー内で表示している画像を一旦全削除
        $("#preview_area").empty();
		$('.upload-button-area').addClass('d-none');
		$('.reset-button').blur();
        
        
        document.getElementById('file_input').value = '';
        
    });

    const selectedFiles = [];
    $('#file_input').on('change', function(event) {
        selectedFiles.push(event.target.files)
    })


    // upload-button押下時
    $('.upload-button').on("click", function () {

       
        let f = $('#upload_form');

        var formData = new FormData($('#upload_form').get(0));

        $.ajax({		
            url: f.prop('action'), //送信先
            type: f.prop('method'),
            dataType: 'json',
            processData: false,
            method: 'post',
            contentType: false,
            data: formData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            
        })
            .done(function (data, textStatus, jqXHR) {
            
                var result_array = data.result_array;

                var Result = result_array["Result"];

                if(Result=='success'){

                    var zip_name = result_array["zip_name"];
                    var zip_download_path = result_array["zip_download_path"];

                    var a = document.createElement('a');
                    a.download = zip_name;
                    a.href = zip_download_path;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);

                }else{

                    massage = "画像リサイズ処理でエラーが発生しました。";
                    var errorsHtml = '<div class="alert alert-danger text-start">';
                    errorsHtml += '<li>' + massage + '</li>';                    
                    errorsHtml += '</div>';

                    //{{-- アラート --}}    
                    $('.ajax-msg').html(errorsHtml);

                    //マウスカーソルを通常に
                    document.body.style.cursor = 'auto';
                    //{{-- ボタン有効 --}}
                    $('.upload-button').prop("disabled", false);

                    //{{-- 画面上部へ --}}
                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");
                

                }
            
            })
                .fail(function (data, textStatus, errorThrown) {

                    massage = "画像リサイズ処理でエラーが発生しました。";
                    var errorsHtml = '<div class="alert alert-danger text-start">';
                    errorsHtml += '<li>' + massage + '</li>';                    
                    errorsHtml += '</div>';

                    //{{-- アラート --}}    
                    $('.ajax-msg').html(errorsHtml);

                    //マウスカーソルを通常に
                    document.body.style.cursor = 'auto';
                    //{{-- ボタン有効 --}}
                    $('.upload-button').prop("disabled", false);

                    //{{-- 画面上部へ --}}
                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");
                
                });
    });





   

});

</script>
@endsection

