@extends('hp.common.layouts_app')

@section('pagehead')
@section('title', '求人詳細情報')  
@endsection
@section('content')


<style>
    

    p{
        padding: 3px;
        color: rgb(9, 3, 36);        
        line-height: 1.75;
        font-family: "MS Pゴシック" ;

    }

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



.heading-name {  
  color: black;
  background: #d0ecff;
  line-height: 1.4;
  padding: 0.25em 0.5em;  
  border-radius: 5px 5px 5px 5px;
}

.heading-name-check {  
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
  padding: 4px 7px 4px;
  
  line-height: 1;
  letter-spacing: 0.05em
} 

/* 
.test{

    border-style: solid;
    border-radius: 5px 5px 0 0;
    border-color: #d0ecff;
} */
    
     
    
.job-image-outer-area{
    width: 100%;
    overflow-x: auto;
    /* background-color: rgb(180, 179, 176); */
    display: flex;    
    
}

.job-image-inner-area{    
    
}

.job-image-area{
    aspect-ratio: 16 / 9;
    
}

/* アスペクト比（縦横比 */

.job-image{        
        width: 100%;    
        height:  100%;
        object-fit: contain; 
    }


/* PC用 */
@media (min-width:769px) {  /*画面幅が769px以上の場合とする*/
 
    
    .o-w-66{
        width:66%;        
    }

    .o-w-48{
        width:48%;
    }

    .o-w-31{
        width:31%;        
    }

    .job-image-outer-area{
        justify-content: center; /*左右中央揃え*/
    }
    
}

/* スマホ用 */
@media (max-width:768px) {  /*画面幅が768px以下の場合とする*/

    .job-image-inner-area{
        min-width:100%;
    }
}



.title span{
    

}

.sub_title{    
    color:white;
    background: #0673bb;
    line-height: 1.4;
    padding: 0.25em 0.5em;  
    border-radius: 5px 5px 5px 5px;
}


