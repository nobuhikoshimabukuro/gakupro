@extends('hp.common.layouts_app')

@section('pagehead')
@section('title', '求人情報')  
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
        /* height: 60vh; */
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

    .title{
        
        font-size: 20px;
        font-weight: 650;
        color: blue;
        text-align: left;
    }

    .job-image-area{        
        height: 90%;
    }

    .job-info-area{        
        height: 90%;        
    }
    
    .job-image{
        
        width: 90%;
        
    }
  
  th{   
        vertical-align: top; 
        text-align: center;
        white-space: nowrap;
    }

    td{    
        
        text-align: left;
        padding-left: 2px;
    }
</style>

<div id="main" class="mt-3 text-center container">

    <div id="" class="row item-center">

        
        
        <div id="" class="job-board col-11 col-md-9">

            <div id="" class="row m-0 p-0 job-board-inner-area">
                
                    
                
                <div id="" class="title">
                    居酒屋調理スタッフ
                </div>

                {{-- PCは二分割、モバイルは縦に分割 --}}
                {{-- 写真エリア --}}
                <div id="" class="col-12 col-md-5 m-0 p-0 job-image-area item-center">                    
                    <img src="{{ asset('storage/job_image/1/1.png')}}" class="job-image" alt="">       
                </div>

                {{-- 求人情報エリア --}}
                <div id="" class="col-12 col-md-7 m-0 p-0 job-info-area">
                    <table>
                        <tr>
                            <th>
                                勤務地
                            </th>
                            <td>
                                名護市
                            </td>
                        </tr>

                        <tr>
                            <th>
                                雇用形態
                            </th>
                            <td>
                                アルバイト
                            </td>
                        </tr>

                        <tr>
                            <th>
                                就労時間
                            </th>
                            <td>
                                14:00～深0:00 ※実働8時間のシフト制 ※多少変動あり/時間帯相談に応じます
                            </td>
                        </tr>

                    </table>
                    
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

