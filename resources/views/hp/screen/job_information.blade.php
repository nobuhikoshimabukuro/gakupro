@extends('hp.common.layouts_app')

@section('pagehead')
@section('job-name', '求人情報')  
@endsection
@section('content')

<style>


.search-board{    
    position:fixed;
    padding: 3px;
    z-index: 999;    
	top:0;
    right: -120%;
	width:50%;
    height: 100vh;
	background:#eee9e9;
    /*動き*/
	transition: all 0.6s;    
}

/*アクティブクラスがついたら位置を0に*/
.active{
    right: 0;
}




.search-board-inner-area {
  width: 100%;
  margin: 0;
  flex-wrap: wrap;
  display: flex;
}
 
.tab_class {
  width: calc(100%/5);
  height: 50px;
  background-color: darkgrey;
  line-height: 50px;
  font-size: 15px;
  text-align: center;
  display: block;
  float: left;
  order: -1;
}
 
input[name="tab_name"] {
  display: none;
}
 
input:checked + .tab_class {
  background-color: cadetblue;
  color: aliceblue;
}
 
.content_class {
    display: none;
    width: 100%;   

    
}
 
input:checked + .tab_class + .content_class {
  display: block;
}




.municipality-check-area{
    overflow-y: auto;
    max-height: 100vh; /* 適切な高さを設定 */
    -webkit-overflow-scrolling: touch;   // 慣性スクロールを追加
}








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




/* PC用 */
@media (min-width:769px) {  /*画面幅が769px以上の場合とする*/
   .search-board{     
        width:50%;
    }
}



/* スマホ用 */
@media (max-width:768px) {  /*画面幅が768px以下の場合とする*/

    .search-board{     
        width:100%;
    }
}


</style>


{{-- 
<div class="search-board">

    <div class="row">
    
        <div class="col-12">
            <button type="button" class="btn-close search-board-close-button" ></button>
        </div>

        <i class="fas fa-map-marker-alt"></i>
    
        <div class="col-4">
            <select id='search_prefectural_cd' name='search_prefectural_cd' class='form-control input-sm'>
                <option value=''>未選択</option>
                    @foreach($prefectural_list as $prefectural_info)
                        <option value="{{$prefectural_info->prefectural_cd}}"
                            @if($search_element_array['search_prefectural_cd'] == $prefectural_info->prefectural_cd) selected @endif
                            title= "{{$prefectural_info->prefectural_name_kana}}"
                        >
                            {{$prefectural_info->prefectural_name}}
                        </option>
                    @endforeach
            </select>
        </div>
        
        <div class="col-4">
            <input type="text" id="search_municipality_name" name="" value="" class="form-control">
        </div>
        <div class="col-4">
            <select id='search_municipality_cd' name='search_municipality_cd' class='form-control input-sm'>  
                <option value=''>都道府県を選択してください</option>              
            </select>
        </div>
    </div>
</div> --}}



<div class="search-board">

    
    <div class="row">
        <div class="col-12">
            <button type="button" class="btn-close search-board-close-button" ></button>
        </div>
    </div>

    <div class="search-board-inner-area row">
        
        <input type="radio" name="tab_name" id="tab1" checked>
        <label class="tab_class" for="tab1">勤務地<i class="fas fa-map-marker-alt"></i></label>
        <div class="content_class">
          
            <table class="row">

                <tr>
                    <th>
                        都道府県を選択してください
                    </th>

                    <td>
                        <select id='search_prefectural_cd' name='search_prefectural_cd' class='form-control input-sm'>
                            <option value=''>未選択</option>
                                @foreach($prefectural_list as $prefectural_info)
                                    <option value="{{$prefectural_info->prefectural_cd}}"
                                        @if($search_element_array['search_prefectural_cd'] == $prefectural_info->prefectural_cd) selected @endif
                                        title= "{{$prefectural_info->prefectural_name_kana}}"
                                    >
                                        {{$prefectural_info->prefectural_name}}
                                    </option>
                                @endforeach
                        </select>
                    </td>
                </tr>


            </table>


            <div class="municipality-check-area row">
                
                
            </div>


                
               
            


            

        </div>


        <input type="radio" name="tab_name" id="tab2" >
        <label class="tab_class" for="tab2">タブ2</label>
        <div class="content_class">
          <p>タブ2のコンテンツを表示します</p>
        </div>


        <input type="radio" name="tab_name" id="tab3" >
        <label class="tab_class" for="tab3">タブ3</label>
        <div class="content_class">
          <p>タブ3のコンテンツを表示します</p>
        </div>


        <input type="radio" name="tab_name" id="tab4" >
        <label class="tab_class" for="tab4">タブ4</label>
        <div class="content_class">
          <p>タブ4のコンテンツを表示します</p>
        </div>

        <input type="radio" name="tab_name" id="tab5" >
        <label class="tab_class" for="tab5">タブ5</label>
        <div class="content_class">
          <p>タブ5のコンテンツを表示します</p>
        </div>
        
        
        
      </div>
</div>

<div id="main" class="mt-3 text-center container">




    <button type="button" class="btn btn-success search-board-open-button">
        条件検索
    </button>





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

    

    $(document).on("click", ".search-board-open-button", function (e) {
        $(".search-board").addClass('active');
    });

    $(document).on("click", ".search-board-close-button", function (e) {
        $(".search-board").removeClass('active');
    });

    
    $('.job-detail').click(function () {
        
        var job_number = $(this).data('jobnumber');
        var url = '{{ route('hp.job_information_detail') }}' + "?job_number=" + job_number;
        window.open(url, '_blank');

    });


    //取引先検索処理
    $(document).on("change", "#search_prefectural_cd", function (e) {

        search_prefectural();

    });

    $(document).on("blur", "#search_municipality_name", function (e) {

        search_prefectural();        

    });



    function search_prefectural(){

        var prefectural_cd = $("#search_prefectural_cd").val();        
        // var municipality_name = $("#search_municipality_name").val();
        var municipality_name = "";
        var target_select = "#search_municipality_cd";
        var url = "{{ route('create_list.municipality_list_ajax') }}";


        //プルダウン内の設定初期化
        // $("select" + target_select + " option").remove();

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

                    // // オプション要素を作成し、valueとtext属性を設定
                    // var option = $("<option>").val(municipality_cd).text(municipality_name);

                    // // title属性を追加
                    // option.attr("title", municipality_name_kana);
                    
                    // // セレクトボックスにオプションを追加
                    // $(target_select).append(option);
                    

                    add_html += '<div id="" class="col-4 mt-2 p-0">';
                    add_html += '<label for="municipality_cd_'+  municipality_cd + '" class="d-block">';
                    add_html += '<input type="checkbox" id="municipality_cd_'+  municipality_cd + '" ';
                    add_html += 'name="municipality_cd_'+  municipality_cd + '"';
                    add_html += '>'+  municipality_name;
                    add_html += '</label>';                
                    add_html += '</div>';             

                })

                $('.municipality-check-area').html(add_html);


            }else{

                


            }

            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';

        })
        .fail(function (data, textStatus, errorThrown) {
        

        
            //マウスカーソルを通常に
            document.body.style.cursor = 'auto';

        });

    }




});

</script>
@endsection