.job_supplement_subcategory{
    font-weight: bold;
    text-align: center;
    color:white;
    /* background: #0673bb; */
/* 
    background: #6affda;
background: -moz-linear-gradient(left, #6affda 0%, #6950ff 100%);
background: -webkit-linear-gradient(left, #6affda 0%,#6950ff 100%);
background: linear-gradient(to right, #6affda 0%,#6950ff 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6affda', endColorstr='#6950ff',GradientType=1 ); */


background: #42C75E;
background: -moz-linear-gradient(left, #42C75E 0%, #7EBCED 100%);
background: -webkit-linear-gradient(left, #42C75E 0%,#7EBCED 100%);
background: linear-gradient(to right, #42C75E 0%,#7EBCED 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#42C75E', endColorstr='#7EBCED',GradientType=1 );


    line-height: 1.4;    
    padding: 2px;  
    border-radius: 4px;

}

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
    $mailaddress = $job_information->mailaddress;
    $job_hp_url = $job_information->job_hp_url;
    $application_requirements = $job_information->application_requirements;
    $publish_start_date = $job_information->publish_start_date;
    $publish_end_date = $job_information->publish_end_date;
    $Job_duties = $job_information->Job_duties;
    $application_process = $job_information->application_process;    
    $scout_statement = $job_information->scout_statement;
    $job_remarks = $job_information->job_remarks;
    

    // 画像格納場所完全path配列
    $asset_path_array = $job_information->asset_path_array;
    $employment_status_datas = $job_information->employment_status_datas;
    $job_category_datas = $job_information->job_category_datas;
    $job_supplement_category_datas = $job_information->job_supplement_category_datas;

    $job_images_info_array = $job_information->job_images_info_array;
@endphp
    


<div id="main" class="mt-3 text-center container">

    <div id="" class="row item-center">
        
        <div class="job-detail-board col-11 col-md-8 mt-3">
                    
            <div id="" class="row">

                <div class="col-12 text-start">
                    <h3 class="m-0 p-0 title">
                        <span>{{$title}}</span>
                    </h3>
                    <h4 class="m-0 p-0">
                        {{$employer_name}}
                    </h4>
                </div>

                <div class="col-12 mt-1 m-0 p-2 job-image-all-area">

                    <div id="" class="job-image-outer-area">

                        @php
                            $job_image_count = $job_images_info_array["job_image_count"];
                            $no_image_asset_path = $job_images_info_array["no_image_asset_path"];
                            $job_image_path_array = $job_images_info_array["job_image_path_array"];


                            $add_class = "";
                            if($job_image_count == 1){
                                $add_class = "o-w-66";
                            }elseif($job_image_count == 2){
                                $add_class = "o-w-48";
                            }elseif($job_image_count == 3){
                                $add_class = "o-w-31";
                            }
                        @endphp


                        @if($job_image_count == 0)

                            {{-- <div id="" class="job-image-inner-area {{$add_class}}">
                                        
                                <div id="" class="job-image-area">
                                    <img src="{{$no_image_asset_path}}" class="job-image" alt="no_image">                          
                                </div>

                            </div> --}}

                        @else

                            @foreach ($job_image_path_array as $job_image_path_index => $job_image_info)
                        
                                @php                                
                                    $asset_path = $job_image_info["asset_path"];
                                    $image_name = $job_image_info["image_name"];
                                    
                                @endphp

                                @if($asset_path != "")
                                    
                                    <div id="" class="job-image-inner-area {{$add_class}}">
                                    
                                        <div id="" class="job-image-area">
                                            <img src="{{$asset_path}}" class="job-image" alt="{{$image_name}}">                          
                                        </div>

                                    </div>
                                @endif        

                            @endforeach

                        @endif                                                           

                    </div>
                    
                </div>

                {{-- スカウト文 --}}
                <div class="col-12 mt-1 text-start">
                    
                    <h4 class="sub_title">
                        {{$sub_title}}
                    </h4>
                    <p>
                        {!! nl2br(e($scout_statement)) !!}
                    </p>
                    
                </div>

                @if(count($job_category_datas) > 0)

                    <div class="col-12 text-start">
                        <h4 class="heading-name">
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

                                <div class="col-6 col-md-3">
                                    {{$job_subcategory_name}}
                                </div>
                                
                            @endforeach

                        </div>
                    </div>

                @endif

                <div class="col-12 text-start">
                    <h4 class="heading-name">
                        仕事内容
                    </h4>
                    <p>
                        {!! nl2br(e($Job_duties)) !!}
                    </p>                
                </div>

                <div class="col-12 text-start">

                    <div class="check">
                        
                    </div>
                    <h4 class="heading-name-check">
                        雇用形態/給与
                    </h4>

                    <p>
                        {!! nl2br(e($salary)) !!}
                    </p>   

                </div>

                <div class="col-12 text-start">
                    <h4 class="heading-name">
                        応募資格
                    </h4>
                    <p>
                        {!! nl2br(e($application_requirements)) !!}
                    </p>                
                </div>

                <div class="col-12 text-start">
                    <h4 class="heading-name">
                        応募方法
                    </h4>
                    <p>
                        {!! nl2br(e($application_process)) !!}
                        
                        @if($tel != "")
                            <br>
                            TEL：{{$tel}}                            
                        @endif

                        @if($fax != "")
                            <br>
                            FAX：{{$fax}}                            
                        @endif

                        @if($mailaddress != "")
                            <br>
                            MAIL：{{$mailaddress}}                            
                        @endif

                        @if($job_hp_url != "")                            
                            <br>
                            <a href="{{$job_hp_url}}" target="_blank">求人詳細ページ</a>                    
                        @endif
                    </p>                
                </div>


               

                @if(count($job_supplement_category_datas) > 0)
                    <div class="col-12 text-start">
                        <h4 class="heading-name">
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

                                <div class="col-6 col-lg-4 col-xl-3 mb-2">
                                    <div class="job_supplement_subcategory">
                                        {{$job_supplement_subcategory_name}}
                                    </div>
                                </div>
                                
                            @endforeach

                        </div>

                    </div>
                @endif


                <div class="col-12 text-start">

                    <h4 class="heading-name">
                        私たちについて
                    </h4>
                    <p>
                        {!! nl2br(e($employer_description)) !!}
                        <br>
                        @if($employer_hp_url != "")
                            <div>雇用者サイト</div>
                            <div>
                                <a href="{{$employer_hp_url}}" target="_blank">{{$employer_hp_url}}</a>                        
                            </div>
                        @endif

                    </p>

                </div>

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

