@extends('recruit_project.common.layouts_beforelogin')

@section('pagehead')
@section('title', '求人情報')  
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
        padding: 2mm 6mm 2mm 6mm;

    }
}


@page {
    /* 縦 */
    size: A4 portrait;

    /* 横 */
    /* size: A4 landscape;
    margin: 0mm; */
}
*{
    margin: 0mm;
    padding: 0mm;
}


@media print{
    .button-area{
        display: none;
    }
}

.sheet-area{
  display: flex;
  justify-content: center; /* 横方向の中央寄せ */
  align-items: center; /* 縦方向の中央寄せ */
}

@media (max-width: 768px) {
    .sheet-area{
    flex-direction: column; /* 横方向から縦方向に変更 */
  }
}


.sheet {
    /* 縦 */
    height: 291mm;
    width: 210mm;
    /* 横 */
    /* height: 210mm;
    width: 297mm; */
    page-break-after: always;
    box-sizing: border-box;
    padding: 2mm 6mm 2mm 6mm;
    font-size: 15pt;
    line-height: 1em;
}


.button-area{
    position: fixed;
    bottom: 0;
    right: 0;        
    padding: 20px;
    opacity:0.7;  
    z-index: 100;    
}

.button-area:hover{ 
  opacity:1;
}



</style>





@endsection


<div class="button-area">
    <button type="button" class="btn btn-outline-secondary" onclick="history.back()">
        戻る
    </button>

 
    <button class="btn btn-primary print-button">      
        印刷
    </button>
</div>


<div class="sheet-area">
            
    <section class="sheet">

        <div id="" class="row p-0 m-0">

            <div id="" class="col-6 p-0 m-0">
                <div id="" class="job-image-area">
                    <img src="{{$job_information->image_full_path}}" class="job-image" alt="no_image">                          
                </div>
            </div>

            <div id="" class="col-6 p-0 m-0">
                <h3 id="subTitle"class="">{{$job_information->sub_title}}</h3>
                <div id="" class="w-100 text-center">
                    {!! nl2br(e($job_information->scout_statement)) !!}  
                </div>

            </div>

            
        </div>
   
        <table class="table w-100">
            <tr>
                <th class="text-start" colspan="2">
                    採用情報
                </th>
            </tr>

            <tr>
                <td class="text-start">
                    職種
                </td>

                <td class="text-start">
                    スタイリスト
                </td>
            </tr>

            <tr>
                <td class="text-start">
                    勤務地
                </td>

                <td class="text-start">
                    {{ $job_information->work_location }}
                </td>
            </tr>

            <tr>
                <td class="text-start">
                    雇用形態<br>                    
                    給与
                </td>

                <td class="text-start">
                    {!! nl2br(e($job_information->salary)) !!}               
                </td>
            </tr>

            <tr>
                <td class="text-start">
                    就労時間
                </td>

                <td class="text-start">
                    {!! nl2br(e($job_information->working_time)) !!}
                </td>
            </tr>

            <tr>
                <td class="text-start">
                    休日等
                </td>

                <td class="text-start">
                    {!! nl2br(e($job_information->holiday)) !!}
                </td>
            </tr>

            <tr>
                <td class="text-start">
                    仕事内容
                </td>

                <td class="text-start">
                    {!! nl2br(e($job_information->Job_duties)) !!}
                </td>
            </tr>

            <tr>
                <td class="text-start">
                    応募資格
                </td>

                <td class="text-start">
                    {!! nl2br(e($job_information->application_requirements)) !!}
                </td>
            </tr>

            <tr>
                <td class="text-start">
                    応募方法
                </td>

                @php
                    $br_flg = false;
                @endphp
                <td class="text-start">
                    @if($job_information->tel != "")
                        TEL:{{$job_information->tel}}

                        @php
                            $br_flg = true;
                        @endphp
                    @endif

                    @if($job_information->fax != "")
                        @if($br_flg)<br>@endif
                        FAX:{{$job_information->fax}}

                        @php
                            $br_flg = true;
                        @endphp
                    @endif

                    @if($job_information->mailaddress != "")
                        @if($br_flg)<br>@endif
                        Mail:{{$job_information->mailaddress}}

                        @php
                            $br_flg = true;
                        @endphp
                    @endif
                    <br>
                    @if($br_flg)<br>@endif
                    {{$job_information->application_process}}              
                </td>
            </tr>

        </table>


        

        @if($job_information->employer_hp_url_qr_code != "")
            <img src="data:image/png;base64,{{ $job_information->employer_hp_url_qr_code }}" alt="QR Code">
        @endif
        
        @if($job_information->job_hp_url_qr_code != "")
            <img src="data:image/png;base64,{{ $job_information->job_hp_url_qr_code }}" alt="QR Code">
        @endif

        @if($job_information->job_information_detail_url_qr_code != "")
            <img src="data:image/png;base64,{{ $job_information->job_information_detail_url_qr_code }}" alt="QR Code">
        @endif
        

    </section>

</div>
@section('pagejs')

<script type="text/javascript">

$(function(){


    document.addEventListener('DOMContentLoaded', function() {
        const element = document.getElementById('subTitle');
        if (element) {
            let fontSize = 32; // 初期フォントサイズ
            while (element.scrollWidth > element.clientWidth && fontSize > 10) { 
                fontSize--; // フォントサイズを減らしていく
                element.style.fontSize = fontSize + 'px';
            }
        } else {
            console.error('Element with ID subTitle not found.');
        }
    });


    $(document).on("click", ".print-button", function (e) {

        window.print();

    })


});

</script>
@endsection

