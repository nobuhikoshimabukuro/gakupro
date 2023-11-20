@extends('hp.common.layouts_app')

@section('pagehead')
@section('title', '求人詳細情報')  
@endsection
@section('content')

<style>
    
    .item-center{
        display: flex;
        justify-content: center; /*左右中央揃え*/
        align-items: center;     /*上下中央揃え*/
    }

    .job-detail-board{
        margin: 1vw;
        padding: 1vw;                
        border:1px solid #e1e1e1;
        border-bottom: 1px solid #e1e1e1;
        -webkit-box-shadow: 0px 0px 3px #ababab; /* Safari, Chrome用 */
        -moz-box-shadow: 0px 0px 3px #ababab; /* Firefox用 */
        box-shadow: 0px 0px 3px #ababab; /* CSS3 */
        border-radius:10px;
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

.caption-name {
    position: relative;
    color: black;
    background: #d0ecff;
    line-height: 1.4;
    padding: 0.25em 0.5em;
    margin: 2em 0 0.5em;
    border-radius: 0 5px 5px 5px;
}

.caption-name:after {
  
  position: absolute;
  font-family: "Font Awesome 5 Free",'Quicksand','Avenir','Arial',sans-serif;
  font-weight: 900;
  content: '\f00c Check';
  background: #2196F3;
  color: #fff;
  left: 0px;
  bottom: 100%;
  border-radius: 5px 5px 0 0;
  padding: 3px 7px 1px;
  font-size: 0.7em;
  line-height: 1;
  letter-spacing: 0.05em
}


.test-name {  
  color: black;
  background: #d0ecff;
  line-height: 1.4;
  padding: 0.25em 0.5em;  
  border-radius: 0 5px 5px 5px;
}




.check:after {
  
  
  font-family: "Font Awesome 5 Free",'Quicksand','Avenir','Arial',sans-serif;
  font-weight: 900;
  content: '\f00c Check';
  background: #2196F3;
  color: #fff;
  left: 0px;  
  border-radius: 5px 5px 0 0;
  padding: 3px 7px 1px;
  
  line-height: 1;
  letter-spacing: 0.05em
} 

/* 
.test{

    border-style: solid;
    border-radius: 5px 5px 0 0;
    border-color: #d0ecff;
} */
    
</style>

    @php

        $id = $job_information->id;    
        $employer_id = $job_information->employer_id;
        $employer_name = $job_information->employer_name;
        $employer_hp_url = $job_information->employer_hp_url;
        $employer_description = $job_information->employer_description;
        
        $employer_remarks = $job_information->employer_remarks;
        $job_id = $job_information->job_id;
        $title = $job_information->title;
        $sub_title = $job_information->sub_title;
        $work_location = $job_information->work_location;
        $employment_status = $job_information->employment_status;
        $working_time = $job_information->working_time;
        $salary = $job_information->salary;
        $holiday = $job_information->holiday;
        $tel = $job_information->tel;
        $fax = $job_information->fax;
        $job_hp_url = $job_information->job_hp_url;
        $mailaddress = $job_information->mailaddress;
        $application_requirements = $job_information->application_requirements;
        $publish_start_date = $job_information->publish_start_date;
        $publish_end_date = $job_information->publish_end_date;
        
        $scout_statement = $job_information->scout_statement;
        $job_remarks = $job_information->job_remarks;
        

        // 画像格納場所完全path配列
        $asset_path_array = $job_information->asset_path_array;
        $employment_status_datas = $job_information->employment_status_datas;
        $job_category_datas = $job_information->job_category_datas;
        $job_supplement_category_datas = $job_information->job_supplement_category_datas;

    @endphp


<div id="main" class="mt-3 text-center container">

    <div id="" class="row item-center">
        
        <div class="job-detail-board col-11 col-md-8 mt-3">
                    
            <div id="" class="row">

                <div class="col-12 text-start">
                    <h3>
                        {{$job_information->title}}
                    </h3>
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


                                <div id="drop-zone{{$job_image_index}}" class="job-image-inner-area">

                                  
                                    <div id="job-image-area{{$job_image_index}}" class="job-image-area">
                                        <img src="{{$asset_path}}" class="job-image" alt="{{$image_name}}">                          
                                    </div>

                                </div>


                            @else


                                <div id="drop-zone{{$job_image_index}}" class="job-image-inner-area">                         

                                    <div id="job-image-area{{$job_image_index}}" class="job-image-area"> 
                                        <img src="{{$no_image_asset_path}}" class="job-image" alt="">                                                                                                      
                                    </div>                                   
                                
                                </div>
                                
                            @endif                               
                        @endforeach                                         

                    </div>
                    
                </div>



                <div class="col-12 text-start">
                    <h4>
                        {{$job_information->sub_title}}
                    </h4>
                    <p>
                        {!! nl2br(e($job_information->scout_statement)) !!}                        
                    </p>

                    @if($job_information->job_hp_url != "")
                        {{$job_information->job_hp_url}}
                    @endif
                </div>


                <div class="col-12 text-start">
                    <h4 class="caption-name">
                        私たちについて
                    </h4>
                    <p>
                        {!! nl2br(e($job_information->employer_description)) !!}                        
                    </p>

                    @if($job_information->employer_hp_url != "")
                        {{$job_information->employer_hp_url}}
                    @endif
                </div>

                @if(count($employment_status_datas) > 0)
                    
                    <div class="col-12 text-start">

                        <div class="check">
                            
                        </div>
                        <h4 class="test-name">
                            雇用形態
                        </h4>

                        <div class="row m-0 p-0">

                            @foreach ($employment_status_datas as $employment_status_index => $employment_status_data)
                            
                                @php
                                    $employment_status_id = $employment_status_data["employment_status_id"];
                                    $employment_status_name = $employment_status_data["employment_status_name"];                           
                                @endphp

                                <div class="col-3">
                                    {{$employment_status_name}}
                                </div>
                                
                                
                            @endforeach

                        
                        </div>

                    </div>

                @endif

                @if(count($job_category_datas) > 0)

                    <div class="col-12 text-start">
                        <h4 class="caption-name">
                            職種
                        </h4>
                        <div class="row m-0 p-0 test">

                        @foreach ($job_category_datas as $job_category_index => $job_category_data)

                            @php
                                $job_maincategory_cd = $job_category_data["job_maincategory_cd"];
                                $job_maincategory_name = $job_category_data["job_maincategory_name"];
                                $job_subcategory_cd = $job_category_data["job_subcategory_cd"];
                                $job_subcategory_name = $job_category_data["job_subcategory_name"];
                            @endphp

                            <div class="col-3">
                                {{$job_subcategory_name}}
                            </div>
                            
                        @endforeach

                        </div>
                    </div>

                @endif

                @if(count($job_supplement_category_datas) > 0)
                    <div class="col-12 text-start">
                        <h4 class="caption-name">
                            その他のポイント
                        </h4>

                        <div class="row m-0 p-0">

                        @foreach ($job_supplement_category_datas as $job_supplement_category_index => $job_supplement_category_data)

                            @php
                                $job_supplement_maincategory_cd  = $job_supplement_category_data["job_supplement_maincategory_cd"];
                                $job_supplement_maincategory_name = $job_supplement_category_data["job_supplement_maincategory_name"];
                                $job_supplement_subcategory_cd = $job_supplement_category_data["job_supplement_subcategory_cd"];
                                $job_supplement_subcategory_name = $job_supplement_category_data["job_supplement_subcategory_name"];
                            @endphp

                            <div class="col-3">
                                {{$job_supplement_subcategory_name}}
                            </div>
                            
                        @endforeach

                        </div>
                    </div>
                @endif



            </div>
          
        </div>
  

    </div>
    
</div>




@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){




});

</script>
@endsection

