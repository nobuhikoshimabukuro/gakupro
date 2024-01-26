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
    background:  rgb(238, 234, 234);

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

/* 項目 */
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

.required::before {
  content: '必須';  
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














#application_process-table{
    width: 100%;
    /* border: solid 1px; */
}

#application_process-table th{
    text-align: left;
    background: none;
}




















.job_maincategory_name{
    
       
}





    .job-supplement-area
    ,.job-category-area    
    {
        height: 50px;
        padding: 3px;
    }

    


    .job-supplement-label
    ,.job-category-label
    {
        height: 100%;
        width: 100%; 
        color: rgb(53, 7, 7);       
        border-radius: 3px;     
        background-color: rgb(208, 208, 241);
        
    }

    .job-supplement-select
    ,.job-category-select
    {
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


    .employment-status-area{
        height: 45px;
        padding: 3px;
        width: 110px;
    }

    .employment-status-label{
        height: 100%;
        width: 100%; 
        color:black;
        background-color: rgb(238, 234, 234);   
        font-weight: 500;        
        border-radius: 3px;
    }

    .employment-status-select
    {
        background-color:white;
        color:black;
        border: solid 1px rgb(226, 125, 125);
        font-weight: bold;
        
    }
  


    .check-mark {
        position: absolute;
        content: '';
        width: 20px;
        height: 8px;
        border-left: 3px solid red;
        border-bottom: 3px solid red;
        transform: rotate(-45deg);

        animation: fadeIn 0.7s cubic-bezier(0.33, 1, 0.68, 1) forwards;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
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
    
    display: flex;    
    
}

.job-image-inner-area{
    background-color:  rgb(238, 234, 234);
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


.fixed-salary-area{
    widows: 100%;
    min-height:30px; 
}

.salary_maincategory_cd
{
    padding: 0;
    margin: 2px; 
}

.salary_subcategory_cd
{
    padding: 0;
    margin: 2px; 
    min-width: 150px;
}

.work_location_municipality_cd{
    padding-right: 0;
    padding-left: 0;
    min-width: 150px;
}

#fixed_salary
,#fixed_application_process{
    overflow: hidden; /* スクロールバーを無効にする */    
    padding: 3px;        
    background-color: rgb(252, 244, 244);
}

.job_categor-area{
    font-weight: bold;
    text-align: center;



    line-height: 1.4;    
    padding: 2px;  
    border-radius: 4px;
    border: solid 1px;    
}



</style>


<div id="main" class="mt-3 text-center container">    
    
    <div id="" class="row item-center">

        <div class="col-11 col-md-11 mt-3">
    
            @include('recruit_project.common.alert')

            <div id="" class="row m-0 p-0">

                <div class="col-12 text-end">
                    @if($job_id <> 0)  
                        <button type="button" id="ledger-button" class="btn btn-primary">求人表</button>
                        <form id="ledger-form" method="post" class="d-none" action="{{ route('recruit_project.job_information_ledger') }}" target="_blank">
                            @csrf  
                            <input type="hidden" name="ledger_employer_id" id="ledger_employer_id" value="{{$employer_id}}">
                            <input type="hidden" name="ledger_job_id" id="ledger_job_id" value="{{$job_id}}">
                        </form>


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
                                        <label for="title">タイトル</label><span class="required"></span>
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
                                    <th class="">
                                        <label for="sub_title">サブタイトル</label><span class="required"></span>
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
                                    <th class="">
                                        <label for="work_location_prefectural_cd">勤務地</label>
                                        <span class="required"></span>
                                    </th>
                                    <td>
            
                                        
                                        @php
                                            $work_location_prefectural_cd = "";
                                            $work_location_municipality_cd = "";

                                            if(!is_null($job_info)){
                                                $work_location_prefectural_cd = $job_info->work_location_prefectural_cd;
                                                $work_location_municipality_cd = $job_info->work_location_municipality_cd;
                                            }
                                        @endphp
                             

                                        <select id='work_location_prefectural_cd' name='work_location_prefectural_cd' class='work_location_prefectural_cd input-sm'>
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
                                        
                                        
                                        
            

                                        
                                        

                                            @if($work_location_prefectural_cd != "")
                                                <select id='work_location_municipality_cd' name='work_location_municipality_cd' class=' work_location_municipality_cd input-sm'>     
                                                    @foreach($municipality_list as $municipality_info)
                                                        <option value="{{$municipality_info->municipality_cd}}"                                                    
                                                        @if($work_location_municipality_cd == $prefectural_info->municipality_cd)                                                        
                                                            selected                                                                                                                
                                                        @endif
                                                        title= "{{$municipality_info->municipality_name}}"
                                                        >
                                                        {{$municipality_info->municipality_name}}
                                                        </option>
                                                    @endforeach                       

                                            @else
                                                <select id='work_location_municipality_cd' name='work_location_municipality_cd' class='work_location_municipality_cd input-sm inoperable'>     
                                                    <option value="">
                                                        都道府県未選択
                                                    </option>
                                            @endif  
                                            

                                        </select>
                                            
                                        

                                    </td>           
            
                                </tr>


                                
            

                                <tr class="salary-tr">

                                    <th class="">
                                        <label for="salary">雇用形態/給与</label>
                                        <span class="required"></span>
                                    </th>

                                    <td >
            
                                        <div id="" class="row m-0 p-0">
                                                          
                                            
                                                
                                                @foreach($employment_status_data as $employment_status_info)
                                                
                                                    @php                            
                                                        
                                                        $employment_status_id = $employment_status_info->employment_status_id;
                                                        $employment_status_name = $employment_status_info->employment_status_name;
                    
                                                        $set_flg = 0;
                                                        $get_employment_status_id = 0;
                                                        $get_salary_maincategory_cd = 0;
                                                        $get_salary_subcategory_cd = 0;
                                                        $add_class = "";
                                                        $check_status = "";
                                                        
                                                        foreach ($employment_status_connections as $index => $employment_status_connection_info){
                    
                                                            $set_employment_status_id = $employment_status_connection_info["employment_status_id"];
                                                            $set_salary_maincategory_cd = $employment_status_connection_info["salary_maincategory_cd"];
                                                            $set_salary_subcategory_cd = $employment_status_connection_info["salary_subcategory_cd"];
                    
                                                            if($employment_status_id == $set_employment_status_id ){
                                                                
                                                                $set_flg = 1;
                                                                $get_employment_status_id = $set_employment_status_id;
                                                                $get_salary_maincategory_cd = $set_salary_maincategory_cd;
                                                                $get_salary_subcategory_cd = $set_salary_subcategory_cd;                                            

                                                                $add_class = "employment-status-select";
                                                                $check_status = "checked";
                    
                                                                break;
                                                            }
                                                        }                                    
                    
                                                    @endphp
                    
                                                        <div class="col-12 col-lg-6 m-0 p-0 d-flex">
                                                

                                                        <div id="employment-status-area{{$employment_status_id}}" 
                                                        class="employment-status-area">
                                                            <label id="employment-status-label{{$employment_status_id}}" 
                                                                for="employment-status-checkbox{{$employment_status_id}}" 
                                                                class="employment-status-label {{$add_class}} item-center"
                                                            >{{$employment_status_name}}

                                                            @if($set_flg == 1)
                                                                <div class="check-mark"></div>
                                                            @endif  
                                                            
                                                                <input type="checkbox" 
                                                                id="employment-status-checkbox{{$employment_status_id}}"
                                                                name="employment-status-checkbox{{$employment_status_id}}"
                                                                value="{{$employment_status_id}}"                        
                                                                data-target="{{$employment_status_id}}"
                                                                data-employmentstatusname="{{$employment_status_name}}"
                                                                class="employment-status-checkbox d-none"                                    
                                                                {{$check_status}}
                                                                >
                                                                
                                                            </label>


                                                            
                                                        </div>

                                               

                                                        <select id='employment_status_id_{{$employment_status_id}}_salary_maincategory_cd' 
                                                            name='employment_status_id_{{$employment_status_id}}_salary_maincategory_cd' 
                                                            class='salary_maincategory_cd   @if($set_flg == 0) inoperable @endif'
                                                            data-employmentstatusid="{{$employment_status_id}}"
                                                        >
                                                            <option value=''>---</option>
                                                                @foreach ($salary_maincategory_list as $salary_maincategory_index => $salary_maincategory_info)
                                                                    <option value="{{$salary_maincategory_info->salary_maincategory_cd}}"
                                                                    @if($get_salary_maincategory_cd == $salary_maincategory_info->salary_maincategory_cd)
                                                                    selected
                                                                    @endif
                                                                    data-salarymaincategoryname="{{$salary_maincategory_info->salary_maincategory_name}}"
                                                                    >
                                                                    {{$salary_maincategory_info->salary_maincategory_name}}
                                                                    </option>
                                                                @endforeach
                                                        </select>

                                                  
                                                        @if($get_salary_maincategory_cd > 0)
                    
                                                            <select id='employment_status_id_{{$employment_status_id}}_salary_subcategory_cd' 
                                                                name='employment_status_id_{{$employment_status_id}}_salary_subcategory_cd' 
                                                                class='salary_subcategory_cd'
                                                            >
                                                                <option value=''>---</option>
                                                                @foreach ($salary_subcategory_list as $salary_subcategory_index => $salary_subcategory_info)
                    
                                                                    @if($get_salary_maincategory_cd == $salary_subcategory_info->salary_maincategory_cd)
                                                                        <option value="{{$salary_subcategory_info->salary_subcategory_cd}}"
                                                                        @if($get_salary_subcategory_cd == $salary_subcategory_info->salary_subcategory_cd)
                                                                        selected
                                                                        @endif                
                                                                        data-salary="{{number_format($salary_subcategory_info->salary)}}"                                                        
                                                                        >
                                                                        {{number_format($salary_subcategory_info->salary)}}円以上
                                                                        </option>
                                                                    @endif
                    
                                                                @endforeach
                                                            </select>
                    
                                                        @else
                                                            <select id='employment_status_id_{{$employment_status_id}}_salary_subcategory_cd' 
                                                                name='employment_status_id_{{$employment_status_id}}_salary_subcategory_cd' 
                                                                class='salary_subcategory_cd input-sm inoperable'                                                                
                                                            >
                                                                <option value=''></option>
                                                            </select>
                                                        @endif

                                                    </div>         
                                            
                                                
                                                @endforeach
                
                                            
                                              
                                        </div>  

                                        <div class="row m-0 p-0">

                                            <div class="col-12 col-lg-7 col-xl-6 m-0 p-0">
                                                <h4 class="m-0 p-1" style="">補足文</h4>
                                                <textarea id="salary" name="salary" placeholder="" rows="5"
                                                >@if(!is_null($job_info)){{$job_info->salary}}@endif</textarea>
                                            </div>


                                            <div class="col-12 col-lg-5 col-xl-6 m-0 p-0">
                                                <h4 class="m-0 p-1" style="">表示文</h4>                                                
                                                <textarea id="fixed_salary" name="fixed_salary" disabled>
                                                </textarea>
                                            </div>

                                          
                                        </div>

                                    </td>           
            
                                </tr>

                                <tr class="working_time-tr">

                                    <th class="">
                                        <label for="working_time">就労時間</label>
                                        <span class="required"></span>
                                    </th>

                                    <td>            
                                        <textarea id="working_time" name="working_time" placeholder="" rows="4"
                                        >@if(!is_null($job_info)){{$job_info->working_time}}@endif</textarea>            
                                    </td>           
            
                                </tr>

                                <tr class="holiday-tr">
                                    <th class="">
                                        <label for="holiday">休日</label>
                                        <span class="required"></span>
                                    </th>
                                    <td>
                                   
                                        <textarea id="holiday" name="holiday" placeholder="" rows="4"
                                        >@if(!is_null($job_info)){{$job_info->holiday}}@endif</textarea>            
                                    </td>           
            
                                </tr>

                                <tr class="Job_duties-tr">
                                    <th class="">
                                        <label for="Job_duties">仕事内容</label>                                        
                                    </th>
                                    <td>
            
                                        <textarea id="Job_duties" name="Job_duties" placeholder="" rows="4"
                                        >@if(!is_null($job_info)){{$job_info->Job_duties}}@endif</textarea>            
                                    </td>            
                                </tr>
                                
                                <tr class="scout_statement-tr">
                                    <th class="">
                                        <label for="scout_statement">スカウト文</label>                                        
                                    </th>
                                    <td>
            
                                        <textarea id="scout_statement" name="scout_statement" placeholder="" rows="7"
                                        >@if(!is_null($job_info)){{$job_info->scout_statement}}@endif</textarea>            
                                    </td>            
                                </tr>

                                <tr class="application_requirements-tr">
                                    <th class="">
                                        <label for="application_requirements">応募資格</label>                                        
                                    </th>
                                    <td>
            
                                        <textarea id="application_requirements" name="application_requirements" placeholder="" rows="4"
                                        >@if(!is_null($job_info)){{$job_info->application_requirements}}@endif</textarea>            
                                    </td>            
                                </tr>

                                <tr class="application_process-tr">
                                    <th class="">
                                        <label for="application_process">応募方法</label>                                        
                                    </th>
                                    <td>
            
                                        <div class="row m-0 p-0">

                                       

                                            <div class="col-12 col-lg-6 m-0 p-0">
                                                <div class="row m-0 p-0">

                                                    <div class="col-12 m-0 p-0">

                                                        <h4 class="m-0 p-1" style="">補足文</h4>
                                                        <textarea id="application_process" name="application_process" placeholder="" rows="4"
                                                        >@if(!is_null($job_info)){{$job_info->application_process}}@endif</textarea>

                                                    </div>

                                                    

                                                </div>
                                                
                                            </div>

                                            <div class="col-12 col-lg-6 m-0 p-0">

                                                <div class="col-12 m-0 p-0">

                                                    <table id="application_process-table">
                                                        <tr>
                                                            <th>
                                                                <label for="tel">応募用TEL</label>
                                                            </th>
                                                        </tr>
    
                                                        <tr>
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
    
                                                        <tr>
                                                            <th>
                                                                <label for="fax">応募用FAX</label>
                                                            </th>
                                                        </tr>
    
                                                        <tr>
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
    
                                                        <tr>
                                                            <th>
                                                                <label for="tel">応募用Mail</label>
                                                            </th>
                                                        </tr>
    
                                                        <tr>
                                                            <td>
                                                                <input type="text" id="mailaddress" name="mailaddress" placeholder="" 
                                                                @if(is_null($job_info))
                                                                    value=""
                                                                @else
                                                                    value="{{$job_info->mailaddress}}"
                                                                @endif
                                                                >              
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>
                                                                <label for="tel">応募用URL</label>
                                                            </th>
                                                        </tr>
    
                                                        <tr>
                                                            <td>
                                                                <input type="text" id="hp_url" name="hp_url" placeholder="" 
                                                                @if(is_null($job_info))
                                                                    value=""
                                                                @else
                                                                    value="{{$job_info->hp_url}}"
                                                                @endif
                                                                >              
                                                            </td>
                                                        </tr>
    
                                                    </table>

                                                </div>

                                      
                                            </div>

                                            <div class="col-12 m-0 p-0">

                                                <h4 class="m-0 p-1" style="">表示文</h4>
                                                                                               

                                                <textarea id="fixed_application_process" name="fixed_application_process" disabled>
                                                </textarea>

                                      
                                            </div>

                                        </div>
                                                  
                                    </td>            
                                </tr>

                                

                                <tr class="remarks-tr">
                                    <th class="">
                                        <label for="remarks">求人備考</label>
                                        <br>
                                        <label>※求人ページには表示されません。</label>
                                    </th>
                                    <td>                                        
                                        <textarea id="remarks" name="remarks" placeholder="" rows="4"
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
               

                    {{-- 業種設定エリア --}}
                    <div class="col-12 mt-3">

                     
                        <h3 class="">
                            業種設定
                        </h3>

                        <div id="" class="row m-0 p-0 job_categor-area">

                            @foreach($job_category_data as $job_category_index => $job_category_info)                     

                                @php                                    
                                    
                                    $job_maincategory_cd = $job_category_info->job_maincategory_cd;
                                    $job_maincategory_name = $job_category_info->job_maincategory_name;
                                    $job_subcategory_cd = $job_category_info->job_subcategory_cd;
                                    $job_subcategory_name = $job_category_info->job_subcategory_name;

                                    $start_flg = $job_category_info->start_flg;
                                    $end_flg = $job_category_info->end_flg;
                                    
                                    $add_class = "";
                                    $check_status = "";
                                    if(in_array($job_subcategory_cd , $job_category_connections)){
                                        $add_class = "job-category-select";                            
                                        $check_status = "checked";
                                    }                            

                                @endphp

                                @if($start_flg == 1)                                
                                    
                                    <div class="col-12 col-lg-6 mt-2 job_maincategory_name">
                                        {{$job_maincategory_name}}
                                        <div class="row m-0 p-0">
                                @endif

                                    <div id="job-subcategory-area{{$job_subcategory_cd}}" 
                                    class="col-6 col-lg-4 col-xl-4 mt-2 job-category-area">
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

                                  
                                @if($end_flg == 1) 
                                        </div>
                                    </div>

                                @endif

                            @endforeach                    
                
                        </div> 

                    </div> 


                    
                    {{-- 求人補足エリア --}}
                    <div class="col-12 mt-3">

                        <h3 class="m-1 p-0">
                            求人補足
                        </h3>

                        <div id="" class="row m-0 p-0">                     

                            @foreach($job_supplement_data as $index => $job_supplement_info)                            

                                @php                            
                                    
                                    $job_supplement_maincategory_cd = $job_supplement_info->job_supplement_maincategory_cd;
                                    $job_supplement_maincategory_name = $job_supplement_info->job_supplement_maincategory_name;
                                    $job_supplement_subcategory_cd = $job_supplement_info->job_supplement_subcategory_cd;
                                    $job_supplement_subcategory_name = $job_supplement_info->job_supplement_subcategory_name;

                                    $start_flg = $job_supplement_info->start_flg;
                                    $end_flg = $job_supplement_info->end_flg;

                                    $add_class = "";
                                    $check_status = "";
                                    if(in_array($job_supplement_subcategory_cd , $job_supplement_category_connections)){
                                        $add_class = "job-supplement-select";                            
                                        $check_status = "checked";
                                    }

                                @endphp

                                @if($start_flg == 1)                                
                                    
                                    <div class="col-12 col-lg-6  mt-2">
                                        {{$job_supplement_maincategory_name}}
                                        <div class="row m-0 p-0">
                                @endif

                                    <div id="job-supplement-area{{$job_supplement_subcategory_cd}}" 
                                        class="col-6 col-lg-4 col-xl-4 mt-2 job-supplement-area">
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

                                  
                                @if($end_flg == 1) 
                                        </div>
                                    </div>

                                @endif

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


    $(document).ready(function() {
        set_fixed_salary();
        set_fixed_application_process();
    });



    //都道府県プルダウン変更時
    $(document).on("change", "#work_location_prefectural_cd", function (e) {

        search_prefectural();

    });

  

    //都道府県毎、市区町村検索処理
    function search_prefectural(process_branch = 0){

        var prefectural_cd = $("#work_location_prefectural_cd").val();        

        var municipality_name = "";        
        var url = "{{ route('create_list.municipality_list_ajax') }}";


        
        var target_area = "#work_location_municipality_cd";

        $(target_area).removeClass('inoperable'); 

        //プルダウン内の設定初期化
        $("select" + target_area + " option").remove();        

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

            
                   // 新しいoption要素を作成
                   var option = $("<option>").val(municipality_cd).text(municipality_name);

                    // option要素をselect要素に追加
                    $(target_area).append(option); 

                })

                


            }else{

                // 新しいoption要素を作成
                var option = $("<option>").val("").text("都道府県未選択");

                // option要素をselect要素に追加
                $(target_area).append(option); 
                $(target_area).addClass('inoperable'); 


            }

            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';

        })
        .fail(function (data, textStatus, errorThrown) {



            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';

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



    //雇用形態選択値変更時
    $(document).on("change", ".employment-status-checkbox", function (e) {

        var employment_status_id = $(this).data('target');

        var target_label = "#employment-status-label" + employment_status_id;

        var target_salary_maincategory_cd = "#employment_status_id_" + employment_status_id + "_salary_maincategory_cd";
        var target_salary_subategory_cd = "#employment_status_id_" + employment_status_id + "_salary_subcategory_cd";

        $(target_label).removeClass('employment-status-select');
        $(target_label).find('.check-mark').remove();

        $(target_salary_maincategory_cd).removeClass('inoperable');
        $(target_salary_subategory_cd).removeClass('inoperable');

        if($("#employment-status-checkbox" + employment_status_id).prop('checked')){

            
            var add_html = '<div class="check-mark"></div>';           
            $(add_html).appendTo(target_label);
            $(target_label).addClass('employment-status-select');
                  
            
        }else{
            
            $(target_salary_maincategory_cd).addClass('inoperable');
            $(target_salary_subategory_cd).addClass('inoperable');
        }        

        set_fixed_salary();
    });

    

    //給与プルダウン変更時
    $(document).on("change", ".salary_maincategory_cd", function (e) {

        var employment_status_id = $(this).data('employmentstatusid');
        var salary_maincategory_cd = $(this).val();
        search_salary_sabcategory(employment_status_id,salary_maincategory_cd);

        set_fixed_salary();

    });

    //給与検索＆プルダウン作成    
    function search_salary_sabcategory(employment_status_id , salary_maincategory_cd){

        var url = "{{ route('create_list.salary_sabcategory_list_ajax') }}";
       
        var target_area = "#employment_status_id_" + employment_status_id + "_salary_subcategory_cd";

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
                    var option = $("<option>").val(salary_subcategory_cd).text(salary_display).data("salary", salary);

                    // 特定の条件でselected属性を追加
                    // if (salary_subcategory_cd == get_search_salary_subcategory_cd) {
                    //     option.attr("selected", "selected");
                    // }

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

    //給与プルダウン変更時
    $(document).on("change", ".salary_subcategory_cd", function (e) {

        set_fixed_salary();

    });

    //給与補足分変更時
    $(document).on("blur", "#salary", function (e) {

        set_fixed_salary();

    });

    function set_fixed_salary(){

        var display_text = "";

        var add_text = "";
        var salary = $("#salary").val();
        var newline = "\n";

        // classが"employment-status-checkbox"である全ての要素を取得
        $(".employment-status-checkbox").each(function() {

            if ($(this).prop("checked")) {

                // チェックされている場合、data-target属性の値を取得してコンソールに表示
                var employment_status_id = $(this).data("target");

                var employment_status_name = $(this).data("employmentstatusname");                
            
                var salary_maincategory_cd_id = "#employment_status_id_" + employment_status_id + "_salary_maincategory_cd";
                var salary_subcategory_cd_id = "#employment_status_id_" + employment_status_id + "_salary_subcategory_cd";

                var salary_maincategory_cd = $(salary_maincategory_cd_id).val();
                var salary_subcategory_cd = $(salary_subcategory_cd_id).val();

                if(salary_maincategory_cd > 0 && salary_subcategory_cd > 0)
                {
                    
                    var selectedOption = $(salary_maincategory_cd_id + " option:selected");
                    var salary_maincategory_name = selectedOption.data("salarymaincategoryname");


                    var selectedOption = $(salary_subcategory_cd_id + " option:selected");
                    var salary = selectedOption.data("salary");
                    
                    var text = employment_status_name + "：" +salary_maincategory_name + salary + "円～"; 

                    if(add_text != ""){
                        add_text += newline;
                    }

                    add_text += text;
                }                
            }
        });

        display_text = add_text + newline + salary;

           
        // 高さを可変にする
        $("#fixed_salary").html(display_text);
        
        // 高さを自動で調整する
        var newHeight = $("#fixed_salary").prop("scrollHeight");
        $("#fixed_salary").css("height", newHeight + "px");

        

    }   


    //応募方法関連値変更時
    $(document).on("blur", "#application_process,#tel,#fax,#mailaddress,#hp_url", function (e) {

        set_fixed_application_process();

    });

    function set_fixed_application_process(){

        var display_text = "";

        var add_text = "";
        var application_process = $("#application_process").val();

        var newline = "\n";
        
        var tel = $("#tel").val();
        var fax = $("#fax").val();
        var mailaddress = $("#mailaddress").val();
        var hp_url = $("#hp_url").val();

        if(tel != ""){
            if(add_text != ""){
                add_text += newline;
            }
            add_text += "TEL：" + tel;
        }

        if(fax != ""){
            if(add_text != ""){
                add_text += newline;
            }
            add_text += "FAX：" + fax;
        }

        if(mailaddress != ""){
            if(add_text != ""){
                add_text += newline;
            }
            add_text += "MAIL：" + mailaddress;
        }

        if(hp_url != ""){
            if(add_text != ""){
                add_text += newline;
            }
            add_text += "URL：" + hp_url;
        }

        if(application_process == ""){
            display_text = add_text;
        }else{
            display_text = application_process + newline + add_text;
        }
        

        // 高さを可変にする
        $("#fixed_application_process").html(display_text);
        
        // 高さを自動で調整する
        var newHeight = $("#fixed_application_process").prop("scrollHeight");
        $("#fixed_application_process").css("height", newHeight + "px");

        

            

    }   

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



    // 求人表出力ボタン
    $('#ledger-button').click(function () {

        $('#ledger-form').submit(); 

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

                    
                    // window.location.href = "{{ route('recruit_project.job_information_confirmation') }}";
                    location.reload();

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

