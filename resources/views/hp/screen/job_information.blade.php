@extends('hp.common.layouts_app')

@section('pagehead')
@section('job-name', '求人情報')  
@endsection
@section('content')

<style>
body{
    z-index: 1;
}

    .search-board{    
        position:fixed;
        padding: 3px;
        z-index: 100;    
        top:0;
        right: -120%;
        width:50%;
        /* height: 100vh; */
        height: calc(100% - 5px); /* セーフエリアに対応 */
        background:#eee9e9;
        /*動き*/
        transition: all 0.6s;    
    }

   
    .search-board-footer{
        position: absolute;
        z-index: 99999;
        bottom: 0;
        left: 0;
        width: 100%;        
        padding-bottom: 1vh;
    }   

    .search-alert-area{
        position: absolute;
        top: 50%;
        right: -120%;
        height: 40px;        
        width: 100%;
        background-color: rgb(221, 20, 20);
        font-size: 20px;
        font-weight: bold;
        color: white;
        display: flex;
        justify-content: center; /*左右中央揃え*/
        align-items: center;     /*上下中央揃え*/
        opacity: 0.8;
        z-index: 102;
        transition: all 0.6s;
    }
    /*アクティブクラスがついたら位置を0に*/
    .search-board-active , .search-alert-area-active{
        right: 0;
    }

    .search-board-tab-table {
        width: 100%;
    }

    .search-board-tab-table th{
        width: 25%;
        margin: 0;
        padding: 1px;;

    }

    .search-board-tab-button{
        font-weight: 600;        
        width: 100%;
        color: rgb(54, 49, 49);
        background-color: rgb(95, 226, 226);
    }

    .search-board-tab-button:hover{
        font-weight: 700;                
        color: white;
        background-color: rgb(30, 90, 90);
    }
    .search-board-tab-button:active{
        font-weight: 700;                
        color: white;
        background-color: rgb(30, 90, 90);
    }
    
   
    
    .after-button{
        font-weight: 700;                
        color: white;
        background-color: rgb(1, 3, 3);
    }

    .search-board-contents-area{
        height: calc(95% - 5vh);                  
        padding-bottom: 5vh;
        overflow-y: auto;
        z-index: 101;
    }
    
  
    .municipality-check-area{
        padding: 0 0 15px 15px;
    }

    .job-supplement-maincategory-area{
        height: 50px;
        background-color: rgb(245, 179, 81);
        color:rgb(239, 239, 247);
        font-size: 19px;
        font-weight: bold;
        display: flex;
        justify-content: center; /*左右中央揃え*/
        align-items: center;     /*上下中央揃え*/
    }

    .job-supplement-area{
        height: 50px;
        padding: 3px;
    }

    .job-supplement-label{
        height: 100%;
        width: 100%; 
        color: rgb(53, 7, 7);       
        border-radius: 3px;     
        background-color: rgb(208, 208, 241);
        
    }

    .job-supplement-select{
        background-color: rgb(49, 49, 105);
        color: white;
        border: solid 1px rgb(208, 208, 241);
    }


    .item-center{
        display: flex;
        justify-content: center; /*左右中央揃え*/
        align-items: center;     /*上下中央揃え*/
    }
    
    .job-board{
        margin: 1vw;
        padding: 1vw;        
        /* background-color: rgb(235, 235, 245); */
        
        border:1px solid #e1e1e1;
        border-bottom: 1px solid #e1e1e1;
        -webkit-box-shadow: 0px 0px 3px #ababab; /* Safari, Chrome用 */
        -moz-box-shadow: 0px 0px 3px #ababab; /* Firefox用 */
        box-shadow: 0px 0px 3px #ababab; /* CSS3 */
        border-radius:10px;
    }

    .job-board-inner-area{
        height: 100%;
    }

    .job-name{                
        font-size: 22px;
        font-weight: 650;
        color: rgb(49, 49, 105);
        text-align: left;
    }

    .employer-name{                
        font-size: 18px;
        font-weight: 500;
        color: rgb(49, 49, 105);
        text-align: left;
    }

    .job-image-outer-area{        
       
    }

    .job-image-inner-area{
        width: 100%;
        height: 35vh;
    }

    .job-image{        
        width: 100%;    
        height:  100%;
        object-fit: contain; 
    }

    .job-info-area{        
        height: 90%;        
    }
      
    th{   
        text-align-last: justify;
        text-justify: inter-ideograph;
        vertical-align: top; 
        text-align: right;
        white-space: nowrap;
    }

    td{        
        text-align: left;
        padding-left: 1vw;
    }




