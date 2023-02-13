@extends('photoproject.common.layouts_management')

@section('pagehead')
@section('title', '写真アップロード画面')  
@endsection
@section('content')

<style>

body{
    overflow-y: scroll;
}

#key_code_Label{
    font-weight: 600;
    font-size: 21px;
}

#key_code{
    width: 140px;
    border: none;
    border-bottom: 2px solid #999;
    font-size: 20px;
}

.PhotoArea{       
    padding: 3px;
}

#UploadArea{        
    margin-top: 1vh;
    margin-bottom: 1vh;
}

#UploadedPhotoDisplayArea{
        
    margin: 1vw;
    border: 1mm ridge rgba(211, 220, 50, .6);

}

.UploadButtonArea{
    margin-top: 1vh;
    margin-bottom: 1vh;
}

.Photo{       
    width: 100%;
}

#DropZone{        
    padding: 20px;
    border: 1px solid; 
}

</style>

@include('photoproject.common.processing_display')

<div id='main' class="mt-3 text-center container inoperable">     
    {{-- <div id='main' class="mt-3 text-center container"> --}}
        
        <div id='' class="row">

            <div class="ajax-msg"></div>

            <form action="{{ route('photoproject.photo_upload_execution') }}" id='UploadForm'method="post" enctype="multipart/form-data">
                @csrf


                <div class="row">    
                    <div class="col-12 text-start">
                        <label id="key_code_Label"for="" class="">key_code:</label>
                        <input type="tel" id="key_code" name="key_code" value="@if($key_code != ''){{$key_code}}@endif" class="text-end" readonly>
                    </div>
                </div>       

                <div class="row">   
                
                    <div id="UploadArea">
                                    
                    
                                
                        <div id="DropZone">               
                            @if($termina_info['pc_flg'] == 1)   
                                <p>ファイルをドラッグ＆ドロップもしくはファイル選択してください。</p>
                                <p>※複数アップロードする場合は一度に選択してください。</p>      
                            @else

                                <p>※複数アップロードする場合は<br>一度に選択してください。</p>
                            @endif
                                   
                            <input type="file" id='file_input'name="file[]" lang="ja" accept="" multiple>
                        </div>

                        <div class="UploadButtonArea d-none">
                            <div align="left">                        
                                <button type="button" class="ResetButton btn btn-secondary">リセット <i class="fas fa-minus-square"></i></button>
                                <button type="button" class="UploadButton btn btn-secondary">アップロード <i class="fas fa-cloud-upload-alt"></i></button>
                            </div>
                        </div>

                                

                        {{-- 画像を追加したらここにプレビュー画像が追加される↓ --}}
                        <div id="PreviewArea" class="row">
                        </div>
                            
                        <div class="UploadButtonArea d-none">
                            <div align="right">                        
                                <button type="button" class="ResetButton btn btn-secondary">リセット <i class="fas fa-minus-square"></i></button>
                                <button type="button" class="UploadButton btn btn-secondary">アップロード <i class="fas fa-cloud-upload-alt"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>


            
                @if(count($UploadFileInfo) > 0)                

                
                    <div class="col-12 text-end">
                        <button type="button" id="UploadedPhotoDisplayButton" class="btn btn-secondary UploadedPhotoDisplayChangeButton" data-mode="1">表示【{{count($UploadFileInfo)}}】 <i class="far fa-eye"></i></button>
                        <button type="button" id="UploadedPhotoDisplayNonButton" class="btn btn-secondary UploadedPhotoDisplayChangeButton d-none" data-mode="2">非表示 <i class="far fa-eye-slash"></i></button>
                    </div>   
                    
                    
                    <div class="col-12">
                        <div id="UploadedPhotoDisplayArea" class="row d-none">    

                            

                            <h4>既にアップロードされている写真</h4>
                            
                            @foreach ($UploadFileInfo as $Info)                                        
                                <div class="col-6 col-md-4 col-xl-3 p-3 PhotoArea">   
                                    {{$Info["FileName"]}}                                
                                    <img src="{{$Info["PublicPath"]}}" class="Photo" alt="">                    
                                </div>    
                            @endforeach

                        </div>
                    </div>
                

                
                    
                @else  
                
                    <h2>まだ画像がアップロードされておりません。</h2>    
            
                @endif

            

        </div>
        
    </div>

@endsection

@section('pagejs')

<script type="text/javascript">

    window.addEventListener('load', function(){
        LoaderEnd();
    });

