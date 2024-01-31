@extends('recruit_project.common.layouts_ledger')

@section('pagehead')
@section('title', '求人レポート')  
@endsection
@section('content')

<style>


@media screen {

    body {
        background: #eee;
    }
    .sheet {
        background: white; /* 背景を白く */
        box-shadow: 0 .5mm 2mm rgba(0,0,0,.3); /* ドロップシャドウ */
        margin: 5mm;
    }
}


@page {

    /* 縦 */
    size: A4 portrait;

    /* 横 */
    /* size: A4 landscape; */    
    margin: 0mm;
}
*{
    margin: 0mm;
    padding: 0mm;
}

@media print{
    .header-area{
        display: none;
    }
}

.header-area{
  width: 100%;
  margin: 3px 0;  
  text-align: right;  
}



.print-button{
  margin: 5px 5px 0 0;
}

.sheet-area{
  display: flex;
  justify-content: center;
  
}

.sheet {
    
    /* 縦 */
    height: 297mm;
    width: 210mm;

    /* 横 */
    /* height: 210mm;
    width: 297mm; */

    page-break-after: always;
    box-sizing: border-box;
    padding: 10mm;
    font-size: 15pt;

    position: relative;
    
}



.item-center{
  display: flex;
  justify-content: center; /*左右中央揃え*/
  align-items: center;     /*上下中央揃え*/
}


    .title{
        font-size: 20pt;
        font-weight: bold; 
    }

    .job-image-inner-area{
        

        width: 100mm;
        height: 70mm;
    }

    .job-image{        
        width: 100%;    
        height:  100%;
        object-fit: contain; 
    }

    .job-info-table th{   
        text-align-last: justify;
        text-justify: inter-ideograph;
        vertical-align: top; 
        text-align: right;
        white-space: nowrap;
    }

    .job-info-table td{        
        text-align: left;
        padding-left: 1vw;
    }

    .footer{
         /* ここにフッターのスタイリングを追加 */
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 10px;
    }

</style>


<div class="header-area">
  
    <button class="btn btn-primary print-button">
      <i class="fas fa-file-import"></i>
      印刷
    </button>
  
</div>


<div class="sheet-area">
  
  <section class="sheet">

    <div class="row">

        <div class="col-12 m-0 p-0">
            <div class="title">
                {{$job_information->title}}
            </div>
        </div>


        <div class="col-6 m-0 p-0">


                
            <div class="job-image-inner-area">
                <img src="{{$job_information->asset_path}}" class="job-image" alt="{{$job_information->image_name}}">                                
            </div>


        </div>

        <div class="col-6 m-0 p-0">
          
            <table class="job-info-table">
                <tr>
                    <th>
                        勤務地
                    </th>
                    <td>
                        {{$job_information->work_location}}　{{$job_information->work_location_municipality_name}}
                    </td>
                </tr>

                <tr>
                    <th>
                        雇用形態
                        <br>
                        給与
                    </th>
                    <td>
                        {!! nl2br(e($job_information->salary)) !!}
                        
                    </td>
                </tr>

                <tr>
                    <th>
                        就労時間
                    </th>
                    <td>
                        {!! nl2br(e($job_information->working_time)) !!}                        
                    </td>
                </tr>

               
                <tr>
                    <th>
                        休日
                    </th>
                    <td>
                        {!! nl2br(e($job_information->holiday)) !!}                                                    
                    </td>
                </tr>

            </table>  
          
        </div>

    </div>

    <div class="row">

        <div class="col-12 m-0 p-0">

            {!! nl2br(e($job_information->scout_statement)) !!}   
           



        </div>        

    </div>

   

    <div class="footer">
        <div class="row">

            <div class="col-4">
                
                @if($job_information->employer_qr_image != "")
                    <img src="data:image/png;base64,{{ base64_encode($job_information->employer_qr_image) }}" alt="QR Code">
                @endif
                <br>
                雇用者情報
            </div>
            

            <div class="col-4">
                
                @if($job_information->job_qr_image != "")
                    <img src="data:image/png;base64,{{ base64_encode($job_information->job_qr_image) }}" alt="QR Code">
                @endif
                <br>
                雇用者発行求人情報
            </div>

            <div class="col-4">
                
                @if($job_information->job_info_qr_image != "")
                    <img src="data:image/png;base64,{{ base64_encode($job_information->job_info_qr_image) }}" alt="QR Code">
                @endif
                <br>
                求人情報
            </div>
        </div>
        

    </div>
    
    

  </section>

      
</div>


@endsection

@section('pagejs')

<script type="text/javascript">



$(document).on("click", ".print-button", function (e) {

    window.print();

})

$(document).ready(function () {


    // window.print();
    // window.close();


})


</script>
@endsection