/* PC用 */
@media (min-width:769px) {  /*画面幅が769px以上の場合とする*/
   .search-board{     
        width:50%;
    }
}



/* スマホ用 */
@media (max-width:768px) {  /*画面幅が768px以下の場合とする*/

    .search-board{     
        width:100%;
    }
}



</style>




<div class="search-board">

    {{-- <div class="search-board-inner-area"> --}}

        <div class="search-alert-area">
            検索項目を1つ以上選択してください。
        </div>
        <div class="row">

            <div class="search-board-header col-12 ">            

                {{-- <div class="row p-1">
                
                    <div class="col-4">            
                        <button type="button" class="btn btn-secondary w-100 search-board-close-button">閉じる</button>
                    </div>
        
                    <div class="col-4">            
                        <button type="button" class="btn btn-primary w-100 search-value-clear-button">クリア</button>
                    </div>

                    <div class="col-4">            
                        <button type="button" class="btn btn-success w-100 search-button">検索</button>
                    </div>

                </div> --}}
        
            
            
                <div class="row p-1">
            
                    <div class="col-12"> 

                        <table class="search-board-tab-table">
                            <th>
                                <button id="search-board-tab-button1" class="btn search-board-tab-button" data-target="1">
                                    勤務地<i class="fas fa-map-marker-alt"></i>
                                </button>
                            </th>

                            <th>
                                <button id="search-board-tab-button2" class="btn search-board-tab-button" data-target="2">
                                    条件
                                </button>
                            </th>

                            <th>
                                <button id="search-board-tab-button3" class="btn search-board-tab-button" data-target="3">
                                    タブ3
                                </button>
                            </th>

                            <th>
                                <button id="search-board-tab-button4" class="btn search-board-tab-button" data-target="4">
                                    タブ4
                                </button>
                            </th>               

                        </table>

                    </div>
                    
                </div>

            </div>

        </div>

        <div class="search-board-contents-area row">

            <div class="search-board-contents contents-1 col-12">

                <div class="row m-0 p-0 item-center">

                    <div class="col-11">

                        <div class="w-100 item-center mt-3">
                            <div class="d-block ">
                                <label for="search_prefectural_cd" class="">
                                    都道府県を選択してください
                                </label>

                                <select id='search_prefectural_cd' name='search_prefectural_cd' class='input-sm'>
                                    <option value=''>未選択</option>
                                        @foreach($prefectural_list as $prefectural_info)
                                            <option value="{{$prefectural_info->prefectural_cd}}"
                                                @if($search_element_array['search_prefectural_cd'] == $prefectural_info->prefectural_cd) selected @endif
                                                title= "{{$prefectural_info->prefectural_name_kana}}"
                                            >
                                            {{$prefectural_info->prefectural_name}}
                                            </option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="municipality-check-area row">                       
                            
                        </div>

                    </div>

                </div>            

            </div>

            <div class="search-board-contents contents-2 col-12 d-none">

                <div class="row m-0 p-0 item-center">

                    <div class="col-11">

                        <div class="row m-0 p-0">

                            @php
                                $check_job_supplement_maincategory_name = "";
                            @endphp

                            @foreach($job_supplement_list as $job_supplement_info)

                                @php                            
                                    
                                    $job_supplement_maincategory_cd = $job_supplement_info->job_supplement_maincategory_cd;
                                    $job_supplement_maincategory_name = $job_supplement_info->job_supplement_maincategory_name;

                                    $job_supplement_subcategory_cd = $job_supplement_info->job_supplement_subcategory_cd;
                                    $job_supplement_subcategory_name = $job_supplement_info->job_supplement_subcategory_name;

                                    $add_class = "";
                                    $check_status = "";
                                    if(in_array($job_supplement_subcategory_cd , $search_element_array['search_job_supplement_array'])){
                                        $add_class = "job-supplement-select";                            
                                        $check_status = "checked";
                                    }

                                @endphp

                                @if($check_job_supplement_maincategory_name != $job_supplement_maincategory_name)

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

            <div class="search-board-contents contents-3 col-12 d-none">

                タブ3

            </div>

            <div class="search-board-contents contents-4 col-12 d-none">

                タブ4            

            </div>

        </div>


        <div class="search-board-footer">

            <div class="row p-1">
                
                <div class="col-4">            
                    <button type="button" class="btn w-100 btn-secondary search-board-close-button">閉じる</button>
                </div>

                <div class="col-4">            
                    <button type="button" class="btn w-100 btn-primary search-value-clear-button">クリア</button>
                </div>

                <div class="col-4">            
                    <button type="button" class="btn w-100 btn-success search-button">検索</button>
                </div>
            </div>

        </div>

    {{-- </div> --}}

   

