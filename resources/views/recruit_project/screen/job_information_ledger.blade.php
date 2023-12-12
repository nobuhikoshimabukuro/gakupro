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
}



.item-center{
  display: flex;
  justify-content: center; /*左右中央揃え*/
  align-items: center;     /*上下中央揃え*/
}

    .job-image-inner-area{
        position: relative;

        width: 100mm;
        height: 70mm;
    }

    .job-image{        
        width: 100%;    
        height:  100%;
        object-fit: contain; 
    }


</style>


<div class="header-area">
  
    <button class="btn btn-primary print-button">
      <i class="fas fa-file-import"></i>
      印刷
    </button>
  
</div>


@php
                            


                            
    $job_images_get_flg = $job_information_t->job_images_get_flg;

    if($job_images_get_flg == 1){

        $job_image_path_info = $job_information_t->job_image_path_info;

        $asset_path = $job_image_path_info["asset_path"];
        $image_name = $job_image_path_info["image_name"]; 

    }

@endphp

<div class="sheet-area">
  
  <section class="sheet">

    <div class="row">


    </div>
    @if($job_images_get_flg == 1)

        <div class="job-image-inner-area item-center">
            <img src="{{$asset_path}}" class="job-image" alt="{{$image_name}}">                                
        </div>


    @else


    @endif
    

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

