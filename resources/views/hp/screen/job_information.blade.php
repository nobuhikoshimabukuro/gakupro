@extends('hp.common.layouts_app')

@section('pagehead')
@section('job-name', '求人情報')  
@endsection
@section('content')

<style>

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
        /* width: 100%;
        height: 40vh; */
    }

    .job-image{        
        width: 90%;        
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

</style>

<div id="main" class="mt-3 text-center container">

    <div id="" class="row item-center">

        
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
                    <div id="" class="col-12 col-md-5 m-0 p-0 job-image-outer-area item-center">   

                        <div class="job-image-inner-area item-center">
                            <img src="{{ asset('storage/job_image/1/1.png')}}" class="job-image" alt="">       
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


                    <div id="" class="col-6 m-0 p-0">

                        <button id="" class="w-75 m-0 p-0 job-detail btn btn-outline-success" data-jobnumber="{{$info->id}}">
                            求人明細を見る
                        </button>

                    </div>

                    

                    <div id="" class="col-6 m-0 p-0">

                        <button id="" class="w-75 m-0 p-0 employer-detail btn btn-outline-success" data-employerid="{{$info->employer_id}}">
                            雇用者情報を見る
                        </button>

                    </div>
                

                </div>


            </div>
        @endforeach
            
        
    </div>
    

</div>
    





@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){



    
    $('.job-detail').click(function () {
        
        var job_number = $(this).data('jobnumber');
        var url = '{{ route('hp.job_information_detail') }}' + "?job_number=" + job_number;
        window.open(url, '_blank');

    });





});

</script>
@endsection

