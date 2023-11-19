@extends('recruit_project.common.layouts_afterlogin')

@section('pagehead')
@section('title', '求人情報登録画面')  
@endsection
@section('content')

<style>

    body{
        z-index: 1;
        padding-bottom: 5vh;
    }

    .job-supplement-maincategory-area
    ,.job-maincategory-title-area
    ,.employment-status-title-area{
        height: 50px;
        background-color: rgb(245, 179, 81);
        color:rgb(239, 239, 247);
        font-size: 19px;
        font-weight: bold;
        display: flex;
        justify-content: center; /*左右中央揃え*/
        align-items: center;     /*上下中央揃え*/
    }

    .job-supplement-area
    ,.job-category-area
    ,.employment-status-area{
        height: 50px;
        padding: 3px;
    }

    .job-supplement-label
    ,.job-category-label
    ,.employment-status-label{
        height: 100%;
        width: 100%; 
        color: rgb(53, 7, 7);       
        border-radius: 3px;     
        background-color: rgb(208, 208, 241);
        
    }

    .job-supplement-select
    ,.job-category-select
    ,.employment-status-select{
        background-color: rgb(49, 49, 105);
        color: white;
        border: solid 1px rgb(208, 208, 241);
        font-weight: bold;
        animation: arrowrotate .1s;
    }

    @keyframes arrowrotate {
        100% {
            transform: rotate(6deg);
        }
    }


    .item-center{
        display: flex;
        justify-content: center; /*左右中央揃え*/
        align-items: center;     /*上下中央揃え*/
    }
    
    
.job-image-outer-area{
    width: 100%;
    overflow-x: auto;
    background-color: rgb(180, 179, 176);
    display: flex;    
    
}

.job-image-inner-area{
    border: solid red;
}

.job-image-area{
    aspect-ratio: 16 / 9;
    padding: 3px;    
}

/* アスペクト比（縦横比 */



/* PC用 */
@media (min-width:769px) {  /*画面幅が769px以上の場合とする*/
 
    .job-image-inner-area{
        width:33%;
        margin: 0 3px 0 3px;
    }

}

/* スマホ用 */
@media (max-width:768px) {  /*画面幅が768px以下の場合とする*/

    .job-image-inner-area{
        min-width:100%;
    }
}

.job-image{        
        width: 100%;    
        height:  100%;
        object-fit: contain; 
    }

</style>

