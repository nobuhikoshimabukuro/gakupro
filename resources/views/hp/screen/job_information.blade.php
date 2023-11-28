@extends('hp.common.layouts_app')

@section('pagehead')
@section('job-name', '求人情報')  
@endsection
@section('content')

<style>

    body{
        z-index: 1;
    }

/* 検索ボード */
    .search-board{    
        position:fixed;
        padding: 3px;
        z-index: 100;    
        top:0;
        right: -120%;
        width:50%;        
        height: 100%;        
        background:#eee9e9;        
        transition: all 0.6s;    
    }
       
    .search-board-footer{
        position: absolute;
        z-index: 1000;
        bottom: 0;
        left: 0;
        width: 100%;        
        padding-bottom: 1vh 0 ;
        background:#eee9e9;
    }   

    .search-alert-area{
        position: absolute;        
        top: calc(50% - 20px);;
        right: -120%;
        height: 40px;
        width: 100%;
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

    /*アクティブクラスがついたら位置を0に*/
    .search-board-active 
    ,.search-alert-area-active{
        right: 0;
    }

    .search-board-tab-table {
        width: 100%;
    }

    .search-board-tab-table th{
        width: 25%;
        margin: 0;
        padding: 1px;
    }

    .search-board-tab-button{
        font-weight: 600;        
        width: 100%;
        color: rgb(54, 49, 49);
        background-color: rgb(95, 226, 226);        
    }

    
    .search-board-tab-button:active{
        font-weight: 700;                
        color: white;
        background-color: rgb(30, 90, 90);
    }

    .search-board-tab-button:hover{
        font-weight: 700;                
        color: white;
        background-color: rgb(30, 90, 90);
    }   
    
    .after-button{
        font-weight: 700;                
        color: white;
        background-color: rgb(2, 26, 26);
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

    .job-maincategory-title-area{
        height: 50px;        
        color:rgb(4, 4, 53);
        font-size: 19px;
        font-weight: bold;

        border: 2px solid #000000;
        display: flex;
        justify-content: center; /*左右中央揃え*/
        align-items: center;     /*上下中央揃え*/
    }

    .job-maincategory-hidden-area{
        border: 2px solid #000000;
        border-top:none;
    }

    .arrow-top{
        font-size: 10px;
        display: inline-block;
        border-style: solid;
        border-width: 0 6px 12px 6px;
        border-color: transparent transparent #000 transparent;
    }


    .arrow-bottom {
        display: inline-block;
        border-style: solid;
        border-width: 12px 6px 0 6px;
        border-color: #000 transparent transparent transparent;
    }

    .job-supplement-area
    ,.job-category-area{
        height: 50px;
        padding: 3px;
    }

    .job-supplement-label
    ,.job-category-label{
        height: 100%;
        width: 100%; 
        color: rgb(53, 7, 7);       
        border-radius: 3px;     
        background-color: rgb(208, 208, 241);
        
    }
   

    
    .employment-status-area{
        height: 50px;
        padding: 3px;
    }

    .employment-status-label{
        height: 100%;
        width: 100%; 
        color:rgb(79, 79, 228);
        background-color: white;   
        font-weight: 600;
        border: 3px solid;
        border-top-color: black;
        border-right-color: red;
        border-bottom-color: blue;
        border-left-color: green;
        border-radius: 3px;             
    }

    .employment-status-select{        
        color: rgb(4, 4, 80);
        background-color: white;   
        border: 4px solid;
        border-top-color: green;
        border-right-color: black;
        border-bottom-color: red;
        border-left-color: blue;
        font-weight: 700;
        animation: arrowrotate .1s;
    }
    
    .job-supplement-select
    ,.job-category-select{
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




.inoperable {
	pointer-events: none;	
	opacity: 0.7;  
}

.possible {
	pointer-events: auto;
}



</style>


<div class="loader"></div> 


<div class="search-board">

        <div class="search-alert-area">
            検索項目を1つ以上選択してください。
        </div>
        
        <div class="row">

            <div class="search-board-header col-12">                       
            
                <div class="row">
            
                    <div class="col-12"> 

                        <table class="search-board-tab-table">
                            <th>
                                <button id="search-board-tab-button1" class="btn search-board-tab-button" data-target="1">
                                    勤務地<i class="fas fa-map-marker-alt"></i>
                                </button>
                            </th>

                          

                            <th>
                                <button id="search-board-tab-button2" class="btn search-board-tab-button" data-target="2">
                                    職種<i class="fas fa-sitemap"></i>
                                </button>
                            </th>

                            <th>
                                <button id="search-board-tab-button3" class="btn search-board-tab-button" data-target="3">
                                    雇用条件<i class="fas fa-american-sign-language-interpreting"></i>
                                </button>
                            </th>
                            
                            
                            <th>
                                <button id="search-board-tab-button4" class="btn search-board-tab-button" data-target="4">
                                    その他の条件<i class="far fa-check-square"></i>
                                </button>
                            </th>

                        </table>

                    </div>
                    
                </div>

            </div>

        </div>

        <div class="search-board-contents-area row">

            <div class="search-board-contents contents-1 col-12">
                {{-- 勤務地検索タブ --}}
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

                {{-- 職種検索タブ --}}
                <div class="row m-0 p-0 item-center">

                    <div class="col-11">

                        <div class="row m-0 p-0">

                            @php
                                $job_maincategory_cd_array = [];
                                $start_index_array = [];
                                $end_index_array = [];
                                $check_job_maincategory_name = "";                                

                                foreach($job_category_data as $job_category_index => $job_category_info){

                                    $job_maincategory_cd = $job_category_info->job_maincategory_cd;
                                    $job_maincategory_name = $job_category_info->job_maincategory_name;
                                    $job_subcategory_cd = $job_category_info->job_subcategory_cd;

                                    if(in_array($job_subcategory_cd , $search_element_array['search_job_category_array'])){
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
                                    if(in_array($job_subcategory_cd , $search_element_array['search_job_category_array'])){
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
                                    id="job-maincategory-title-area{{$job_maincategory_cd}}"
                                    class="col-12 job-maincategory-title-area mt-2"
                                    data-target="{{$job_maincategory_cd}}"
                                    >{{$job_maincategory_name}}
                                    <span class="arrow-area arrow-bottom"></span>                                    
                                    </div>
                                    

                                    <div id="job-maincategory-hidden-area{{$job_maincategory_cd}}" 
                                    class="col-12 job-maincategory-hidden-area {{$d_none_class}}"
                                    data-target="{{$job_maincategory_cd}}">

                                        <div class="row m-0 p-0">

                                @endif

                                <div id="job-subcategory-area{{$job_subcategory_cd}}" 
                                class="col-6 col-lg-4 col-xl-3 mt-1 mb-1 job-category-area">
                                    <label id="job-category-label{{$job_subcategory_cd}}" 
                                        for="job-category-checkbox{{$job_subcategory_cd}}" 
                                        class="job-category-label item-center {{$add_class}}"                                        
                                    >{{$job_subcategory_name}}
                                    </label>

                                    <input type="checkbox" 
                                    id="job-category-checkbox{{$job_subcategory_cd}}"
                                    value="{{$job_subcategory_cd}}"                        
                                    data-jobmaincategorycd="{{$job_maincategory_cd}}"
                                    data-target="{{$job_subcategory_cd}}"
                                    class="job-category-checkbox d-none"   
                                    {{$check_status}}                              
                                    >
                                </div>


                               @if(in_array($job_category_index, $end_index_array))                                    
                                        </div>                            
                                    </div>                                                                        
                                @endif

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

            <div class="search-board-contents contents-3 col-12 d-none">


                <div class="row m-0 p-0 item-center">

                    <div class="col-11">

                        <div class="w-100 item-center mt-3">

                            <div class="search-salary-maincategory-area">
                                
                                <select id='search_salary_maincategory_cd' name='search_salary_maincategory_cd' class='input-sm'>
                                    <option value=''>---</option>
                                        @foreach ($salary_maincategory_list as $salary_maincategory_index => $salary_maincategory_info)
                                            <option value="{{$salary_maincategory_info->salary_maincategory_cd}}"       
                                            @if($search_element_array['search_salary_maincategory_cd'] == $salary_maincategory_info->salary_maincategory_cd)  
                                            selected
                                            @endif                                                                                      
                                            >
                                            {{$salary_maincategory_info->salary_maincategory_name}}
                                            </option>
                                        @endforeach
                                </select>

                               

                            </div>

                            <div class="search-salary-subcategory-area">

                                <select id='search_salary_subcategory_cd' name='search_salary_subcategory_cd' class='input-sm'>
                                    <option value=''>給与形態を選択してください。</option>
                                </select>

                            </div>

                       
                            

                        </div>                
                        
                        <div class="row m-0 p-0">


                            <div class="col-12 employment-status-title-area mt-2">
                                雇用形態
                            </div>

                            @foreach($employment_status_data as $employment_status_info)

                                @php                            
                                    
                                    $employment_status_id = $employment_status_info->employment_status_id;
                                    $employment_status_name = $employment_status_info->employment_status_name;

                                    $add_class = "";
                                    $check_status = "";
                                    
                                    if(in_array($employment_status_id , $search_element_array['search_employment_status_array'])){
                                        $add_class = "employment-status-select";                            
                                        $check_status = "checked";
                                    }

                                @endphp


                                <div id="employment-status-area{{$employment_status_id}}" 
                                    class="col-6 col-lg-4 col-xl-3 mt-2 employment-status-area">
                                    <label id="employment-status-label{{$employment_status_id}}" 
                                        for="employment-status-checkbox{{$employment_status_id}}" 
                                        class="employment-status-label {{$add_class}} item-center"
                                    >
                                    <input type="checkbox" 
                                    id="employment-status-checkbox{{$employment_status_id}}"
                                    name="employment-status-checkbox{{$employment_status_id}}"
                                    value="{{$employment_status_id}}"                        
                                    data-target="{{$employment_status_id}}"
                                    class="employment-status-checkbox"                                    
                                    {{$check_status}}
                                    >
                                    {{$employment_status_name}}
                                    </label>

                                   
                                </div>


                            @endforeach


                        </div>

                    </div>

                </div>                

            </div>


            <div class="search-board-contents contents-4 col-12 d-none">

                {{-- 求人補足検索タブ --}}
                <div class="row m-0 p-0 item-center">

                    <div class="col-11">

                        <div class="row m-0 p-0">

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
                                    if(in_array($job_supplement_subcategory_cd , $search_element_array['search_job_supplement_array'])){
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


        <div class="search-board-footer">

            <div class="row p-1">               
                
                <div class="col-4">            
                    <button type="button" class="w-100 btn btn-secondary search-board-close-button"></button>
                </div>

                <div class="col-4">            
                    <button type="button" class="w-100 btn btn-dark search-value-clear-button"></button>
                </div>

                <div class="col-4">            
                    <button type="button" class="w-100 btn btn-success search-button"></button>
                </div>
            </div>

        </div>
   

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
                            
                            $job_images_path_array = $info->job_images_path_array;
                            
                            $job_image_path_array = $job_images_path_array["job_image_path_array"];                            
                            $asset_path = $job_images_path_array["no_image_asset_path"];
                            $image_name = "no_image";

                            foreach ($job_image_path_array as $job_images_path_index => $job_image_path_info){

                                if($job_image_path_info["asset_path"] != ""){

                                    $asset_path = $job_image_path_info["asset_path"];
                                    $image_name = $job_image_path_info["image_name"]; 
                                    break;
                                }                                
                            }                            
                        @endphp
                        <div id="" class="col-12 col-md-5 m-0 p-0 job-image-outer-area item-center">   

                            <div class="job-image-inner-area item-center">
                                <img src="{{$asset_path}}" class="job-image" alt="{{$image_name}}">                                
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
      
    //画面読込時処理
    $(document).ready(function() {
        search_prefectural(1);        
        search_board_tab_change(1);
        var search_salary_subcategory_cd = "{{ $search_element_array['search_salary_subcategory_cd'] }}";
        search_salary_sabcategory(search_salary_subcategory_cd);
        
    });
    

    //検索ボードオープンボタン
    $(document).on("click", ".search-board-open-button", function (e) {
        $(".search-board").addClass('search-board-active');
    });


    //検索ボードタブボタン
    $(document).on("click", ".search-board-tab-button", function (e) {

        var target = $(this).data('target');

        search_board_tab_change(target);

    });

    //検索ボードタブ変更時
    function search_board_tab_change(target){

        $(".after-button").removeClass('after-button');
        $("#search-board-tab-button" + target).addClass('after-button');


        $(".search-board-contents").removeClass('d-none');

        $(".search-board-contents").addClass('d-none');

        $(".search-board-contents-area .contents-" + target).removeClass('d-none');

    }

    //検索ボードアラートクリック時
    $(document).on("click", ".search-alert-area", function (e) {
        $(".search-alert-area").removeClass('search-alert-area-active');
    });

    //検索ボタン
    $(document).on("click", ".search-button", function (e) {


        // ２重送信防止
        // 登録を押したらdisabled, 3秒後にenable
        $(".search-button").prop("disabled", true);

        setTimeout(function () {
            $('.search-button').prop("disabled", false);
        }, 2000);

        var url = "{{ route('hp.job_information_set_search_value') }}";

        var prefectural_cd_search_value_array = set_prefectural_cd_search_value();        
        var municipality_cd_search_value_array = set_municipality_cd_array_search_value();

        var salary_maincategory_cd_search_value_array = set_salary_maincategory_cd_search_value();
        var salary_subcategory_cd_search_value_array = set_salary_subcategory_cd_search_value();

        var employment_status_search_value_array = set_employment_status_search_value();              

        var job_category_search_value_array = set_job_category_search_value();
        var job_supplement_search_value_array = set_job_supplement_search_value();

        var all_job_search_value_array = {
            prefectural_cd_search_value_array:prefectural_cd_search_value_array
            , municipality_cd_search_value_array:municipality_cd_search_value_array
            , employment_status_search_value_array:employment_status_search_value_array
            , salary_maincategory_cd_search_value_array:salary_maincategory_cd_search_value_array
            , salary_subcategory_cd_search_value_array:salary_subcategory_cd_search_value_array            
            , job_category_search_value_array:job_category_search_value_array
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


    //検索ボードクローズボタン
    $(document).on("click", ".search-board-close-button", function (e) {
        $(".search-board").removeClass('search-board-active');
    });

    //検索ボードクリアボタン
    $(document).on("click", ".search-value-clear-button", function (e) {
        
        // 各クリア処理
        clear_prefectural();
        clear_salary_category();
        clear_employment_status();
        clear_job_category();
        clear_job_supplement_category();
       
        search_board_tab_change(1);
        $(".search-alert-area").removeClass('search-alert-area-active');

    });

    //勤務地クリア処理
    function clear_prefectural(){
        $("#search_prefectural_cd").val("");
        search_prefectural();
    }

    //給与クリア処理
    function clear_salary_category(){

     

    }

    //求人補足クリア処理
    function clear_employment_status(){    

        $(".employment-status-checkbox").prop("checked", false);
        $(".employment-status-select").removeClass('employment-status-select');

    }

    //職種クリア処理
    function clear_job_category(){
        
        $(".job-maincategory-title-area .arrow-area").removeClass('arrow-top');
        $(".job-maincategory-title-area .arrow-area").removeClass('arrow-bottom');
        $(".job-maincategory-title-area .arrow-area").addClass('arrow-bottom');   

        $(".job-maincategory-hidden-area").removeClass('d-none');
        $(".job-maincategory-hidden-area").addClass('d-none');

        $(".job-category-checkbox").prop("checked", false);
        $(".job-category-select").removeClass('job-category-select');

    }

    //求人補足クリア処理
    function clear_job_supplement_category(){
     

        $(".job-supplement-checkbox").prop("checked", false);
        $(".job-supplement-select").removeClass('job-supplement-select');

    }

    
// {{-- 勤務地タブ関連Start --}}

    //都道府県プルダウン変更時
    $(document).on("change", "#search_prefectural_cd", function (e) {

        search_prefectural();

    });


    //都道府県毎、市区町村検索処理
    function search_prefectural(process_branch = 0){

        var prefectural_cd = $("#search_prefectural_cd").val();        

        var municipality_name = "";        
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

// {{-- 勤務地タブ関連End --}}


// {{-- 職種タブ関連Start --}}

    //職種大分類エリアクリック時
    $(document).on("click", ".job-maincategory-title-area", function (e) {        

        var close_judge = true;

        var target = $(this).data('target');

        var target_id1 = "#job-maincategory-title-area" + target + " .arrow-area";
		var target_id2 = "#job-maincategory-hidden-area" + target;
        
			
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

        $(target_id1).removeClass('arrow-top');
        $(target_id1).removeClass('arrow-bottom');


        if($(target_id2).hasClass('d-none')) {      

            $(target_id2).removeClass('d-none');
            $(target_id1).addClass('arrow-top');
            

        }else{

            if(close_judge){
                $(target_id2).addClass('d-none');
                $(target_id1).addClass('arrow-bottom');    
            }else{
                $(target_id1).addClass('arrow-top');
            }
            
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

// {{-- 職種タブ関連End --}}

// {{-- 雇用条件タブ関連Start --}}

    //給与プルダウン変更時
    $(document).on("change", "#search_salary_maincategory_cd", function (e) {

        search_salary_sabcategory();

    });

    //給与検索＆プルダウン作成    
    function search_salary_sabcategory(get_search_salary_subcategory_cd = 0){

        var salary_maincategory_cd = $("#search_salary_maincategory_cd").val();

        var url = "{{ route('create_list.salary_sabcategory_list_ajax') }}";

        var target_area = "#search_salary_subcategory_cd";

        $(target_area).removeClass('inoperable');        

        //プルダウン内の設定初期化
        $("select" + target_area + " option").remove();        

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';

        $.ajax({
            url: url, // 送信先
            type: 'get',
            dataType: 'json',
            data: {salary_maincategory_cd : salary_maincategory_cd},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        })
        .done(function (data, textStatus, jqXHR) {

            // テーブルに通信できた場合
            var salary_sabcategory_list = data.salary_sabcategory_list;            

            //テーブルに通信時、データを検索できたか判定
            if (salary_sabcategory_list.length > 0) {                

                
                $.each(salary_sabcategory_list, function(index, salary_sabcategory_info) {

                    var salary_maincategory_cd = salary_sabcategory_info["salary_maincategory_cd"];
                    var salary_subcategory_cd = salary_sabcategory_info["salary_subcategory_cd"];                    
                    var salary = salary_sabcategory_info["salary"];
                    var salary_display = salary_sabcategory_info["salary_display"];
            
                     // 新しいoption要素を作成
                    var option = $("<option>").val(salary_subcategory_cd).text(salary_display);

                    // 特定の条件でselected属性を追加
                    if (salary_subcategory_cd == get_search_salary_subcategory_cd) {
                        option.attr("selected", "selected");
                    }

                    // option要素をselect要素に追加
                    $(target_area).append(option);

                })

                
                

            }else{               

                $(target_area).append($("<option>").val("").text("給与形態を選択してください。"));

                    $(target_area).addClass('inoperable');

            }

            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';

        })
        .fail(function (data, textStatus, errorThrown) {
                
            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';
            $(target_area).append($("<option>").val("").text("給与形態を選択してください。"));
            $(target_area).addClass('inoperable');
        });

    }

    //雇用形態選択値変更時
    $(document).on("change", ".employment-status-checkbox", function (e) {

        var employment_status_id = $(this).data('target');

        $("#employment-status-label" + employment_status_id).removeClass('employment-status-select');

        if($("#employment-status-checkbox" + employment_status_id).prop('checked')){

            $("#employment-status-label" + employment_status_id).addClass('employment-status-select');
            
        }        

    });


// {{-- 雇用条件タブ関連End --}}



// {{-- 求人補足タブ関連Start --}}

    //求人補足選択値変更時
    $(document).on("change", ".job-supplement-checkbox", function (e) {

        var job_supplement_subcategory_cd = $(this).data('target');

        $("#job-supplement-label" + job_supplement_subcategory_cd).removeClass('job-supplement-select');

        if($("#job-supplement-checkbox" + job_supplement_subcategory_cd).prop('checked')){

            $("#job-supplement-label" + job_supplement_subcategory_cd).addClass('job-supplement-select');
            
        }        

    });

// {{-- 求人補足タブ関連End --}}
    
    

// {{-- 検索前の各値セット処理Start --}}
    

    //勤務地（都道府県）検索値セット処理
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

    //勤務地（市区町村）検索値セット処理
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

    //給与大分類検索値セット処理
    function set_salary_maincategory_cd_search_value(){

        var existence_data = 0;

        var salary_maincategory_cd = $("#search_salary_maincategory_cd").val();

        var salary_maincategory_cd_search_value_array = [];

        if(salary_maincategory_cd != ""){
            existence_data = 1;        
        }

        salary_maincategory_cd_search_value_array = {existence_data:existence_data
                                    , salary_maincategory_cd:salary_maincategory_cd                                         
                                    };
                                    
        return salary_maincategory_cd_search_value_array;

    }

    //給与中分類検索値セット処理
    function set_salary_subcategory_cd_search_value(){

        var existence_data = 0;

        var salary_subcategory_cd = $("#search_salary_subcategory_cd").val();

        var salary_subcategory_cd_search_value_array = [];

        if(salary_subcategory_cd != ""){
            existence_data = 1;        
        }

        salary_subcategory_cd_search_value_array = {existence_data:existence_data
                                    , salary_subcategory_cd:salary_subcategory_cd                                         
                                    };
                                    
        return salary_subcategory_cd_search_value_array;

    }

    //雇用形態検索値セット処理
    function set_employment_status_search_value(){

        var existence_data = 0;
        var employment_status_search_value_array = [];       
        var value_array = [];

        var employment_status_checkboxs = document.querySelectorAll('.employment-status-checkbox');

        if(employment_status_checkboxs.length > 0){
                
            // チェックされている要素のvalueを取得
            employment_status_checkboxs.forEach(function(employment_status_checkbox) {
                if (employment_status_checkbox.checked) {                    
                    value_array.push(employment_status_checkbox.value); 
                }
            });
        }

        if(value_array.length > 0){
            existence_data = 1;
        }

        employment_status_search_value_array = {existence_data:existence_data
                                        , value_array:value_array                                         
                                        };

        return employment_status_search_value_array;

    }

    //職種検索値セット処理
    function set_job_category_search_value(){

        var existence_data = 0;
        var job_category_search_value_array = [];       
        var value_array = [];

        var job_category_checkboxs = document.querySelectorAll('.job-category-checkbox');

        if(job_category_checkboxs.length > 0){
                
            // チェックされている要素のvalueを取得
            job_category_checkboxs.forEach(function(job_category_checkbox) {
                if (job_category_checkbox.checked) {                    
                    value_array.push(job_category_checkbox.value); 
                }
            });
        }

        if(value_array.length > 0){
            existence_data = 1;
        }

        job_category_search_value_array = {existence_data:existence_data
                                        , value_array:value_array                                         
                                        };

        return job_category_search_value_array;

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

   


// {{-- 検索前の各値セット処理End --}}


    
   


    

    



    //求人明細ボードクリック処理
    $('.job-detail').click(function () {
    
        var job_number = $(this).data('jobnumber');
        var url = '{{ route('hp.job_information_detail') }}' + "?job_number=" + job_number;
        window.open(url, '_blank');

    });

    




});

</script>
@endsection

