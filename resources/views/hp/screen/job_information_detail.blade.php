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

    @endphp


<div id="main" class="mt-3 text-center container">

    <div id="" class="row item-center">
        
        <div class="job-detail-board col-11 col-md-8 mt-3">
        {{-- <div class="col-11 col-md-8 mt-3"> --}}
            
            
            <div id="" class="row">

                <div class="col-12 text-start">
                    <h3>
                        {{$job_information->title}}
                    </h3>
                </div>

                <div class="col-12 text-start">
                    <p>
                        掲載期間:{{$job_information->publish_start_date}}～{{$job_information->publish_end_date}}                        
                    </p>
                </div>

                <div class="col-12 job-image-outer-area item-center">

                    <div class="job-image-inner-area item-center">
                        @foreach ($asset_path_array as $job_image_index => $asset_full_path)
                            @if($job_image_index == 0)
                                <img src="{{$asset_full_path}}" class="job-image" alt="">                          
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
                    <h4>
                        私たちについて
                    </h4>
                    <p>
                        {!! nl2br(e($job_information->employer_description)) !!}                        
                    </p>

                    @if($job_information->employer_hp_url != "")
                        {{$job_information->employer_hp_url}}
                    @endif
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