<div id="main" class="mt-3 text-center container">
    
    
    
    <form id="save-form" method="post" action="{{ route('recruit_project.job_information_save') }}">
        @csrf

        <input type="hidden" name="employer_id" id="employer_id" value="{{$employer_id}}">
        <input type="hidden" name="job_id" id="job_id" value="{{$job_id}}">

        <div id="" class="row item-center">

            <button type="button" id="save-button" class="btn btn-primary" >登録TEST</button>

            <div class="col-11 col-md-11 mt-3">
        
                <div id="" class="row m-0 p-0">

                    <div class="col-12 mt-1 m-0 p-0">

                        <div id="" class="w-100 m-0 p-0">
                                        aaaaaaaaaaaaaaaaaaaaaaaaa
                        </div>

                        <div id="" class="job-image-outer-area ">                            

                            {{-- @foreach ($asset_path_array as $job_image_index => $asset_path)
                            
                                <div class="job-image-inner-area">

                                    <div class="job-image-area">
                                        <img src="{{$asset_path}}" class="job-image" alt="">                          
                                    </div>
                                    
                                    
                                    <div id="" class="w-100 m-0 p-0">
                                        <button type="button" id="" class="btn btn-primary" >test1</button>
                                        <button type="button" id="" class="btn btn-primary" >test2</button>
                                    </div>
                                        
                                </div>
                            @endforeach --}}

                            

                                
                            <div class="job-image-inner-area">

                                <div id="DropZone" class="job-image-area">
                                                              
                                </div>

                                <div id="PreviewArea" class="job-image-area">
                                                              
                                </div>
                                
                                
                                {{-- <div id="PreviewArea" class="row">

                                </div> --}}

                                <div id="" class="w-100 m-0 p-0">
                                    <button type="button" class="ResetButton btn btn-secondary">リセット <i class="fas fa-minus-square"></i></button>
                                </div>
                                    
                                <input type="file" id='file_input'name="file[]" lang="ja" accept="" multiple>
                            </div>

                            

                        </div>

                    </div>

                    <div class="col-12 col-md-6 mt-3">

                        <div id="" class="row m-0 p-0">
                            

                            <div class="col-12 employment-status-title-area mt-2">
                                雇用形態
                            </div>

                            @foreach($employment_status_data as $employment_status_info)

                                @php                            
                                    
                                    $employment_status_id = $employment_status_info->employment_status_id;
                                    $employment_status_name = $employment_status_info->employment_status_name;

                                    $add_class = "";
                                    $check_status = "";
                                    if(in_array($employment_status_id , $employment_status_connections)){
                                        $add_class = "employment-status-select";                            
                                        $check_status = "checked";
                                    }

                                @endphp


                                <div id="employment-status-area{{$employment_status_id}}" 
                                    class="col-6 col-lg-4 col-xl-3 mt-2 employment-status-area">
                                    <label id="employment-status-label{{$employment_status_id}}" 
                                        for="employment-status-checkbox{{$employment_status_id}}" 
                                        class="employment-status-label {{$add_class}} item-center"
                                    >{{$employment_status_name}}
                                    </label>

                                    <input type="checkbox" 
                                    id="employment-status-checkbox{{$employment_status_id}}"
                                    name="employment-status-checkbox{{$employment_status_id}}"
                                    value="{{$employment_status_id}}"                        
                                    data-target="{{$employment_status_id}}"
                                    class="employment-status-checkbox d-none"                                     
                                    {{$check_status}}
                                    >
                                </div>
                            @endforeach

                        </div>

                    </div> 




                    <div class="col-12 col-md-6 mt-3">

                        <div id="" class="row m-0 p-0">

                            @php
                                $job_maincategory_cd_array = [];
                                $start_index_array = [];
                                $end_index_array = [];
                                $check_job_maincategory_name = "";                                

                                foreach($job_category_data as $job_category_index => $job_category_info){

                                    $job_maincategory_cd = $job_category_info->job_maincategory_cd;
                                    $job_maincategory_name = $job_category_info->job_maincategory_name;
                                    $job_subcategory_cd = $job_category_info->job_subcategory_cd;

                                    if(in_array($job_subcategory_cd , $job_category_connections)){
                                        $job_maincategory_cd_array[] = $job_maincategory_cd;
                                    }


                                    if($check_job_maincategory_name != $job_maincategory_name){
                                        $start_index_array[] = $job_category_index;
                                        $end_index_array[] = $job_category_index - 1;

                                        $check_job_maincategory_name = $job_maincategory_name;
                                    }   

                                }

                                $end_index_array[] = count($job_category_data) - 1;

                            @endphp

                            @foreach($job_category_data as $job_category_index => $job_category_info)
                            
                                @php
                                    $job_maincategory_cd = $job_category_info->job_maincategory_cd;
                                    $job_maincategory_name = $job_category_info->job_maincategory_name;
                                    $job_subcategory_cd = $job_category_info->job_subcategory_cd;
                                    $job_subcategory_name = $job_category_info->job_subcategory_name;

                                    
                                    $add_class = "";
                                    $check_status = "";
                                    if(in_array($job_subcategory_cd , $job_category_connections)){
                                        $add_class = "job-category-select";                            
                                        $check_status = "checked";
                                    }

                                @endphp


                                @if(in_array($job_category_index, $start_index_array))

                                    @php
                                        $d_none_class = "d-none";
                                        if(in_array($job_maincategory_cd, $job_maincategory_cd_array)){
                                            $d_none_class = "";
                                        }
                                    @endphp
                                                                    
                                    <div 
                                    class="col-12 job-maincategory-title-area mt-2"
                                    data-target="{{$job_maincategory_cd}}"
                                    >{{$job_maincategory_name}}
                                    </div>

                                    <div id="job-maincategory-hidden-area{{$job_maincategory_cd}}" 
                                    class="row job-maincategory-hidden-area mt-1 {{$d_none_class}}"
                                    data-target="{{$job_maincategory_cd}}">                                   

                                @endif

                                <div id="job-subcategory-area{{$job_subcategory_cd}}" 
                                class="col-6 col-lg-4 col-xl-3 mt-2 job-category-area">
                                    <label id="job-category-label{{$job_subcategory_cd}}" 
                                        for="job-category-checkbox{{$job_subcategory_cd}}" 
                                        class="job-category-label item-center {{$add_class}}"                                        
                                    >{{$job_subcategory_name}}
                                    </label>

                                    <input type="checkbox" 
                                    id="job-category-checkbox{{$job_subcategory_cd}}"
                                    name="job-category-checkbox{{$job_subcategory_cd}}"
                                    value="{{$job_subcategory_cd}}"                        
                                    data-jobmaincategorycd="{{$job_maincategory_cd}}"
                                    data-target="{{$job_subcategory_cd}}"
                                    class="job-category-checkbox d-none"   
                                    {{$check_status}}                              
                                    >
                                </div>


                                @if(in_array($job_category_index, $end_index_array))                                    
                                    </div>                                                                        
                                @endif

                            @endforeach
                
                    
                
                        </div>   
                    </div>   
                    
                    


                    <div class="col-12 col-md-6 mt-3">

                        <div id="" class="row m-0 p-0">

                        @php
                                $check_job_supplement_maincategory_name = "";
                            @endphp

                            @foreach($job_supplement_data as $job_supplement_info)

                                @php                            
                                    
                                    $job_supplement_maincategory_cd = $job_supplement_info->job_supplement_maincategory_cd;
                                    $job_supplement_maincategory_name = $job_supplement_info->job_supplement_maincategory_name;

                                    $job_supplement_subcategory_cd = $job_supplement_info->job_supplement_subcategory_cd;
                                    $job_supplement_subcategory_name = $job_supplement_info->job_supplement_subcategory_name;

                                    $add_class = "";
                                    $check_status = "";
                                    if(in_array($job_supplement_subcategory_cd , $job_supplement_category_connections)){
                                        $add_class = "job-supplement-select";                            
                                        $check_status = "checked";
                                    }

                                @endphp

                                @if($check_job_supplement_maincategory_name != $job_supplement_maincategory_name)
                                {{-- 求人検索補足大分類変換時 --}}
                                    <div class="col-12 job-supplement-maincategory-area mt-2">
                                        {{$job_supplement_maincategory_name}}
                                    </div>                            
                                    
                                    @php
                                        $check_job_supplement_maincategory_name = $job_supplement_maincategory_name;
                                    @endphp

                                @endif

                                <div id="job-supplement-area{{$job_supplement_subcategory_cd}}" 
                                    class="col-6 col-lg-4 col-xl-3 mt-2 job-supplement-area">
                                    <label id="job-supplement-label{{$job_supplement_subcategory_cd}}" 
                                        for="job-supplement-checkbox{{$job_supplement_subcategory_cd}}" 
                                        class="job-supplement-label {{$add_class}} item-center"
                                    >{{$job_supplement_subcategory_name}}
                                    </label>

                                    <input type="checkbox" 
                                    id="job-supplement-checkbox{{$job_supplement_subcategory_cd}}"
                                    name="job-supplement-checkbox{{$job_supplement_subcategory_cd}}"
                                    value="{{$job_supplement_subcategory_cd}}"                        
                                    data-target="{{$job_supplement_subcategory_cd}}"
                                    class="job-supplement-checkbox d-none"                                     
                                    {{$check_status}}
                                    >
                                </div>

                            @endforeach
                
                    
                
                        </div> 
                    </div> 












                

            
                </div>              
                

            </div>

        </div>

    </form>
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){


    
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
            $('.upload_button_area').removeClass('d-none');
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
          
            $('.upload_button_area').removeClass('d-none');
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
            img.setAttribute('class', 'job-image');

            var PreviewPhotoAreaID = "PreviewPhotoArea" + i;

            // var Element ="<div id='"+ PreviewPhotoAreaID + "' class='col-6 col-md-4 col-xl-3 p-3 PhotoArea'></div>";           
            var Element ="<div id='"+ PreviewPhotoAreaID + "' class='PhotoArea'></div>";   

            
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
		$('.upload_button_area').addClass('d-none');
		$('.ResetButton').blur();
        
        
        document.getElementById('file_input').value = '';
        
    });

    const selectedFiles = [];
    $('#file_input').on('change', function(event) {
        selectedFiles.push(event.target.files)
    })


    //職種大分類エリアクリック時
    $(document).on("click", ".job-maincategory-title-area", function (e) {        

        var close_judge = true;

        var target = $(this).data('target');

        var target_id = "#job-maincategory-hidden-area" + target;
            
        var job_category_checkboxs = document.querySelectorAll('.job-category-checkbox');

        if(job_category_checkboxs.length > 0){
                
            // チェックされている要素のvalueを取得
            job_category_checkboxs.forEach(function(job_category_checkbox) {

                var job_maincategory_cd = $(job_category_checkbox).data('jobmaincategorycd');
                
                if(target == job_maincategory_cd){
                    
                    if (job_category_checkbox.checked) {                    
                        close_judge = false;
                    }
                }
            });
        }


        if($(target_id).hasClass('d-none')) {
            $(target_id).removeClass('d-none');            
        }else{

            if(close_judge){
                $(target_id).addClass('d-none');
            }
            
        }

    });

    //雇用形態選択値変更時
    $(document).on("change", ".employment-status-checkbox", function (e) {

        var employment_status_id = $(this).data('target');

        $("#employment-status-label" + employment_status_id).removeClass('employment-status-select');

        if($("#employment-status-checkbox" + employment_status_id).prop('checked')){

            $("#employment-status-label" + employment_status_id).addClass('employment-status-select');
            
        }        

    });

    //職種中分類選択値変更時
    $(document).on("change", ".job-category-checkbox", function (e) {

        var job_subcategory_cd = $(this).data('target');

        $("#job-category-label" + job_subcategory_cd).removeClass('job-category-select');

        if($("#job-category-checkbox" + job_subcategory_cd).prop('checked')){

            $("#job-category-label" + job_subcategory_cd).addClass('job-category-select');
            
        }        

    });



    //求人補足選択値変更時
    $(document).on("change", ".job-supplement-checkbox", function (e) {

        var job_supplement_subcategory_cd = $(this).data('target');

        $("#job-supplement-label" + job_supplement_subcategory_cd).removeClass('job-supplement-select');

        if($("#job-supplement-checkbox" + job_supplement_subcategory_cd).prop('checked')){

            $("#job-supplement-label" + job_supplement_subcategory_cd).addClass('job-supplement-select');
            
        }        

    });








    // 処理実行ボタンがクリックされたら
    $('#save-button').click(function () {

        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $('#save-button').prop("disabled", true);

        setTimeout(function () {
            $('#save-button').prop("disabled", false);
        }, 3000);

        
        let f = $('#save-form');

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
                $('#save-button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}
                document.body.style.cursor = 'auto';


                var result_array = data.result_array;

                var Result = result_array["Result"];

                if(Result=='success'){

                    location.reload();

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
                $('#save-button').prop("disabled", false);
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