</div>

<div id="main" class="mt-3 text-center container">

    
    <div id="" class="row item-center">

        <div class="col-11 col-md-9 mt-3 text-end">
            <button type="button" class="btn btn-success search-board-open-button">
                求人条件検索
            </button>    
        </div>
        @if(count($job_information) > 0)

            @foreach ($job_information as $index => $info)            

                <div class="job-board col-11 col-md-9">

                    <div id="" class="row m-0 p-0 job-board-inner-area">                    
                        
                        <div id="" class="col-12 m-0 p-0 job-name">
                            {{$info->title}}
                        </div>

                        <div id="" class="col-12 m-0 p-0 employer-name">
                            {{$info->employer_name}}              
                        </div>

                        {{-- PCは二分割、モバイルは縦に分割 --}}
                        {{-- 写真エリア --}}
                        @php
                            $asset_path_array = $info->asset_path_array;
                        @endphp
                        <div id="" class="col-12 col-md-5 m-0 p-0 job-image-outer-area item-center">   

                            <div class="job-image-inner-area item-center">
                                @foreach ($asset_path_array as $job_image_index => $asset_full_path)
                                    @if($job_image_index == 0)
                                        <img src="{{$asset_full_path}}" class="job-image" alt="">
                                    @else
                                        <img src="{{$asset_full_path}}" class="job-image d-none" alt="">
                                    @endif
                                @endforeach
                            </div>

                        </div>

                        {{-- 求人情報エリア --}}
                        <div id="" class="col-12 col-md-7 m-0 p-0 job-info-area">

                            <table class="job-info-table">
                                <tr>
                                    <th>
                                        勤務地
                                    </th>
                                    <td>
                                        {{$info->work_location}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        雇用形態
                                    </th>
                                    <td>
                                        {{$info->employment_status}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        就労時間
                                    </th>
                                    <td>
                                        {{$info->working_time}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        給与
                                    </th>
                                    <td>
                                        {{$info->salary}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        休日
                                    </th>
                                    <td>
                                        {{$info->holiday}}
                                    </td>
                                </tr>

                            </table>                    
                        </div>


                        <div id="" class="col-6 m-0 p-0 mt-3">

                            <button id="" class="w-75 m-0 p-0 job-detail btn btn-outline-success" data-jobnumber="{{$info->id}}">
                                求人明細を見る
                            </button>

                        </div>

                        

                        <div id="" class="col-6 m-0 p-0 mt-3">

                            <button id="" class="w-75 m-0 p-0 employer-detail btn btn-outline-success" data-employerid="{{$info->employer_id}}">
                                雇用者情報を見る
                            </button>

                        </div>                    

                    </div>

                </div>

            @endforeach

        @else

                


        @endif            
        
    </div>   

</div>
    





@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){
   

    
    $(document).on("change", ".job-supplement-checkbox", function (e) {

        var job_supplement_subcategory_cd = $(this).data('target');

        $("#job-supplement-label" + job_supplement_subcategory_cd).removeClass('job-supplement-select');

        if($("#job-supplement-checkbox" + job_supplement_subcategory_cd).prop('checked')){

            $("#job-supplement-label" + job_supplement_subcategory_cd).addClass('job-supplement-select');
            
        }        

    });

    
    //画面読込時処理
    $(document).ready(function() {
        search_prefectural(1);        
        search_board_tab_change(1);
        $('#confirm-close').trigger("click");
    });
    

    //検索ボードオープンボタン
    $(document).on("click", ".search-board-open-button", function (e) {
        $(".search-board").addClass('search-board-active');
    });


    //検索ボードクリアボタン
    $(document).on("click", ".search-value-clear-button", function (e) {
        // クリア処理
        $("#search_prefectural_cd").val("");
        search_prefectural();
        search_board_tab_change(1);

        
        $(".job-supplement-checkbox").prop("checked", false);
        $(".job-supplement-select").removeClass('job-supplement-select');
        $(".search-alert-area").removeClass('search-alert-area-active');
        

    });

    
    //検索ボードクローズボタン
    $(document).on("click", ".search-board-close-button", function (e) {
        $(".search-board").removeClass('search-board-active');
    });

    //検索ボードタブボタン
    $(document).on("click", ".search-board-tab-button", function (e) {

        var target = $(this).data('target');

        search_board_tab_change(target);
       
    });

    function search_board_tab_change(target){

        $(".after-button").removeClass('after-button');
        $("#search-board-tab-button" + target).addClass('after-button');


        $(".search-board-contents").removeClass('d-none');

        $(".search-board-contents").addClass('d-none');

        $(".search-board-contents-area .contents-" + target).removeClass('d-none');

    }

    //
    $(document).on("click", ".search-alert-area", function (e) {
        $(".search-alert-area").removeClass('search-alert-area-active');
    });

    //検索ボタン
    $(document).on("click", ".search-button", function (e) {
        
        
        var url = "{{ route('hp.job_information_set_search_value') }}";

        var prefectural_cd_search_value_array = set_prefectural_cd_search_value();
        var municipality_cd_search_value_array = set_municipality_cd_array_search_value();
        var job_supplement_search_value_array = set_job_supplement_search_value();

        var all_job_search_value_array = {
            prefectural_cd_search_value_array:prefectural_cd_search_value_array
            , municipality_cd_search_value_array:municipality_cd_search_value_array
            , job_supplement_search_value_array:job_supplement_search_value_array
            };
        

        var judge = false;
        Object.values(all_job_search_value_array).forEach(function(array) {
            if (array["existence_data"] == 1) {
                judge = true;
            }
        });

        if(!judge){

            $(".search-alert-area").addClass('search-alert-area-active');

            return false;
        }

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';

        $.ajax({
            url: url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {all_job_search_value_array : all_job_search_value_array},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        })
        .done(function (data, textStatus, jqXHR) {

            
            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';

            // テーブルに通信できた場合
            var result = data.result;
            
            if(result == "success"){

                location.reload();

            }else{


            }

            

        })
        .fail(function (data, textStatus, errorThrown) {
        

            
            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';
        
            

        });






    });


    //勤務地関連検索値セット処理
    function set_prefectural_cd_search_value(){

        var existence_data = 0;

        var prefectural_cd = $("#search_prefectural_cd").val();
       
        var prefectural_cd_search_value_array = [];

        if(prefectural_cd != ""){
            existence_data = 1;        
        }

        prefectural_cd_search_value_array = {existence_data:existence_data
                                    , prefectural_cd:prefectural_cd                                         
                                    };
                                    
        return prefectural_cd_search_value_array;

    }

    //勤務地関連検索値セット処理
    function set_municipality_cd_array_search_value(){

        var existence_data = 0;

        var prefectural_cd = $("#search_prefectural_cd").val();

        var municipality_cd_array = [];
        var value_array = [];        

        if(prefectural_cd != ""){            

            var municipality_cd_checkboxs = document.querySelectorAll('.municipality_cd');

            if(municipality_cd_checkboxs.length > 0){
                    
                // チェックされている要素のvalueを取得
                municipality_cd_checkboxs.forEach(function(municipality_cd_checkbox) {
                    if (municipality_cd_checkbox.checked) {                    
                        value_array.push(municipality_cd_checkbox.value); 
                    }
                });
            }

            
        }

        if(value_array.length > 0){
            existence_data = 1;
        }

        municipality_cd_array = {existence_data:existence_data , value_array:value_array };

        return municipality_cd_array;

    }


    //求人補足検索値セット処理
    function set_job_supplement_search_value(){

        var existence_data = 0;
        var job_supplement_search_value_array = [];       
        var value_array = [];
        
        var job_supplement_checkboxs = document.querySelectorAll('.job-supplement-checkbox');

        if(job_supplement_checkboxs.length > 0){
                
            // チェックされている要素のvalueを取得
            job_supplement_checkboxs.forEach(function(job_supplement_checkbox) {
                if (job_supplement_checkbox.checked) {                    
                    value_array.push(job_supplement_checkbox.value); 
                }
            });
        }

        if(value_array.length > 0){
            existence_data = 1;
        }

        job_supplement_search_value_array = {existence_data:existence_data
                                        , value_array:value_array                                         
                                        };

        return job_supplement_search_value_array;

    }





    
    //求人明細ボードクリック処理
    $('.job-detail').click(function () {
        
        var job_number = $(this).data('jobnumber');
        var url = '{{ route('hp.job_information_detail') }}' + "?job_number=" + job_number;
        window.open(url, '_blank');

    });


    //都道府県プルダウン変更時
    $(document).on("change", "#search_prefectural_cd", function (e) {

        search_prefectural();

    });

    
    //都道府県毎、市区町村検索処理
    function search_prefectural(process_branch = 0){

        var prefectural_cd = $("#search_prefectural_cd").val();        
        
        var municipality_name = "";
        var target_select = "#search_municipality_cd";
        var url = "{{ route('create_list.municipality_list_ajax') }}";


        //対象エリアの表示初期化
        $('.municipality-check-area').html("");

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';

        $.ajax({
            url: url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {prefectural_cd : prefectural_cd , municipality_name : municipality_name},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        })
        .done(function (data, textStatus, jqXHR) {
            // テーブルに通信できた場合
            var municipality_list = data.municipality_list;            

            //テーブルに通信時、データを検索できたか判定
            if (municipality_list.length > 0) {                

                var add_html = '';

                $.each(municipality_list, function(index, municipality_info) {


                    var municipality_cd = municipality_info["municipality_cd"];
                    var municipality_name = municipality_info["municipality_name"];
                    var municipality_name_kana = municipality_info["municipality_name_kana"];

              
                    add_html += '<div id="" class="col-4 mt-2 p-0">';
                    add_html += '<label for="municipality_cd_'+  municipality_cd + '" class="d-block">';
                    add_html += '<input type="checkbox" id="municipality_cd_'+  municipality_cd + '" ';
                    add_html += 'class="municipality_cd"';                
                    add_html += 'value="' + municipality_cd + '"';
                    add_html += 'name="municipality_cd_'+  municipality_cd + '"';
                    add_html += '>'+  municipality_name;
                    add_html += '</label>';                
                    add_html += '</div>';             

                })

                $('.municipality-check-area').html(add_html);

                if(process_branch == 1){
                    //画面読み込み時に市区町村チェックボックス、チェック付与処理
                    set_municipality_cd();
                }

            }else{

                


            }

            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';

        })
        .fail(function (data, textStatus, errorThrown) {
        

        
            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';

        });

    }

    //画面読み込み時に市区町村チェックボックス、チェック付与処理
    function set_municipality_cd(){

        var search_municipality_cd_array = @json($search_element_array["search_municipality_cd_array"]);

          if(search_municipality_cd_array.length > 0){

            var municipality_cd_checkboxs = document.querySelectorAll('.municipality_cd');

            if(municipality_cd_checkboxs.length > 0){
                    
                search_municipality_cd_array.forEach(function (value) {
                    var matchingCheckbox = document.querySelector('.municipality_cd[value="' + value + '"]');
                    if (matchingCheckbox) {
                        matchingCheckbox.checked = true;                        
                    }
                });

            }

        }
    }




});

</script>
@endsection

