@extends('recruit_project.common.layouts_afterlogin')

@section('pagehead')
@section('title', '求人情報登録画面')  
@endsection
@section('content')

<style>


.label-area{
    display: flex;    
    align-items: center;
}



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


textarea {
    resize: none;
}



select
{
  -moz-appearance: none;  
  -webkit-box-shadow: none;
  box-shadow: none;
  outline: none;
  border: none;

  background: #ebf4f8;  
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
,textarea
{
    background: #ebf4f8;  
    display: inline;
    font-size: 16px;
    padding: 7px;
    transition: 0.8s;
    margin: 0;
    border-radius: 6px;  
    width: 100%;
}

/*未入力*/
input[type="text"]:placeholder-shown
,input[type="tel"]:placeholder-shown
,textarea:placeholder-shown
{
    background: #243355;

}

input[type="text"]:focus
,input[type="tel"]:focus
,textarea:focus
,select:focus
{
  /* background: #e9f5fb; */
  background: #f7f7f6;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}


input::placeholder{
  color: white;
  font-size: 14px;
  opacity: 0.9;
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
    background: linear-gradient(-225deg, #eaf3f1 0%, #ececd7 56%, #ebeedf 100%);
    font-size: 20px;
    position: relative;
    text-align: left;
    padding: 2px 0 2px 5px;

    
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









.required{
    display:inline;
    background-color: red;
    color: wheat;
    font-weight: 500;
    text-align: center;
    border-radius: 7px; /* ボックスの四つ角を丸くする */
    padding: 0 3px 0 3px;
    width: 40px;;
    
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

   

    .form-table th {        
        text-align: center;
    }


}



/* スマホ用 */
@media (max-width:768px) {  /*画面幅が768px以下の場合とする*/

   

    .form-table th,
    .form-table td {
        display: block;
        width: 100%;
    }

    .form-table th {
        border-right: none;
        text-align: left;
    }

  

}











































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
        justify-content: center;
        align-items: center;     /*上下中央揃え*/
    }
    
    
.job-image-outer-area{
    width: 100%;
    overflow-x: auto;
    background-color: rgb(180, 179, 176);
    display: flex;    
    
}

.job-image-inner-area{
    border: solid red 1px;
    padding: 3px;
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
        margin:3px 0 3px 3px;
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


    .background-no-image{
        background-image: url({{$job_images_path_array["no_image_asset_path"]}});
    }


    input[type="file"] {
  opacity: 0;
  visibility: hidden;
  width: 0;
  /* position: absolute; */
}

</style>


<div id="main" class="mt-3 text-center container">    
    
    <div id="" class="row item-center">

        <div class="col-11 col-md-11 mt-3">
    
            <div id="" class="row m-0 p-0">

                <div class="col-12 text-end">
                    @if($job_id <> 0)  
                        <button type="button" id="output-pdf-button" class="btn btn-primary"
                        data-employerid="{{$employer_id}}"
                        data-jobid="{{$job_id}}"
                        >求人表</button>   
                    @endif                  

                    <button type="button" id="save-button" class="btn btn-primary" >登録</button>  
                    
                </div>
        
            </div>

        </div>

    </div>

    
    <form id="save-form" method="post" action="{{ route('recruit_project.job_information_save') }}">

        @csrf       

        <div id="" class="row item-center">          

            <div class="col-11 col-md-11 mt-3">
        
                <div id="" class="row m-0 p-0"> 
            
                    <input type="hidden" name="employer_id" id="employer_id" value="{{$employer_id}}">
                    <input type="hidden" name="job_id" id="job_id" value="{{$job_id}}">

                    <div class="col-12 mt-1 m-0 p-0">

                        <table class="form-table">

                            <tbody>
            
                                <tr class="title-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="title">タイトル</label><span class="required">必須</span>
                                    </th>
                                    <td>
            
                                        <input type="text" id="title" name="title" placeholder="" 
                                        @if(is_null($job_info))
                                            value=""
                                        @else
                                            value="{{$job_info->title}}"
                                        @endif
                                        >            
                                    </td>
            
            
                                </tr>


                                <tr class="sub_title-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="sub_title">サブタイトル</label><span class="required">必須</span>
                                    </th>
                                    <td>
            
                                        <input type="text" id="sub_title" name="sub_title" placeholder="" 
                                        @if(is_null($job_info))
                                            value=""
                                        @else
                                            value="{{$job_info->sub_title}}"
                                        @endif
                                        >            
                                    </td>           
            
                                </tr>

                                <tr class="work_location_prefectural_cd-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="work_location_prefectural_cd">勤務地</label>
                                        <span class="required">必須</span>
                                    </th>
                                    <td>
            
                                        
                                        @php
                                            $work_location_prefectural_cd = "";

                                            if(!is_null($job_info)){
                                                $work_location_prefectural_cd = $job_info->work_location_prefectural_cd;
                                            }
                                        @endphp
                             

                                        <select id='work_location_prefectural_cd' name='work_location_prefectural_cd' class='input-sm'>
                                            <option value=''>未選択</option>
                                                @foreach($prefectural_list as $prefectural_info)
                                                    <option value="{{$prefectural_info->prefectural_cd}}"                                                    
                                                    @if($work_location_prefectural_cd == $prefectural_info->prefectural_cd)                                                        
                                                        selected                                                                                                                
                                                    @endif
                                                    title= "{{$prefectural_info->prefectural_name_kana}}"
                                                    >
                                                    {{$prefectural_info->prefectural_name}}
                                                    </option>
                                                @endforeach
                                        </select>                                                                                
            
                                    </td>           
            
                                </tr>


                                <tr class="working_time-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="working_time">就労時間</label>
                                        <span class="required">必須</span>
                                    </th>
                                    <td>
            
                                        <textarea id="working_time" name="working_time" placeholder="" rows="5"
                                        >@if(!is_null($job_info)){{$job_info->working_time}}@endif</textarea>            
                                    </td>           
            
                                </tr>
            
                                <tr class="salary-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="salary">給与</label>
                                        <span class="required">必須</span>
                                    </th>
                                    <td>
            
                                        <textarea id="salary" name="salary" placeholder="" rows="5"
                                        >@if(!is_null($job_info)){{$job_info->salary}}@endif</textarea>            
                                    </td>           
            
                                </tr>

                                <tr class="holiday-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="holiday">休日</label>
                                        <span class="required">必須</span>
                                    </th>
                                    <td>
            
                                        <textarea id="holiday" name="holiday" placeholder="" rows="5"
                                        >@if(!is_null($job_info)){{$job_info->holiday}}@endif</textarea>            
                                    </td>           
            
                                </tr>

                                <tr class="manager_name-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="manager_name">求人担当者名</label>
                                    </th>
                                    <td>
            
                                        <input type="text" id="manager_name" name="manager_name" placeholder="" 
                                        @if(is_null($job_info))
                                            value=""
                                        @else
                                            value="{{$job_info->manager_name}}"
                                        @endif
                                        >            
                                    </td>           
            
                                </tr>

                                <tr class="tel-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="tel">電話番号</label>
                                    </th>
                                    <td>
            
                                        <input type="tel" id="tel" name="tel" placeholder="" 
                                        @if(is_null($job_info))
                                            value=""
                                        @else
                                            value="{{$job_info->tel}}"
                                        @endif
                                        >            
                                    </td>           
            
                                </tr>

                                <tr class="fax-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="fax">FAX</label>
                                    </th>
                                    <td>
            
                                        <input type="tel" id="fax" name="fax" placeholder="" 
                                        @if(is_null($job_info))
                                            value=""
                                        @else
                                            value="{{$job_info->fax}}"
                                        @endif
                                        >            
                                    </td>           
            
                                </tr>

                                <tr class="hp_url-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="hp_url">hp_url</label>
                                    </th>
                                    <td>
            
                                        <input type="tel" id="hp_url" name="hp_url" placeholder="" 
                                        @if(is_null($job_info))
                                            value=""
                                        @else
                                            value="{{$job_info->hp_url}}"
                                        @endif
                                        >            
                                    </td>           
            
                                </tr>

                                <tr class="mailaddress-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="mailaddress">メールアドレス</label>
                                    </th>
                                    <td>
            
                                        <input type="tel" id="mailaddress" name="mailaddress" placeholder="" 
                                        @if(is_null($job_info))
                                            value=""
                                        @else
                                            value="{{$job_info->mailaddress}}"
                                        @endif
                                        >            
                                    </td>           
            
                                </tr>


                                <tr class="application_requirements-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="application_requirements">応募資格</label>                                        
                                    </th>
                                    <td>
            
                                        <textarea id="application_requirements" name="application_requirements" placeholder="" rows="5"
                                        >@if(!is_null($job_info)){{$job_info->application_requirements}}@endif</textarea>            
                                    </td>            
                                </tr>

                                <tr class="scout_statement-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="scout_statement">スカウト文</label>                                        
                                    </th>
                                    <td>
            
                                        <textarea id="scout_statement" name="scout_statement" placeholder="" rows="5"
                                        >@if(!is_null($job_info)){{$job_info->scout_statement}}@endif</textarea>            
                                    </td>            
                                </tr>

                                <tr class="remarks-tr">
                                    <th class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                                        <label for="remarks">求人備考</label>                                        
                                    </th>
                                    <td>
            
                                        <textarea id="remarks" name="remarks" placeholder="" rows="5"
                                        >@if(!is_null($job_info)){{$job_info->remarks}}@endif</textarea>            
                                    </td>            
                                </tr>
                            
            
                            </tbody>
                            
                        </table>
                                              
           
                        
                    </div>

                    <div class="col-12 mt-1 m-0 p-0">

                        <div id="" class="job-image-outer-area">

                            @php                                
                                $job_image_index = 0;
                                $no_image_asset_path = $job_images_path_array["no_image_asset_path"];
                                $job_image_path_array = $job_images_path_array["job_image_path_array"];
                            @endphp

                            @foreach ($job_image_path_array as $job_image_path_index => $job_image_info)
                           
                                @php
                                    $job_image_index = $job_image_index + 1;
                                    $asset_path = $job_image_info["asset_path"];
                                    $image_name = $job_image_info["image_name"];
                                @endphp

                                @if($asset_path != "")


                                    <div id="" class="job-image-inner-area">

                                        <input type="hidden" id='job_image_change_flg{{$job_image_index}}' name="job_image_change_flg{{$job_image_index}}" value="0">

                                        <div id="" class="w-100 m-0 p-0">
                                            <h3>画像{{$job_image_index}}</h3>
                                        </div>    

                                        <div id="job-image-area{{$job_image_index}}" class="job-image-area">
                                            <img src="{{$asset_path}}" class="job-image" alt="{{$image_name}}">                          
                                        </div>
                                        
                                        
                                        <div id="" class="w-100 m-0 p-0">

                                            <input type="file" id='job_image_input{{$job_image_index}}'name="job_image_input{{$job_image_index}}" accept=".png , .PNG , .jpg , .JPG , .jpeg , .JPEG">
                                            <button type="button" id='' class="btn btn-success job-image-input-button" data-target="{{$job_image_index}}">画像選択</button>
                                         

                                            <button type="button" class="reset-button btn btn-secondary" data-target="{{$job_image_index}}">リセット <i class="fas fa-minus-square"></i></button>
                                        </div>
                                        
                                    
                                    </div>


                                @else


                                    <div id="" class="job-image-inner-area">

                                        <input type="hidden" id='job_image_change_flg{{$job_image_index}}' name="job_image_change_flg{{$job_image_index}}" value="0">

                                        <div id="" class="w-100 m-0 p-0">
                                            <h3>画像{{$job_image_index}}</h3>
                                        </div>

                                        <div id="job-image-area{{$job_image_index}}" class="job-image-area"> 
                                            <img src="{{$no_image_asset_path}}" class="job-image" alt="">                                                                                                      
                                        </div>
                                        
                                        
                                        <div id="" class="w-100 m-0 p-0">
                                            <input type="file" id='job_image_input{{$job_image_index}}' name="job_image_input{{$job_image_index}}" accept=".png , .PNG , .jpg , .JPG , .jpeg , .JPEG">
                                            <button type="button" id='' class="btn btn-success job-image-input-button" data-target="{{$job_image_index}}">画像選択</button>
                                         

                                            <button type="button" class="reset-button btn btn-secondary" data-target="{{$job_image_index}}">リセット <i class="fas fa-minus-square"></i></button>
                                        </div>
                                    
                                    </div>


                                @endif                               
                            @endforeach                                         

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


{{-- エラーモーダル --}}
<div class="modal fade" id="error-modal" tabindex="-2" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="error-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="error-modal-label">エラー</h5>
                <button type="button" data-bs-dismiss="modal" class="close">
                    <span aria-hidden="true">&times;</span>                    
                </button>               
            </div>        
        
            <div class="modal-body">  
                <div class="error-message-area">
                </div>                  
            </div>                

            <div class="modal-footer">                            
                <button type="button" id="" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>                    
            </div>         
        </div>
    </div>
</div>

@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){



    
//エンターキー無効関数　AddressSearchButton
		noEnterKey();

    //エンターキー無効関数
    function noEnterKey() {
        //エンターキーでTAB移動

        // 20231031 N.Shimabukuro Start
        // textareaは、TABではなく改行

        // $('input, select, textarea').on('keydown', function(e) {
    $('input, select,button').on('keydown', function(e) {

            // 20231031 N.Shimabukuro End      
        var code = e.which ? e.which : e.keyCode;
            if (code == 13) {
                //if (e.which == 18) {//altでテスト用
                if (e.ctrlKey) {
                $(this).closest('form').submit();
                } else {
                
                // var fields = $(this).closest('form').find('input, select, textarea');
                var fields = $(this).closest('.container').find('input, select, textarea ,button');
                var total = fields.length;
                var index = fields.index(this);
                var index_next = index + (e.shiftKey ? (index > 0 ? -1 : 0) : (index < total ? +1 : total));

                if (fields.eq(index_next).is(":disabled") === true) {
                    if (e.shiftKey) {
                    index_next -= 1;
                    if (index_next < 1) index_next = 0;
                    } else {
                    index_next += 1;
                    if (index_next > total) index_next = total;
                    }
                }
                // フォーカス移動
                fields.eq(index_next).focus();
                return false;
                }
            }
        });
    }

























    //FormDataオブジェクトを作成
    var formData = new FormData();
    
    // 画像アップロード処理関連     
    var job_image_input1 = document.getElementById('job_image_input1');    
    var job_image_input2 = document.getElementById('job_image_input2');    
    var job_image_input3 = document.getElementById('job_image_input3');

    
    var no_image_element = "<img src='{{$no_image_asset_path}}' class='job-image' alt=''> ";
    
	job_image_input1.addEventListener('change', function () {

		// 選択したファイルの全情報取得
		let element = document.getElementById('job_image_input1');

		// 選択したファイルをファイル名で格納
		let files = element.files;			

		PreviewFile(this.files[0],1);            
		

    });    

    job_image_input2.addEventListener('change', function () {

        // 選択したファイルの全情報取得
        let element = document.getElementById('job_image_input2');

        // 選択したファイルをファイル名で格納
        let files = element.files;			

        PreviewFile(this.files[0],2);            


    });    

    job_image_input3.addEventListener('change', function () {

        // 選択したファイルの全情報取得
        let element = document.getElementById('job_image_input3');

        // 選択したファイルをファイル名で格納
        let files = element.files;			

        PreviewFile(this.files[0],3);


    });    

	


    function PreviewFile(file,target) {
        
		// プレビュー内で表示している画像を一旦全削除
		$("#job-image-area" + target).empty();

        $("#job_image_change_flg" + target).val(1);       

        // document.getElementById('job_image_input' + target).value = '';

        // FileReaderオブジェクトを作成
        const reader = new FileReader();

        // URLとして読み込まれたときに実行する処理
        reader.onload = function (e) {

            // URLはevent.target.resultで呼び出せる
            const imageUrl = e.target.result;

            // img要素を作成
            // ("embed")...jpeg,img,pingは通常表示、PDFファイルはスクロールバー付きで表示
            const img = document.createElement("img");
            img.setAttribute('class', 'job-image');           

            // URLをimg要素にセット
            img.src = imageUrl;

            const job_image_area = document.getElementById("job-image-area" + target);

            // #Previewの中に追加
            job_image_area.appendChild(img);
           
        }

        // ファイルをURLとして読み込む
        reader.readAsDataURL(file);
    }


    // リセットボタン押下イベント
	$('.reset-button').on('click', function() {
		
        var target = $(this).data('target');

        // プレビュー内で表示している画像を一旦全削除
        $("#job-image-area" + target).empty();		
		$('.reset-button' + target).blur();
        
        
        document.getElementById('job_image_input' + target).value = '';

        $("#job-image-area" + target).html(no_image_element);
        $("#job_image_change_flg" + target).val(1);
        
    });

    const selectedFiles = [];

    $('#job_image_input').on('change', function(event) {
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


    // 画像選択ボタンがクリックされたら
    $('.job-image-input-button').click(function () {

        var target_id = "#job_image_input" + $(this).data("target");
        $(target_id).trigger("click");
        

    });

    // PDF出力ボタン
    $('#output-pdf-button').click(function () {

        var job_id = $(this).data("jobid");
        var employer_id = $(this).data("employerid");


        var url = "";
        var url = "{{ route('recruit_project.job_information_ledger_session')}}"

        $.ajax({
           url: url, // 送信先
           type: 'get',
           dataType: 'json',
           data: {employer_id : employer_id , job_id : job_id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}

       })
       .done(function (data, textStatus, jqXHR) {
        

            var url = "{{ route('recruit_project.job_information_ledger') }}"

            window.open(url, '_blank');

       })
           .fail(function (data, textStatus, errorThrown) {
           
              

           });



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

        var formData = new FormData($('#save-form').get(0));

        start_processing("#main");

        //マウスカーソルを砂時計に
        document.body.style.cursor = 'wait';

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
            // 送信成功
            .done(function (data, textStatus, jqXHR) {

                end_processing();

                //{{-- ボタン有効 --}}
                $('#save-button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}
                document.body.style.cursor = 'auto';


                var result_array = data.result_array;

                var Result = result_array["Result"];

                if(Result=='success'){

                    
                    window.location.href = "{{ route('recruit_project.job_information_confirmation') }}";
                    // location.reload();

                }else{

                    var message = result_array["message"];

                    //{{-- アラートメッセージ表示 --}}
                    var errorsHtml = '<div class="alert alert-danger text-start">';
                        errorsHtml += '<li  class="text-start">' + message + '</li>';
                        errorsHtml += '</div>';
                        
                    // // エラーモーダルを表示。
                    $('#error-modal').modal('show');
                    $('.error-message-area').html(errorsHtml);                  

                }


            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {

                end_processing();
                //{{-- ボタン有効 --}}
                $('#save-button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}
                document.body.style.cursor = 'auto';

                //{{-- アラートメッセージ表示 --}}
                var errorsHtml = '<div class="alert alert-danger text-start">';

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

        
                // エラーモーダルを表示。
                $('#error-modal').modal('show');
                $('.error-message-area').html(errorsHtml);


            });

    });
   

});

</script>
@endsection