$(function(){

    // 「アップロード済み表示」ボタンがクリックされたら
    $('.UploadedPhotoDisplayChangeButton').click(function () {

        var mode = $(this).data('mode');      

        $("#UploadedPhotoDisplayArea").removeClass('d-none');
        $(".UploadedPhotoDisplayChangeButton").removeClass('d-none');        

        if(mode == 1){            
            $("#UploadedPhotoDisplayButton").addClass('d-none');
            $("#UploadedPhotoDisplayArea").removeClass('d-none');
            
        }else{            
            $("#UploadedPhotoDisplayNonButton").addClass('d-none');
            $("#UploadedPhotoDisplayArea").addClass('d-none');
            
        }

    });


    // 画像アップロード処理
    var DropZone = document.getElementById('DropZone');    
    var PreviewArea = document.getElementById('PreviewArea');
    var fileInput = document.getElementById('file_input');

    //FormDataオブジェクトを作成
    var formData = new FormData();

   

    DropZone.addEventListener('dragover', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#e1e7f0';
    }, false);

    DropZone.addEventListener('dragleave', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffffff';
    }, false);

    DropZone.addEventListener('drop', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffffff'; //背景色を白に戻す
        var files = e.dataTransfer.files; //ドロップしたファイルを取得
        fileInput.files = files; //inputのvalueをドラッグしたファイルに置き換える。
    }, false);

	fileInput.addEventListener('change', function () {

		// プレビュー内で表示している画像を一旦クリア
		$("#PreviewArea").empty();

		// 選択したファイルの全情報取得
		let element = document.getElementById('file_input');

		// 選択したファイルをファイル名で格納
		let files = element.files;

		// 取得したファイル数分、画像をプレビューさせるメソッドを繰り返し呼び出し
		for (var i = 0; i < files.length; i++) {

			PreviewFile(this.files[i],i);
            $('.UploadButtonArea').removeClass('d-none');
		}

    });    

	

	//ファイルがドロップされたときに呼ばれる
	$('#DropZone').on('drop', function(ev) {

		// プレビュー内で表示している画像を一旦全削除
		$("#PreviewArea").empty();

		var files = ev.originalEvent.dataTransfer.files;

		for (var i = 0; i < files.length; i++) {
			//FormDataオブジェクトにファイルを追加
			//名前は'document_files[]'
			formData.append('document_files[]', files[i]);

			PreviewFile(files[i],i);
          
            $('.UploadButtonArea').removeClass('d-none');
		}
        
	});


    function PreviewFile(file,i) {

        // プレビュー画像を追加する要素
        const PreviewArea = document.getElementById('PreviewArea');

        // FileReaderオブジェクトを作成
        const reader = new FileReader();

        // URLとして読み込まれたときに実行する処理
        reader.onload = function (e) {

            // URLはevent.target.resultで呼び出せる
            const imageUrl = e.target.result;

            // img要素を作成
            // ("embed")...jpeg,img,pingは通常表示、PDFファイルはスクロールバー付きで表示
            const img = document.createElement("embed");
            img.setAttribute('class', 'Photo');

            var PreviewPhotoAreaID = "PreviewPhotoArea" + i;

            var Element ="<div id='"+ PreviewPhotoAreaID + "' class='col-6 col-md-4 col-xl-3 p-3 PhotoArea'></div>";           

            
            $('#PreviewArea').append(Element);

            // URLをimg要素にセット
            img.src = imageUrl;

            const PreviewPhotoArea = document.getElementById(PreviewPhotoAreaID);

            // #Previewの中に追加
            PreviewPhotoArea.appendChild(img);
           
        }

        // ファイルをURLとして読み込む
        reader.readAsDataURL(file);
    }


    // リセットボタン押下イベント
	$('.ResetButton').on('click', function() {
		//{{-- メッセージクリア --}}
		$('.ajax-msg').html('');	

        // プレビュー内で表示している画像を一旦全削除
        $("#PreviewArea").empty();
		$('.UploadButtonArea').addClass('d-none');
		$('.ResetButton').blur();
        
        
        document.getElementById('file_input').value = '';
        
    });

    const selectedFiles = [];
    $('#file_input').on('change', function(event) {
        selectedFiles.push(event.target.files)
    })


    // UploadButton押下時
    $('.UploadButton').on("click", function () {

       
        phpProcessingStart();

        UploaderStart();

        let f = $('#UploadForm');

        var formData = new FormData($('#UploadForm').get(0));

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

                // //マウスカーソルを通常に
                // document.body.style.cursor = 'auto';
                // //{{-- ボタン有効 --}}
                // $(this).prop("disabled", false);

             

                var ResultArray = data.ResultArray;

                var Result = ResultArray["Result"];


                if(Result == 'success'){

                    location.reload();                                    

                }else{

                    phpProcessingEnd();

                    UploaderEnd();

                    massage = "アップロード処理でエラーが発生しました。";
                    var errorsHtml = '<div class="alert alert-danger text-start">';
                    errorsHtml += '<li>' + massage + '</li>';                    
                    errorsHtml += '</div>';

                    //{{-- アラート --}}    
                    $('.ajax-msg').html(errorsHtml);

                    

                }
            
            })
                .fail(function (data, textStatus, errorThrown) {

                    phpProcessingEnd();

                    UploaderEnd();

                    massage = "アップロード処理でエラーが発生しました。";
                    var errorsHtml = '<div class="alert alert-danger text-start">';
                    errorsHtml += '<li>' + massage + '</li>';                    
                    errorsHtml += '</div>';

                    //{{-- アラート --}}    
                    $('.ajax-msg').html(errorsHtml);

                    //マウスカーソルを通常に
                    document.body.style.cursor = 'auto';
                    //{{-- ボタン有効 --}}
                    $('.UploadButton').prop("disabled", false);

                    //{{-- 画面上部へ --}}
                    $("html,body").animate({
                        scrollTop: 0
                    }, "300");
                
                });
    });





   

});

</script>
@endsection

